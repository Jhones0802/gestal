<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Editar Afiliación') }}
            </h2>
            <a href="{{ route('afiliaciones.show', $afiliacion) }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:bg-gray-500 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('afiliaciones.update', $afiliacion) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Información Básica -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Información Básica</h3>
                        
                        <!-- Información del empleado (solo lectura) -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-lg font-medium text-blue-900">
                                        {{ $afiliacion->empleado->nombres }} {{ $afiliacion->empleado->apellidos }}
                                    </h4>
                                    <div class="text-sm text-blue-700">
                                        <div>{{ $afiliacion->empleado->numero_documento }} - {{ $afiliacion->empleado->cargo }}</div>
                                        <div>{{ $afiliacion->empleado->email }} - {{ $afiliacion->empleado->telefono }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Entidad</label>
                                <p class="text-sm text-gray-900 bg-gray-50 p-2 rounded">{{ $afiliacion->entidad_tipo_label }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Entidad *</label>
                                <select name="entidad_nombre" 
                                        required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('entidad_nombre') border-red-500 @enderror">
                                    @php
                                        $entidadesPorTipo = [
                                            'eps' => ['Sura EPS', 'Salud Total', 'Nueva EPS', 'Sanitas', 'Compensar EPS'],
                                            'arl' => ['Sura ARL', 'Positiva ARL', 'Colmena ARL', 'Liberty ARL', 'Bolívar ARL'],
                                            'caja_compensacion' => ['Compensar', 'Colsubsidio', 'Cafam', 'Comfenalco', 'Comfacauca'],
                                            'fondo_pensiones' => ['Protección', 'Porvenir', 'Colfondos', 'Old Mutual', 'Colpensiones']
                                        ];
                                        $opciones = $entidadesPorTipo[$afiliacion->entidad_tipo] ?? [];
                                    @endphp
                                    @foreach($opciones as $opcion)
                                        <option value="{{ $opcion }}" {{ old('entidad_nombre', $afiliacion->entidad_nombre) == $opcion ? 'selected' : '' }}>
                                            {{ $opcion }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('entidad_nombre')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Estado *</label>
                                <select name="estado" 
                                        required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('estado') border-red-500 @enderror">
                                    <option value="pendiente" {{ old('estado', $afiliacion->estado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="en_proceso" {{ old('estado', $afiliacion->estado) == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                                    <option value="enviada" {{ old('estado', $afiliacion->estado) == 'enviada' ? 'selected' : '' }}>Enviada</option>
                                    <option value="aprobada" {{ old('estado', $afiliacion->estado) == 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                                    <option value="rechazada" {{ old('estado', $afiliacion->estado) == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                                    <option value="completada" {{ old('estado', $afiliacion->estado) == 'completada' ? 'selected' : '' }}>Completada</option>
                                </select>
                                @error('estado')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Días de Respuesta Estimados</label>
                                <select name="dias_respuesta_estimados" 
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('dias_respuesta_estimados') border-red-500 @enderror">
                                    <option value="3" {{ old('dias_respuesta_estimados', $afiliacion->dias_respuesta_estimados) == 3 ? 'selected' : '' }}>3 días</option>
                                    <option value="5" {{ old('dias_respuesta_estimados', $afiliacion->dias_respuesta_estimados) == 5 ? 'selected' : '' }}>5 días</option>
                                    <option value="7" {{ old('dias_respuesta_estimados', $afiliacion->dias_respuesta_estimados) == 7 ? 'selected' : '' }}>7 días</option>
                                    <option value="10" {{ old('dias_respuesta_estimados', $afiliacion->dias_respuesta_estimados) == 10 ? 'selected' : '' }}>10 días</option>
                                    <option value="15" {{ old('dias_respuesta_estimados', $afiliacion->dias_respuesta_estimados) == 15 ? 'selected' : '' }}>15 días</option>
                                    <option value="30" {{ old('dias_respuesta_estimados', $afiliacion->dias_respuesta_estimados) == 30 ? 'selected' : '' }}>30 días</option>
                                </select>
                                @error('dias_respuesta_estimados')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fechas del Proceso -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Fechas del Proceso</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Envío</label>
                                <input type="date" 
                                       name="fecha_envio" 
                                       value="{{ old('fecha_envio', $afiliacion->fecha_envio ? $afiliacion->fecha_envio->format('Y-m-d') : '') }}"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('fecha_envio') border-red-500 @enderror">
                                @error('fecha_envio')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Respuesta</label>
                                <input type="date" 
                                       name="fecha_respuesta" 
                                       value="{{ old('fecha_respuesta', $afiliacion->fecha_respuesta ? $afiliacion->fecha_respuesta->format('Y-m-d') : '') }}"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('fecha_respuesta') border-red-500 @enderror">
                                @error('fecha_respuesta')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Afiliación Efectiva</label>
                                <input type="date" 
                                       name="fecha_afiliacion_efectiva" 
                                       value="{{ old('fecha_afiliacion_efectiva', $afiliacion->fecha_afiliacion_efectiva ? $afiliacion->fecha_afiliacion_efectiva->format('Y-m-d') : '') }}"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('fecha_afiliacion_efectiva') border-red-500 @enderror">
                                @error('fecha_afiliacion_efectiva')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Números de Identificación -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Números de Identificación</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Número de Radicado</label>
                                <input type="text" 
                                       name="numero_radicado" 
                                       value="{{ old('numero_radicado', $afiliacion->numero_radicado) }}" 
                                       placeholder="Se genera automáticamente al enviar"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('numero_radicado') border-red-500 @enderror">
                                @error('numero_radicado')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Número de Afiliado</label>
                                <input type="text" 
                                       name="numero_afiliado" 
                                       value="{{ old('numero_afiliado', $afiliacion->numero_afiliado) }}" 
                                       placeholder="Se genera al completar la afiliación"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('numero_afiliado') border-red-500 @enderror">
                                @error('numero_afiliado')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Observaciones -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Observaciones y Comentarios</h3>
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones Generales</label>
                                <textarea name="observaciones" 
                                          rows="4"
                                          placeholder="Información adicional sobre el proceso de afiliación..."
                                          class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('observaciones') border-red-500 @enderror">{{ old('observaciones', $afiliacion->observaciones) }}</textarea>
                                @error('observaciones')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div id="motivo-rechazo-container" style="{{ old('estado', $afiliacion->estado) === 'rechazada' ? '' : 'display: none;' }}">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Motivo de Rechazo</label>
                                <textarea name="motivo_rechazo" 
                                          rows="3"
                                          placeholder="Especifique el motivo por el cual fue rechazada la solicitud..."
                                          class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('motivo_rechazo') border-red-500 @enderror">{{ old('motivo_rechazo', $afiliacion->motivo_rechazo) }}</textarea>
                                @error('motivo_rechazo')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información del Estado Actual -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Estado Actual de la Afiliación</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <div class="mb-2">
                                    <strong>Estado:</strong> 
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                        @if($afiliacion->estado_color === 'gray') bg-gray-100 text-gray-800
                                        @elseif($afiliacion->estado_color === 'yellow') bg-yellow-100 text-yellow-800
                                        @elseif($afiliacion->estado_color === 'blue') bg-blue-100 text-blue-800
                                        @elseif($afiliacion->estado_color === 'green') bg-green-100 text-green-800
                                        @elseif($afiliacion->estado_color === 'red') bg-red-100 text-red-800
                                        @elseif($afiliacion->estado_color === 'emerald') bg-emerald-100 text-emerald-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $afiliacion->estado_label }}
                                    </span>
                                </div>
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>Fecha de solicitud: {{ $afiliacion->fecha_solicitud->format('d/m/Y') }}</li>
                                    @if($afiliacion->fecha_respuesta_estimada)
                                        <li>Respuesta estimada: {{ $afiliacion->fecha_respuesta_estimada->format('d/m/Y') }}</li>
                                    @endif
                                    @if($afiliacion->estaVencida())
                                        <li class="text-red-600 font-medium">⚠️ Esta afiliación está vencida</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('afiliaciones.show', $afiliacion) }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Actualizar Afiliación
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Mostrar/ocultar motivo de rechazo según el estado
        document.querySelector('select[name="estado"]').addEventListener('change', function() {
            const motivoContainer = document.getElementById('motivo-rechazo-container');
            const motivoTextarea = motivoContainer.querySelector('textarea');
            
            if (this.value === 'rechazada') {
                motivoContainer.style.display = 'block';
                motivoTextarea.required = true;
            } else {
                motivoContainer.style.display = 'none';
                motivoTextarea.required = false;
                motivoTextarea.value = '';
            }
        });
    </script>
</x-app-layout>