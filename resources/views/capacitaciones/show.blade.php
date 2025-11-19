<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $capacitacion->titulo }}
            </h2>
            <div class="flex space-x-2">
                @if($capacitacion->puedeSerModificada())
                    <a href="{{ route('capacitaciones.edit', $capacitacion) }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500">
                        Editar
                    </a>
                @endif
                <a href="{{ route('capacitaciones.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500">
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Información General -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Información General</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <span class="font-medium text-gray-700">Estado:</span>
                            <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $capacitacion->estado_badge }}">
                                {{ $capacitacion->estado_texto }}
                            </span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Tipo:</span>
                            <span class="ml-2">{{ ucfirst($capacitacion->tipo) }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Fecha:</span>
                            <span class="ml-2">{{ $capacitacion->fecha_formateada }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Horario:</span>
                            <span class="ml-2">{{ $capacitacion->horario_formateado }}</span>
                        </div>
                        @if($capacitacion->instructor)
                        <div>
                            <span class="font-medium text-gray-700">Instructor:</span>
                            <span class="ml-2">{{ $capacitacion->instructor }}</span>
                        </div>
                        @endif
                        @if($capacitacion->duracion_horas)
                        <div>
                            <span class="font-medium text-gray-700">Duración:</span>
                            <span class="ml-2">{{ $capacitacion->duracion_formateada }}</span>
                        </div>
                        @endif
                        @if($capacitacion->lugar)
                        <div>
                            <span class="font-medium text-gray-700">Lugar:</span>
                            <span class="ml-2">{{ $capacitacion->lugar }}</span>
                        </div>
                        @endif
                        @if($capacitacion->link_virtual)
                        <div class="md:col-span-2">
                            <span class="font-medium text-gray-700">Link Virtual:</span>
                            <a href="{{ $capacitacion->link_virtual }}" target="_blank" class="ml-2 text-blue-600 hover:underline">{{ $capacitacion->link_virtual }}</a>
                        </div>
                        @endif
                        <div>
                            <span class="font-medium text-gray-700">Cupo:</span>
                            <span class="ml-2">{{ $capacitacion->inscritos_count }}
                            @if($capacitacion->cupo_maximo)
                                / {{ $capacitacion->cupo_maximo }}
                            @endif
                            </span>
                        </div>
                        @if($capacitacion->costo)
                        <div>
                            <span class="font-medium text-gray-700">Costo:</span>
                            <span class="ml-2">{{ $capacitacion->costo_formateado }}</span>
                        </div>
                        @endif
                    </div>

                    @if($capacitacion->descripcion)
                    <div class="mt-4">
                        <span class="font-medium text-gray-700">Descripción:</span>
                        <p class="mt-1 text-gray-600">{{ $capacitacion->descripcion }}</p>
                    </div>
                    @endif

                    @if($capacitacion->objetivos)
                    <div class="mt-4">
                        <span class="font-medium text-gray-700">Objetivos:</span>
                        <p class="mt-1 text-gray-600">{{ $capacitacion->objetivos }}</p>
                    </div>
                    @endif

                    @if($capacitacion->contenido)
                    <div class="mt-4">
                        <span class="font-medium text-gray-700">Contenido:</span>
                        <p class="mt-1 text-gray-600">{{ $capacitacion->contenido }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Empleados Inscritos -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Empleados Inscritos ({{ $capacitacion->inscritos_count }})</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Empleado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cargo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Notificación</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($capacitacion->empleados as $empleado)
                                    <tr>
                                        <td class="px-6 py-4">{{ $empleado->nombre_completo }}</td>
                                        <td class="px-6 py-4">{{ $empleado->cargo }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($empleado->pivot->estado_asistencia === 'asistio') bg-green-100 text-green-800
                                                @elseif($empleado->pivot->estado_asistencia === 'confirmado') bg-blue-100 text-blue-800
                                                @elseif($empleado->pivot->estado_asistencia === 'no_asistio') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst($empleado->pivot->estado_asistencia) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $empleado->pivot->fecha_notificacion ? \Carbon\Carbon::parse($empleado->pivot->fecha_notificacion)->format('d/m/Y H:i') : '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No hay empleados inscritos</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
