<?php

namespace App\Http\Controllers;

use App\Models\Nomina;
use App\Models\Empleado;
use App\Services\NominaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class NominaController extends Controller
{
    protected $nominaService;

    public function __construct(NominaService $nominaService)
    {
        $this->nominaService = $nominaService;
    }

    public function index(Request $request)
    {
        $query = Nomina::with(['empleado', 'calculadaPor', 'aprobadaPor']);

        // Filtros
        if ($request->filled('periodo')) {
            $query->where('periodo', $request->periodo);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('empleado_id')) {
            $query->where('empleado_id', $request->empleado_id);
        }

        $nominas = $query->orderBy('periodo', 'desc')
                        ->orderBy('empleado_id')
                        ->paginate(15);

        // Datos para filtros
        $empleados = Empleado::activos()->orderBy('nombres')->get();
        $periodos = Nomina::distinct()
                         ->orderBy('periodo', 'desc')
                         ->pluck('periodo')
                         ->take(12);

        // Estadísticas del periodo actual
        $periodoActual = now()->format('Y-m');
        $estadisticas = $this->getEstadisticasPeriodo($periodoActual);

        return view('nomina.index', compact(
            'nominas', 
            'empleados', 
            'periodos', 
            'estadisticas'
        ));
    }

    public function create(Request $request)
    {
        $empleados = Empleado::activos()->orderBy('nombres')->get();
        $periodoSugerido = now()->format('Y-m');
        
        return view('nomina.create', compact('empleados', 'periodoSugerido'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'periodo' => 'required|string|regex:/^\d{4}-\d{2}$/',
            'tipo_creacion' => 'required|in:individual,masivo',
            'empleado_id' => 'required_if:tipo_creacion,individual|exists:empleados,id',
        ]);

        if ($validated['tipo_creacion'] === 'individual') {
            $empleado = Empleado::findOrFail($validated['empleado_id']);
            
            // Verificar si existe una nómina anulada y eliminarla
            $nominaAnulada = Nomina::where('empleado_id', $empleado->id)
                                ->where('periodo', $validated['periodo'])
                                ->where('estado', 'anulada')
                                ->first();
            
            if ($nominaAnulada) {
                $nominaAnulada->delete(); // Eliminar la anulada
            }
            
            // Verificar que no exista una nómina ACTIVA
            $existente = Nomina::where('empleado_id', $empleado->id)
                            ->where('periodo', $validated['periodo'])
                            ->where('estado', '!=', 'anulada')
                            ->first();

            if ($existente) {
                return redirect()->back()
                    ->with('error', '⚠️ Ya existe una nómina activa para este empleado en el periodo seleccionado.');
            }

            $fechas = $this->calcularFechasPeriodo($validated['periodo']);
            
            $nomina = Nomina::create([
                'empleado_id' => $empleado->id,
                'periodo' => $validated['periodo'],
                'fecha_inicio_periodo' => $fechas['inicio'],
                'fecha_fin_periodo' => $fechas['fin'],
                'fecha_pago' => $fechas['pago'],
                'salario_basico' => $empleado->salario,
                'estado' => 'borrador',
                'total_devengados' => 0,
                'total_deducciones' => 0,
                'total_aportes_patronales' => 0,
                'total_provisiones' => 0,
                'neto_pagar' => 0,
                'costo_total_empresa' => 0,
            ]);

            return redirect()->route('nomina.index')
                ->with('success', "✅ Nómina creada exitosamente para {$empleado->nombre_completo}. Ya puede editarla y calcularla.");
        } else {
            // Creación masiva - eliminar todas las anuladas del periodo primero
            Nomina::where('periodo', $validated['periodo'])
                ->where('estado', 'anulada')
                ->delete();
            
            $nominasCreadas = $this->nominaService->crearNominasPeriodo($validated['periodo']);
            
            if (empty($nominasCreadas)) {
                return redirect()->back()
                    ->with('error', '⚠️ No se crearon nóminas. Es posible que ya existan para el periodo seleccionado.');
            }

            $cantidad = count($nominasCreadas);
            return redirect()->route('nomina.index')
                ->with('success', "✅ Se crearon {$cantidad} nóminas exitosamente para el periodo {$validated['periodo']}. Ya puede proceder a calcularlas.");
        }
    }

    public function show(Nomina $nomina)
    {
        $nomina->load(['empleado', 'calculadaPor', 'aprobadaPor']);
        return view('nomina.show', compact('nomina'));
    }

    public function edit(Nomina $nomina)
    {
        if (!$nomina->puedeCalcularse() && !$nomina->puedeAprobarse()) {
            return redirect()->route('nomina.show', $nomina)
                ->with('error', 'Esta nómina no puede editarse en su estado actual.');
        }

        return view('nomina.edit', compact('nomina'));
    }

    public function update(Request $request, Nomina $nomina)
    {
        if (!$nomina->puedeCalcularse()) {
            return redirect()->back()
                ->with('error', 'Esta nómina no puede modificarse en su estado actual.');
        }

        $validated = $request->validate([
            'horas_extras' => 'nullable|numeric|min:0',
            'recargos_nocturnos' => 'nullable|numeric|min:0',
            'dominicales_festivos' => 'nullable|numeric|min:0',
            'comisiones' => 'nullable|numeric|min:0',
            'bonificaciones' => 'nullable|numeric|min:0',
            'otros_devengados' => 'nullable|numeric|min:0',
            'prestamos' => 'nullable|numeric|min:0',
            'embargos' => 'nullable|numeric|min:0',
            'otros_descuentos' => 'nullable|numeric|min:0',
            'observaciones' => 'nullable|string|max:1000'
        ]);

        // Actualizar campos editables
        $nomina->update($validated);

        return redirect()->route('nomina.edit', $nomina)
            ->with('success', 'Datos actualizados. Recalcule la nómina para aplicar los cambios.');
    }

    public function calcular(Nomina $nomina)
    {
        if (!$nomina->puedeCalcularse()) {
            return redirect()->back()
                ->with('error', 'Esta nómina no puede calcularse en su estado actual.');
        }

        try {
            $this->nominaService->calcularNomina($nomina);
            $nomina->save();

            return redirect()->route('nomina.show', $nomina)
                ->with('success', 'Nómina calculada exitosamente. Revise los valores antes de aprobar.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al calcular la nómina: ' . $e->getMessage());
        }
    }

    public function aprobar(Nomina $nomina)
    {
        if (!$nomina->puedeAprobarse()) {
            return redirect()->back()
                ->with('error', 'Esta nómina no puede aprobarse en su estado actual.');
        }

        $nomina->update([
            'estado' => 'aprobada',
            'fecha_aprobacion' => now(),
            'aprobada_by' => Auth::id()
        ]);

        return redirect()->route('nomina.show', $nomina)
            ->with('success', 'Nómina aprobada exitosamente. Ya puede proceder al pago.');
    }

    public function pagar(Nomina $nomina)
    {
        if (!$nomina->puedePagarse()) {
            return redirect()->back()
                ->with('error', 'Esta nómina no puede marcarse como pagada en su estado actual.');
        }

        $nomina->update([
            'estado' => 'pagada'
        ]);

        return redirect()->route('nomina.show', $nomina)
            ->with('success', 'Nómina marcada como pagada exitosamente.');
    }

    public function anular(Nomina $nomina)
    {
        if (!$nomina->puedeAnularse()) {
            return redirect()->back()
                ->with('error', 'Esta nómina no puede anularse en su estado actual.');
        }

        $nomina->update([
            'estado' => 'anulada'
        ]);

        return redirect()->route('nomina.index')
            ->with('success', 'Nómina anulada exitosamente.');
    }

    public function desprendible(Nomina $nomina)
    {
        // Solo se puede generar si está aprobada o pagada
        if (!in_array($nomina->estado, ['aprobada', 'pagada'])) {
            return redirect()->back()
                ->with('error', '⚠️ Solo puede generar desprendibles de nóminas aprobadas o pagadas.');
        }

        try {
            $pdf = PDF::loadView('nomina.desprendible', compact('nomina'));
            
            $nombreArchivo = "desprendible_{$nomina->empleado->cedula}_{$nomina->periodo}.pdf";
            
            return $pdf->download($nombreArchivo);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', '❌ Error al generar el desprendible: ' . $e->getMessage());
        }
    }

    private function calcularFechasPeriodo(string $periodo): array
    {
        $fecha = Carbon::createFromFormat('Y-m', $periodo);
        
        return [
            'inicio' => $fecha->copy()->startOfMonth(),
            'fin' => $fecha->copy()->endOfMonth(),
            'pago' => $fecha->copy()->endOfMonth()->addDay()
        ];
    }

    private function getEstadisticasPeriodo(string $periodo): array
    {
        return [
            'total' => Nomina::where('periodo', $periodo)->count(),
            'borradores' => Nomina::where('periodo', $periodo)->where('estado', 'borrador')->count(),
            'calculadas' => Nomina::where('periodo', $periodo)->where('estado', 'calculada')->count(),
            'aprobadas' => Nomina::where('periodo', $periodo)->where('estado', 'aprobada')->count(),
            'pagadas' => Nomina::where('periodo', $periodo)->where('estado', 'pagada')->count(),
            'total_pagar' => Nomina::where('periodo', $periodo)
                                  ->where('estado', 'aprobada')
                                  ->sum('neto_pagar'),
            'costo_total' => Nomina::where('periodo', $periodo)
                                  ->whereIn('estado', ['aprobada', 'pagada'])
                                  ->sum('costo_total_empresa')
        ];
    }

    
}