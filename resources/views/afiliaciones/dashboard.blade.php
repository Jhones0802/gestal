<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard de Afiliaciones') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('afiliaciones.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Ver Todas
                </a>
                <a href="{{ route('afiliaciones.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Nueva Afiliación
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Estadísticas Generales -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Total Afiliaciones</div>
                                <div class="text-3xl font-bold text-gray-900">{{ $estadisticas['total'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">En Proceso</div>
                                <div class="text-3xl font-bold text-gray-900">{{ $estadisticas['en_proceso'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Completadas</div>
                                <div class="text-3xl font-bold text-gray-900">{{ $estadisticas['completadas'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Vencidas</div>
                                <div class="text-3xl font-bold text-gray-900">{{ $estadisticas['vencidas'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas por Entidad -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Afiliaciones por Entidad</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-4 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-blue-100 text-sm font-medium">EPS</p>
                                    <p class="text-2xl font-bold">{{ $estadisticas['por_entidad']['eps'] }}</p>
                                </div>
                                <div class="w-12 h-12 bg-blue-400 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-4 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-green-100 text-sm font-medium">ARL</p>
                                    <p class="text-2xl font-bold">{{ $estadisticas['por_entidad']['arl'] }}</p>
                                </div>
                                <div class="w-12 h-12 bg-green-400 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-4 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-purple-100 text-sm font-medium">Caja Compensación</p>
                                    <p class="text-2xl font-bold">{{ $estadisticas['por_entidad']['caja_compensacion'] }}</p>
                                </div>
                                <div class="w-12 h-12 bg-purple-400 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg p-4 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-orange-100 text-sm font-medium">Fondo Pensiones</p>
                                    <p class="text-2xl font-bold">{{ $estadisticas['por_entidad']['fondo_pensiones'] }}</p>
                                </div>
                                <div class="w-12 h-12 bg-orange-400 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alertas y Afiliaciones Recientes -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Alertas -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Alertas Importantes</h3>
                        @if($alertas->count() > 0)
                            <div class="space-y-3">
                                @foreach($alertas as $alerta)
                                    <div class="flex items-start p-3 border border-red-200 bg-red-50 rounded-lg">
                                        <div class="flex-shrink-0">
                                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <h4 class="text-sm font-medium text-red-800">
                                                {{ $alerta->empleado->nombres }} {{ $alerta->empleado->apellidos }}
                                            </h4>
                                            <p class="text-sm text-red-700">
                                                {{ $alerta->entidad_tipo_label }} - {{ $alerta->entidad_nombre }}
                                            </p>
                                            <p class="text-xs text-red-600">
                                                Vence: {{ $alerta->fecha_respuesta_estimada->format('d/m/Y') }}
                                            </p>
                                        </div>
                                        <div class="ml-3">
                                            <a href="{{ route('afiliaciones.show', $alerta) }}" 
                                               class="text-red-600 hover:text-red-900 text-sm font-medium">
                                                Ver
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-6">
                                <svg class="mx-auto h-12 w-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">No hay alertas pendientes</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Afiliaciones Recientes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Actividad Reciente</h3>
                            <a href="{{ route('afiliaciones.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Ver todas
                            </a>
                        </div>
                        @if($afiliacionesRecientes->count() > 0)
                            <div class="flow-root">
                                <ul class="-mb-8">
                                    @foreach($afiliacionesRecientes as $afiliacion)
                                        <li>
                                            <div class="relative pb-8">
                                                @if(!$loop->last)
                                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                                @endif
                                                <div class="relative flex space-x-3">
                                                    <div>
                                                        <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white
                                                            @if($afiliacion->estado === 'completada') bg-green-500
                                                            @elseif($afiliacion->estado === 'enviada') bg-blue-500
                                                            @elseif($afiliacion->estado === 'rechazada') bg-red-500
                                                            @else bg-gray-400 @endif">
                                                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                                @if($afiliacion->estado === 'completada')
                                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                                @elseif($afiliacion->estado === 'enviada')
                                                                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                                                                @else
                                                                    <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                                                @endif
                                                            </svg>
                                                        </span>
                                                    </div>
                                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                        <div>
                                                            <p class="text-sm text-gray-900">
                                                                <span class="font-medium">{{ $afiliacion->empleado->nombres }}</span>
                                                                - {{ $afiliacion->entidad_tipo_label }}
                                                            </p>
                                                            <p class="text-sm text-gray-500">{{ $afiliacion->entidad_nombre }}</p>
                                                        </div>
                                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                            <time datetime="{{ $afiliacion->created_at->toISOString() }}">
                                                                {{ $afiliacion->created_at->diffForHumans() }}
                                                            </time>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <div class="text-center py-6">
                                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">No hay actividad reciente</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Progreso General -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Progreso General del Sistema</h3>
                    <div class="space-y-4">
                        @php
                            $totalAfiliaciones = $estadisticas['total'];
                            $completadas = $estadisticas['completadas'];
                            $porcentajeCompletado = $totalAfiliaciones > 0 ? ($completadas / $totalAfiliaciones) * 100 : 0;
                        @endphp
                        
                        <div>
                            <div class="flex justify-between text-sm font-medium text-gray-700 mb-1">
                                <span>Afiliaciones Completadas</span>
                                <span>{{ number_format($porcentajeCompletado, 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full transition-all duration-300" style="width: {{ $porcentajeCompletado }}%"></div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500 mt-1">
                                <span>{{ $completadas }} completadas</span>
                                <span>{{ $totalAfiliaciones }} total</span>
                            </div>
                        </div>

                        @php
                            $enProceso = $estadisticas['en_proceso'];
                            $porcentajeEnProceso = $totalAfiliaciones > 0 ? ($enProceso / $totalAfiliaciones) * 100 : 0;
                        @endphp
                        
                        <div>
                            <div class="flex justify-between text-sm font-medium text-gray-700 mb-1">
                                <span>En Proceso</span>
                                <span>{{ number_format($porcentajeEnProceso, 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-yellow-500 h-2 rounded-full transition-all duration-300" style="width: {{ $porcentajeEnProceso }}%"></div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500 mt-1">
                                <span>{{ $enProceso }} en proceso</span>
                                <span>{{ $totalAfiliaciones }} total</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>