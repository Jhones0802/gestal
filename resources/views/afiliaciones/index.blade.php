<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Afiliaciones de Seguridad Social') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('afiliaciones.dashboard') }}" 
                   class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-500 focus:bg-purple-500 active:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('afiliaciones.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Nueva Afiliación
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Estadísticas rápidas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Total</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $estadisticas['total'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">En Proceso</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $estadisticas['en_proceso'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Completadas</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $estadisticas['completadas'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Por Vencer</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $estadisticas['vencidas'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('afiliaciones.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Empleado</label>
                                <select name="empleado_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Todos los empleados</option>
                                    @foreach($empleados as $empleado)
                                        <option value="{{ $empleado->id }}" {{ request('empleado_id') == $empleado->id ? 'selected' : '' }}>
                                            {{ $empleado->nombres }} {{ $empleado->apellidos }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Entidad</label>
                                <select name="entidad_tipo" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Todas las entidades</option>
                                    <option value="eps" {{ request('entidad_tipo') == 'eps' ? 'selected' : '' }}>EPS</option>
                                    <option value="arl" {{ request('entidad_tipo') == 'arl' ? 'selected' : '' }}>ARL</option>
                                    <option value="caja_compensacion" {{ request('entidad_tipo') == 'caja_compensacion' ? 'selected' : '' }}>Caja de Compensación</option>
                                    <option value="fondo_pensiones" {{ request('entidad_tipo') == 'fondo_pensiones' ? 'selected' : '' }}>Fondo de Pensiones</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                                <select name="estado" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Todos los estados</option>
                                    <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="en_proceso" {{ request('estado') == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                                    <option value="enviada" {{ request('estado') == 'enviada' ? 'selected' : '' }}>Enviada</option>
                                    <option value="aprobada" {{ request('estado') == 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                                    <option value="rechazada" {{ request('estado') == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                                    <option value="completada" {{ request('estado') == 'completada' ? 'selected' : '' }}>Completada</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Desde</label>
                                <input type="date" 
                                       name="fecha_desde" 
                                       value="{{ request('fecha_desde') }}"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Hasta</label>
                                <input type="date" 
                                       name="fecha_hasta" 
                                       value="{{ request('fecha_hasta') }}"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="flex justify-between">
                            <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                Filtrar
                            </button>
                            @if(request()->hasAny(['empleado_id', 'entidad_tipo', 'estado', 'fecha_desde', 'fecha_hasta']))
                                <a href="{{ route('afiliaciones.index') }}" 
                                   class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                    Limpiar Filtros
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de afiliaciones -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empleado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entidad</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Solicitud</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Radicado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Respuesta Estimada</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($afiliaciones as $afiliacion)
                                <tr class="hover:bg-gray-50 {{ $afiliacion->estaVencida() ? 'bg-red-50' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $afiliacion->empleado->nombres }} {{ $afiliacion->empleado->apellidos }}
                                                </div>
                                                <div class="text-sm text-gray-500">{{ $afiliacion->empleado->numero_documento }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $afiliacion->entidad_tipo_label }}</div>
                                        <div class="text-sm text-gray-500">{{ $afiliacion->entidad_nombre }}</div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($afiliacion->estado_color === 'gray') bg-gray-100 text-gray-800
                                            @elseif($afiliacion->estado_color === 'yellow') bg-yellow-100 text-yellow-800
                                            @elseif($afiliacion->estado_color === 'blue') bg-blue-100 text-blue-800
                                            @elseif($afiliacion->estado_color === 'green') bg-green-100 text-green-800
                                            @elseif($afiliacion->estado_color === 'red') bg-red-100 text-red-800
                                            @elseif($afiliacion->estado_color === 'emerald') bg-emerald-100 text-emerald-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ $afiliacion->estado_label }}
                                        </span>
                                        @if($afiliacion->estaVencida())
                                            <div class="text-xs text-red-600 mt-1">¡Vencida!</div>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $afiliacion->fecha_solicitud->format('d/m/Y') }}
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $afiliacion->numero_radicado ?? '-' }}
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $afiliacion->fecha_respuesta_estimada ? $afiliacion->fecha_respuesta_estimada->format('d/m/Y') : '-' }}
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <a href="{{ route('afiliaciones.show', $afiliacion) }}" 
                                           class="text-blue-600 hover:text-blue-900">Ver</a>
                                        
                                        <a href="{{ route('afiliaciones.edit', $afiliacion) }}" 
                                           class="text-yellow-600 hover:text-yellow-900">Editar</a>
                                        
                                        @if($afiliacion->puedeEnviarse())
                                            <form method="POST" action="{{ route('afiliaciones.enviar', $afiliacion) }}" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="text-green-600 hover:text-green-900"
                                                        onclick="return confirm('¿Confirma el envío de esta solicitud?')">
                                                    Enviar
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($afiliacion->puedeCompletarse())
                                            <form method="POST" action="{{ route('afiliaciones.completar', $afiliacion) }}" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="text-purple-600 hover:text-purple-900"
                                                        onclick="return confirm('¿Confirma completar esta afiliación?')">
                                                    Completar
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <p class="text-lg font-medium mb-2">No hay afiliaciones</p>
                                            <p class="text-sm mb-4">Crea la primera afiliación para comenzar.</p>
                                            <a href="{{ route('afiliaciones.create') }}" 
                                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                                Nueva Afiliación
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Paginación -->
            @if($afiliaciones->hasPages())
                <div class="mt-6">
                    {{ $afiliaciones->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>