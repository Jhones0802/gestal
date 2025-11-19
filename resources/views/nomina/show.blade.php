<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalle de Nómina') }}
            </h2>
            <div class="flex space-x-2">
                @if($nomina->puedeCalcularse() || $nomina->estado === 'borrador')
                    <a href="{{ route('nomina.edit', $nomina) }}" 
                       class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                        Editar
                    </a>
                @endif
                <a href="{{ route('nomina.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

         <!-- Mensajes de éxito/error -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                    <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                    <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif
            
            <!-- Estado y Acciones -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">
                                Nómina - {{ $nomina->periodo_formateado }}
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $nomina->empleado->nombre_completo }} - {{ $nomina->empleado->cargo }}
                            </p>
                        </div>
                        <div>
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-{{ $nomina->estado_color }}-100 text-{{ $nomina->estado_color }}-800">
                                {{ $nomina->estado_label }}
                            </span>
                        </div>
                    </div>

                    <!-- Acciones según estado -->
                    <div class="mt-6 flex space-x-3">
                        @if($nomina->puedeCalcularse())
                            <form method="POST" action="{{ route('nomina.calcular', $nomina) }}">
                                @csrf
                                <button type="submit" 
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    🧮 Calcular Nómina
                                </button>
                            </form>
                        @endif

                        @if($nomina->puedeAprobarse())
                            <form method="POST" action="{{ route('nomina.aprobar', $nomina) }}">
                                @csrf
                                <button type="submit" 
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                                        onclick="return confirm('¿Está seguro de aprobar esta nómina?')">
                                    ✅ Aprobar Nómina
                                </button>
                            </form>
                        @endif

                        @if($nomina->puedePagarse())
                            <form method="POST" action="{{ route('nomina.pagar', $nomina) }}">
                                @csrf
                                <button type="submit" 
                                        class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded"
                                        onclick="return confirm('¿Confirma que esta nómina ha sido pagada?')">
                                    💰 Marcar como Pagada
                                </button>
                            </form>
                        @endif

                        @if($nomina->estado === 'aprobada' || $nomina->estado === 'pagada')
                            <a href="{{ route('nomina.desprendible', $nomina) }}" 
                               class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                📄 Descargar Desprendible
                            </a>
                        @endif

                        @if($nomina->puedeAnularse())
                            <form method="POST" action="{{ route('nomina.anular', $nomina) }}">
                                @csrf
                                <button type="submit" 
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                        onclick="return confirm('¿Está seguro de anular esta nómina? Esta acción no se puede deshacer.')">
                                    ❌ Anular
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Información del Periodo -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Información del Periodo</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Periodo</p>
                            <p class="text-base font-medium">{{ $nomina->periodo_formateado }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Fecha Inicio</p>
                            <p class="text-base font-medium">{{ $nomina->fecha_inicio_periodo->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Fecha Fin</p>
                            <p class="text-base font-medium">{{ $nomina->fecha_fin_periodo->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Fecha Pago</p>
                            <p class="text-base font-medium text-green-600 font-semibold">{{ $nomina->fecha_pago->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del Empleado -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Información del Empleado</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Nombre Completo</p>
                            <p class="text-base font-medium">{{ $nomina->empleado->nombre_completo }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Cédula</p>
                            <p class="text-base font-medium">{{ $nomina->empleado->cedula }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Cargo</p>
                            <p class="text-base font-medium">{{ $nomina->empleado->cargo }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Área</p>
                            <p class="text-base font-medium">{{ $nomina->empleado->area }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tipo Contrato</p>
                            <p class="text-base font-medium">{{ ucfirst($nomina->empleado->tipo_contrato) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Salario Base</p>
                            <p class="text-base font-medium text-blue-600">${{ number_format($nomina->salario_basico, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Devengados -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded mr-2">+</span>
                        Devengados
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <tbody class="divide-y divide-gray-200">
                                <tr>
                                    <td class="py-3 text-sm text-gray-900">Salario Básico</td>
                                    <td class="py-3 text-sm text-right font-medium">${{ number_format($nomina->salario_basico, 0, ',', '.') }}</td>
                                </tr>
                                @if($nomina->auxilio_transporte > 0)
                                <tr>
                                    <td class="py-3 text-sm text-gray-900">Auxilio de Transporte</td>
                                    <td class="py-3 text-sm text-right font-medium">${{ number_format($nomina->auxilio_transporte, 0, ',', '.') }}</td>
                                </tr>
                                @endif
                                @if($nomina->horas_extras > 0)
                                <tr>
                                    <td class="py-3 text-sm text-gray-900">Horas Extras</td>
                                    <td class="py-3 text-sm text-right font-medium">${{ number_format($nomina->horas_extras, 0, ',', '.') }}</td>
                                </tr>
                                @endif
                                @if($nomina->recargos_nocturnos > 0)
                                <tr>
                                    <td class="py-3 text-sm text-gray-900">Recargos Nocturnos</td>
                                    <td class="py-3 text-sm text-right font-medium">${{ number_format($nomina->recargos_nocturnos, 0, ',', '.') }}</td>
                                </tr>
                                @endif
                                @if($nomina->dominicales_festivos > 0)
                                <tr>
                                    <td class="py-3 text-sm text-gray-900">Dominicales y Festivos</td>
                                    <td class="py-3 text-sm text-right font-medium">${{ number_format($nomina->dominicales_festivos, 0, ',', '.') }}</td>
                                </tr>
                                @endif
                                @if($nomina->comisiones > 0)
                                <tr>
                                    <td class="py-3 text-sm text-gray-900">Comisiones</td>
                                    <td class="py-3 text-sm text-right font-medium">${{ number_format($nomina->comisiones, 0, ',', '.') }}</td>
                                </tr>
                                @endif
                                @if($nomina->bonificaciones > 0)
                                <tr>
                                    <td class="py-3 text-sm text-gray-900">Bonificaciones</td>
                                    <td class="py-3 text-sm text-right font-medium">${{ number_format($nomina->bonificaciones, 0, ',', '.') }}</td>
                                </tr>
                                @endif
                                @if($nomina->otros_devengados > 0)
                                <tr>
                                    <td class="py-3 text-sm text-gray-900">Otros Devengados</td>
                                    <td class="py-3 text-sm text-right font-medium">${{ number_format($nomina->otros_devengados, 0, ',', '.') }}</td>
                                </tr>
                                @endif
                                <tr class="bg-green-50 font-bold">
                                    <td class="py-3 text-base text-green-900">TOTAL DEVENGADOS</td>
                                    <td class="py-3 text-base text-right text-green-900">${{ number_format($nomina->total_devengados, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Deducciones -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded mr-2">-</span>
                        Deducciones
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <tbody class="divide-y divide-gray-200">
                                @if($nomina->salud_empleado > 0)
                                <tr>
                                    <td class="py-3 text-sm text-gray-900">Salud (4%)</td>
                                    <td class="py-3 text-sm text-right font-medium">${{ number_format($nomina->salud_empleado, 0, ',', '.') }}</td>
                                </tr>
                                @endif
                                @if($nomina->pension_empleado > 0)
                                <tr>
                                    <td class="py-3 text-sm text-gray-900">Pensión (4%)</td>
                                    <td class="py-3 text-sm text-right font-medium">${{ number_format($nomina->pension_empleado, 0, ',', '.') }}</td>
                                </tr>
                                @endif
                                @if($nomina->solidaridad_pensional > 0)
                                <tr>
                                    <td class="py-3 text-sm text-gray-900">Solidaridad Pensional (1%)</td>
                                    <td class="py-3 text-sm text-right font-medium">${{ number_format($nomina->solidaridad_pensional, 0, ',', '.') }}</td>
                                </tr>
                                @endif
                                @if($nomina->retencion_fuente > 0)
                                <tr>
                                    <td class="py-3 text-sm text-gray-900">Retención en la Fuente</td>
                                    <td class="py-3 text-sm text-right font-medium">${{ number_format($nomina->retencion_fuente, 0, ',', '.') }}</td>
                                </tr>
                                @endif
                                @if($nomina->prestamos > 0)
                                <tr>
                                    <td class="py-3 text-sm text-gray-900">Préstamos</td>
                                    <td class="py-3 text-sm text-right font-medium">${{ number_format($nomina->prestamos, 0, ',', '.') }}</td>
                                </tr>
                                @endif
                                @if($nomina->embargos > 0)
                                <tr>
                                    <td class="py-3 text-sm text-gray-900">Embargos</td>
                                    <td class="py-3 text-sm text-right font-medium">${{ number_format($nomina->embargos, 0, ',', '.') }}</td>
                                </tr>
                                @endif
                                @if($nomina->otros_descuentos > 0)
                                <tr>
                                    <td class="py-3 text-sm text-gray-900">Otros Descuentos</td>
                                    <td class="py-3 text-sm text-right font-medium">${{ number_format($nomina->otros_descuentos, 0, ',', '.') }}</td>
                                </tr>
                                @endif
                                <tr class="bg-red-50 font-bold">
                                    <td class="py-3 text-base text-red-900">TOTAL DEDUCCIONES</td>
                                    <td class="py-3 text-base text-right text-red-900">${{ number_format($nomina->total_deducciones, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Neto a Pagar -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm opacity-90">NETO A PAGAR</p>
                            <p class="text-3xl font-bold mt-1">${{ number_format($nomina->neto_pagar, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs opacity-75">Total Devengados</p>
                            <p class="text-lg">${{ number_format($nomina->total_devengados, 0, ',', '.') }}</p>
                            <p class="text-xs opacity-75 mt-2">Total Deducciones</p>
                            <p class="text-lg">-${{ number_format($nomina->total_deducciones, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aportes Patronales y Provisiones -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Aportes Patronales -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Aportes Patronales</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span>Salud (8.5%)</span>
                                <span class="font-medium">${{ number_format($nomina->salud_patronal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Pensión (12%)</span>
                                <span class="font-medium">${{ number_format($nomina->pension_patronal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>ARL</span>
                                <span class="font-medium">${{ number_format($nomina->arl, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Caja Compensación (4%)</span>
                                <span class="font-medium">${{ number_format($nomina->caja_compensacion, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>ICBF (3%)</span>
                                <span class="font-medium">${{ number_format($nomina->icbf, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>SENA (2%)</span>
                                <span class="font-medium">${{ number_format($nomina->sena, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-base font-bold text-blue-600 pt-2 border-t">
                                <span>Total Aportes</span>
                                <span>${{ number_format($nomina->total_aportes_patronales, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Provisiones -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Provisiones</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span>Cesantías (8.33%)</span>
                                <span class="font-medium">${{ number_format($nomina->cesantias, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Intereses Cesantías (1%)</span>
                                <span class="font-medium">${{ number_format($nomina->intereses_cesantias, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Prima de Servicios (8.33%)</span>
                                <span class="font-medium">${{ number_format($nomina->prima_servicios, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Vacaciones (4.17%)</span>
                                <span class="font-medium">${{ number_format($nomina->vacaciones, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-base font-bold text-purple-600 pt-2 border-t">
                                <span>Total Provisiones</span>
                                <span>${{ number_format($nomina->total_provisiones, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Costo Total Empresa -->
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                    <div class="text-center">
                        <p class="text-sm opacity-90">COSTO TOTAL PARA LA EMPRESA</p>
                        <p class="text-4xl font-bold mt-2">${{ number_format($nomina->costo_total_empresa, 0, ',', '.') }}</p>
                        <p class="text-xs opacity-75 mt-2">Incluye: Neto a pagar + Aportes patronales + Provisiones</p>
                    </div>
                </div>
            </div>

            <!-- Observaciones -->
            @if($nomina->observaciones)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Observaciones</h3>
                    <p class="text-sm text-gray-600">{{ $nomina->observaciones }}</p>
                </div>
            </div>
            @endif

            <!-- Información de Control -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Información de Control</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        @if($nomina->calculada_by)
                        <div>
                            <p class="text-gray-500">Calculada por</p>
                            <p class="font-medium">{{ $nomina->calculadaPor->name ?? 'Sistema' }}</p>
                            <p class="text-xs text-gray-400">{{ $nomina->fecha_calculo?->format('d/m/Y H:i') }}</p>
                        </div>
                        @endif
                        @if($nomina->aprobada_by)
                        <div>
                            <p class="text-gray-500">Aprobada por</p>
                            <p class="font-medium">{{ $nomina->aprobadaPor->name ?? 'Sistema' }}</p>
                            <p class="text-xs text-gray-400">{{ $nomina->fecha_aprobacion?->format('d/m/Y H:i') }}</p>
                        </div>
                        @endif
                        <div>
                            <p class="text-gray-500">Creada</p>
                            <p class="text-xs text-gray-600">{{ $nomina->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Última actualización</p>
                            <p class="text-xs text-gray-600">{{ $nomina->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>