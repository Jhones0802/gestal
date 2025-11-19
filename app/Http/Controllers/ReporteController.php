<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Nomina;
use App\Models\Capacitacion;
use App\Models\Vacante;
use App\Models\Candidato;
use App\Models\Afiliacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function index()
    {
        // Dashboard principal de reportes con estadísticas generales
        $estadisticas = [
            'empleados' => [
                'total' => Empleado::count(),
                'activos' => Empleado::where('estado', 'activo')->count(),
                'inactivos' => Empleado::where('estado', 'inactivo')->count(),
                'por_area' => Empleado::select('area', DB::raw('count(*) as total'))
                    ->where('estado', 'activo')
                    ->whereNotNull('area')
                    ->groupBy('area')
                    ->get(),
                'por_tipo_contrato' => Empleado::select('tipo_contrato', DB::raw('count(*) as total'))
                    ->where('estado', 'activo')
                    ->whereNotNull('tipo_contrato')
                    ->groupBy('tipo_contrato')
                    ->get(),
            ],
            'nomina' => [
                'total_mes_actual' => Nomina::whereYear('periodo', now()->year)
                    ->whereMonth('periodo', now()->month)
                    ->sum('neto_pagar'),
                'total_año' => Nomina::whereYear('periodo', now()->year)->sum('neto_pagar'),
                'por_mes' => Nomina::select(
                        DB::raw('MONTH(periodo) as mes'),
                        DB::raw('SUM(neto_pagar) as total')
                    )
                    ->whereYear('periodo', now()->year)
                    ->groupBy('mes')
                    ->orderBy('mes')
                    ->get(),
            ],
            'capacitaciones' => [
                'total' => Capacitacion::count(),
                'programadas' => Capacitacion::where('estado', 'programada')->count(),
                'completadas' => Capacitacion::where('estado', 'completada')->count(),
                'total_participantes' => DB::table('capacitacion_empleado')->count(),
                'por_tipo' => Capacitacion::select('tipo', DB::raw('count(*) as total'))
                    ->groupBy('tipo')
                    ->get(),
            ],
            'seleccion' => [
                'vacantes_activas' => Vacante::where('estado', 'abierta')->count(),
                'total_candidatos' => Candidato::count(),
                'candidatos_por_estado' => Candidato::select('estado', DB::raw('count(*) as total'))
                    ->groupBy('estado')
                    ->get(),
            ],
            'afiliaciones' => [
                'total' => Afiliacion::count(),
                'completadas' => Afiliacion::where('estado', 'completada')->count(),
                'pendientes' => Afiliacion::where('estado', 'pendiente')->count(),
            ]
        ];

        return view('reportes.index', compact('estadisticas'));
    }

    public function empleados(Request $request)
    {
        $query = Empleado::query();

        // Filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('area')) {
            $query->where('area', $request->area);
        }

        if ($request->filled('tipo_contrato')) {
            $query->where('tipo_contrato', $request->tipo_contrato);
        }

        if ($request->filled('fecha_desde')) {
            $query->where('fecha_ingreso', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->where('fecha_ingreso', '<=', $request->fecha_hasta);
        }

        $empleados = $query->orderBy('nombres')->get();

        // Estadísticas del reporte
        $estadisticas = [
            'total' => $empleados->count(),
            'salario_promedio' => $empleados->avg('salario'),
            'salario_total' => $empleados->sum('salario'),
        ];

        $areas = Empleado::distinct()->whereNotNull('area')->pluck('area')->filter();
        $tiposContrato = Empleado::distinct()->whereNotNull('tipo_contrato')->pluck('tipo_contrato')->filter();

        if ($request->has('export') && $request->export === 'excel') {
            return $this->exportarEmpleadosExcel($empleados);
        }

        return view('reportes.empleados', compact('empleados', 'estadisticas', 'areas', 'tiposContrato'));
    }

    public function nomina(Request $request)
    {
        $query = Nomina::with('empleado');

        // Filtros
        if ($request->filled('año')) {
            $query->whereYear('periodo', $request->año);
        } else {
            $query->whereYear('periodo', now()->year);
        }

        if ($request->filled('mes')) {
            $query->whereMonth('periodo', $request->mes);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $nominas = $query->orderBy('periodo', 'desc')->get();

        // Estadísticas
        $estadisticas = [
            'total_nominas' => $nominas->count(),
            'total_salarios' => $nominas->sum('salario_basico'),
            'total_devengado' => $nominas->sum('total_devengados'),
            'total_deducciones' => $nominas->sum('total_deducciones'),
            'total_pagar' => $nominas->sum('neto_pagar'),
            'promedio_pagar' => $nominas->avg('neto_pagar'),
        ];

        if ($request->has('export') && $request->export === 'excel') {
            return $this->exportarNominaExcel($nominas);
        }

        return view('reportes.nomina', compact('nominas', 'estadisticas'));
    }

    public function capacitaciones(Request $request)
    {
        $query = Capacitacion::with('empleados');

        // Filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('fecha_desde')) {
            $query->where('fecha_inicio', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->where('fecha_fin', '<=', $request->fecha_hasta);
        }

        $capacitaciones = $query->orderBy('fecha_inicio', 'desc')->get();

        // Estadísticas
        $estadisticas = [
            'total' => $capacitaciones->count(),
            'total_participantes' => $capacitaciones->sum(function($c) {
                return $c->inscritos_count;
            }),
            'total_horas' => $capacitaciones->sum('duracion_horas'),
            'promedio_participantes' => $capacitaciones->avg(function($c) {
                return $c->inscritos_count;
            }),
            'costo_total' => $capacitaciones->sum('costo'),
        ];

        if ($request->has('export') && $request->export === 'excel') {
            return $this->exportarCapacitacionesExcel($capacitaciones);
        }

        return view('reportes.capacitaciones', compact('capacitaciones', 'estadisticas'));
    }

    public function seleccion(Request $request)
    {
        $vacantes = Vacante::with('candidatos')->orderBy('created_at', 'desc')->get();
        $candidatos = Candidato::with('vacante')->orderBy('created_at', 'desc')->get();

        // Estadísticas
        $estadisticas = [
            'total_vacantes' => $vacantes->count(),
            'vacantes_abiertas' => $vacantes->where('estado', 'abierta')->count(),
            'vacantes_cerradas' => $vacantes->where('estado', 'cerrada')->count(),
            'total_candidatos' => $candidatos->count(),
            'candidatos_por_estado' => [
                'nuevo' => $candidatos->where('estado', 'nuevo')->count(),
                'en_revision' => $candidatos->where('estado', 'en_revision')->count(),
                'entrevista' => $candidatos->where('estado', 'entrevista')->count(),
                'seleccionado' => $candidatos->where('estado', 'seleccionado')->count(),
                'rechazado' => $candidatos->where('estado', 'rechazado')->count(),
            ],
            'tasa_conversion' => $candidatos->count() > 0
                ? round(($candidatos->where('estado', 'seleccionado')->count() / $candidatos->count()) * 100, 2)
                : 0,
        ];

        if ($request->has('export') && $request->export === 'excel') {
            return $this->exportarSeleccionExcel($vacantes, $candidatos);
        }

        return view('reportes.seleccion', compact('vacantes', 'candidatos', 'estadisticas'));
    }

    // Métodos de exportación a Excel/CSV
    private function exportarEmpleadosExcel($empleados)
    {
        $csv = "Nombre,Cédula,Cargo,Área,Salario,Fecha Ingreso,Estado\n";

        foreach ($empleados as $empleado) {
            $csv .= "\"{$empleado->nombre_completo}\",\"{$empleado->cedula}\",\"{$empleado->cargo}\",\"{$empleado->area}\",\"{$empleado->salario}\",\"{$empleado->fecha_ingreso->format('d/m/Y')}\",\"{$empleado->estado}\"\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="reporte_empleados_' . date('Y-m-d') . '.csv"');
    }

    private function exportarNominaExcel($nominas)
    {
        $csv = "Empleado,Cédula,Periodo,Salario Base,Total Devengado,Total Deducciones,Total a Pagar,Estado\n";

        foreach ($nominas as $nomina) {
            $csv .= "\"{$nomina->empleado->nombre_completo}\",\"{$nomina->empleado->cedula}\",\"{$nomina->periodo}\",\"{$nomina->salario_basico}\",\"{$nomina->total_devengados}\",\"{$nomina->total_deducciones}\",\"{$nomina->neto_pagar}\",\"{$nomina->estado}\"\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="reporte_nomina_' . date('Y-m-d') . '.csv"');
    }

    private function exportarCapacitacionesExcel($capacitaciones)
    {
        $csv = "Título,Tipo,Instructor,Fecha,Participantes,Duración (hrs),Costo,Estado\n";

        foreach ($capacitaciones as $capacitacion) {
            $csv .= "\"{$capacitacion->titulo}\",\"{$capacitacion->tipo}\",\"{$capacitacion->instructor}\",\"{$capacitacion->fecha_formateada}\",\"{$capacitacion->inscritos_count}\",\"{$capacitacion->duracion_horas}\",\"{$capacitacion->costo}\",\"{$capacitacion->estado_texto}\"\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="reporte_capacitaciones_' . date('Y-m-d') . '.csv"');
    }

    private function exportarSeleccionExcel($vacantes, $candidatos)
    {
        $csv = "Tipo,Título/Nombre,Cargo,Estado,Fecha\n";

        foreach ($vacantes as $vacante) {
            $csv .= "\"Vacante\",\"{$vacante->titulo}\",\"{$vacante->cargo}\",\"{$vacante->estado}\",\"{$vacante->created_at->format('d/m/Y')}\"\n";
        }

        foreach ($candidatos as $candidato) {
            $csv .= "\"Candidato\",\"{$candidato->nombres} {$candidato->apellidos}\",\"{$candidato->vacante->cargo}\",\"{$candidato->estado}\",\"{$candidato->created_at->format('d/m/Y')}\"\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="reporte_seleccion_' . date('Y-m-d') . '.csv"');
    }
}
