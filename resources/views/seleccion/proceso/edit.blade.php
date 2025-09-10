<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Editar Evaluación') }}
            </h2>
            <a href="{{ route('proceso-seleccion.show', $procesoSeleccion) }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:bg-gray-500 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('proceso-seleccion.update', $procesoSeleccion) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Información Básica -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Información Básica</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Candidato *</label>
                                <select name="candidato_id" 
                                        required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('candidato_id') border-red-500 @enderror">
                                    @foreach($candidatos as $candidato)
                                        <option value="{{ $candidato->id }}" 
                                                {{ old('candidato_id', $procesoSeleccion->candidato_id) == $candidato->id ? 'selected' : '' }}>
                                            {{ $candidato->nombres }} {{ $candidato->apellidos }} - {{ $candidato->vacante->titulo }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('candidato_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Evaluación *</label>
                                <select name="tipo_evaluacion" 
                                        required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('tipo_evaluacion') border-red-500 @enderror">
                                    <option value="entrevista_inicial" {{ old('tipo_evaluacion', $procesoSeleccion->tipo_evaluacion) == 'entrevista_inicial' ? 'selected' : '' }}>Entrevista Inicial</option>
                                    <option value="prueba_psicotecnica" {{ old('tipo_evaluacion', $procesoSeleccion->tipo_evaluacion) == 'prueba_psicotecnica' ? 'selected' : '' }}>Prueba Psicotécnica</option>
                                    <option value="entrevista_tecnica" {{ old('tipo_evaluacion', $procesoSeleccion->tipo_evaluacion) == 'entrevista_tecnica' ? 'selected' : '' }}>Entrevista Técnica</option>
                                    <option value="verificacion_referencias" {{ old('tipo_evaluacion', $procesoSeleccion->tipo_evaluacion) == 'verificacion_referencias' ? 'selected' : '' }}>Verificación de Referencias</option>
                                    <option value="examen_medico" {{ old('tipo_evaluacion', $procesoSeleccion->tipo_evaluacion) == 'examen_medico' ? 'selected' : '' }}>Examen Médico</option>
                                </select>
                                @error('tipo_evaluacion')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Estado *</label>
                                <select name="estado" 
                                        required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('estado') border-red-500 @enderror">
                                    <option value="programada" {{ old('estado', $procesoSeleccion->estado) == 'programada' ? 'selected' : '' }}>Programada</option>
                                    <option value="realizada" {{ old('estado', $procesoSeleccion->estado) == 'realizada' ? 'selected' : '' }}>Realizada</option>
                                    <option value="cancelada" {{ old('estado', $procesoSeleccion->estado) == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                    <option value="reprogramada" {{ old('estado', $procesoSeleccion->estado) == 'reprogramada' ? 'selected' : '' }}>Reprogramada</option>
                                </select>
                                @error('estado')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Resultado *</label>
                                <select name="resultado" 
                                        required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('resultado') border-red-500 @enderror">
                                    <option value="pendiente" {{ old('resultado', $procesoSeleccion->resultado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="aprobado" {{ old('resultado', $procesoSeleccion->resultado) == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                                    <option value="rechazado" {{ old('resultado', $procesoSeleccion->resultado) == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                                </select>
                                @error('resultado')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Programación -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Programación</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Programada *</label>
                                <input type="date" 
                                       name="fecha_programada" 
                                       value="{{ old('fecha_programada', $procesoSeleccion->fecha_programada) }}" 
                                       required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('fecha_programada') border-red-500 @enderror">
                                @error('fecha_programada')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Hora Programada</label>
                                <input type="time" 
                                       name="hora_programada" 
                                       value="{{ old('hora_programada', $procesoSeleccion->hora_programada ? \Carbon\Carbon::parse($procesoSeleccion->hora_programada)->format('H:i') : '') }}"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('hora_programada') border-red-500 @enderror">
                                @error('hora_programada')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Realizada</label>
                                <input type="date" 
                                       name="fecha_realizada" 
                                       value="{{ old('fecha_realizada', $procesoSeleccion->fecha_realizada) }}"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('fecha_realizada') border-red-500 @enderror">
                                @error('fecha_realizada')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Entrevistador/Evaluador</label>
                                <input type="text" 
                                       name="entrevistador" 
                                       value="{{ old('entrevistador', $procesoSeleccion->entrevistador) }}" 
                                       placeholder="Nombre del evaluador"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('entrevistador') border-red-500 @enderror">
                                @error('entrevistador')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Lugar de Evaluación</label>
                                <input type="text" 
                                       name="lugar_evaluacion" 
                                       value="{{ old('lugar_evaluacion', $procesoSeleccion->lugar_evaluacion) }}" 
                                       placeholder="Oficina, sala de reuniones, consultorio externo, etc."
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('lugar_evaluacion') border-red-500 @enderror">
                                @error('lugar_evaluacion')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Calificación y Resultados -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Calificación y Resultados</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Puntaje Obtenido</label>
                                <input type="number" 
                                       name="puntaje" 
                                       value="{{ old('puntaje', $procesoSeleccion->puntaje) }}" 
                                       min="0"
                                       max="100"
                                       placeholder="85"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('puntaje') border-red-500 @enderror">
                                @error('puntaje')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Puntaje Máximo *</label>
                                <input type="number" 
                                       name="puntaje_maximo" 
                                       value="{{ old('puntaje_maximo', $procesoSeleccion->puntaje_maximo ?? 100) }}" 
                                       min="1"
                                       required
                                       placeholder="100"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('puntaje_maximo') border-red-500 @enderror">
                                @error('puntaje_maximo')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Observaciones Detalladas -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Observaciones Detalladas</h3>
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones Generales</label>
                                <textarea name="observaciones" 
                                          rows="3"
                                          placeholder="Descripción general de la evaluación, comportamiento del candidato, puntos importantes..."
                                          class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('observaciones') border-red-500 @enderror">{{ old('observaciones', $procesoSeleccion->observaciones) }}</textarea>
                                @error('observaciones')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Fortalezas Identificadas</label>
                                    <textarea name="fortalezas" 
                                              rows="4"
                                              placeholder="Aspectos positivos, habilidades destacadas, competencias sobresalientes..."
                                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('fortalezas') border-red-500 @enderror">{{ old('fortalezas', $procesoSeleccion->fortalezas) }}</textarea>
                                    @error('fortalezas')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Áreas de Mejora</label>
                                    <textarea name="debilidades" 
                                              rows="4"
                                              placeholder="Aspectos por mejorar, áreas de oportunidad, debilidades identificadas..."
                                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('debilidades') border-red-500 @enderror">{{ old('debilidades', $procesoSeleccion->debilidades) }}</textarea>
                                    @error('debilidades')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Recomendaciones</label>
                                <textarea name="recomendaciones" 
                                          rows="3"
                                          placeholder="Recomendaciones para el proceso, siguientes pasos, sugerencias para el candidato..."
                                          class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('recomendaciones') border-red-500 @enderror">{{ old('recomendaciones', $procesoSeleccion->recomendaciones) }}</textarea>
                                @error('recomendaciones')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('proceso-seleccion.show', $procesoSeleccion) }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Actualizar Evaluación
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Validación del puntaje máximo
        document.querySelector('input[name="puntaje"]').addEventListener('input', function() {
            const puntaje = parseInt(this.value);
            const puntajeMaximo = parseInt(document.querySelector('input[name="puntaje_maximo"]').value);
            
            if (puntaje > puntajeMaximo) {
                this.value = puntajeMaximo;
            }
        });

        document.querySelector('input[name="puntaje_maximo"]').addEventListener('input', function() {
            const puntajeMaximo = parseInt(this.value);
            const puntajeInput = document.querySelector('input[name="puntaje"]');
            const puntaje = parseInt(puntajeInput.value);
            
            puntajeInput.setAttribute('max', puntajeMaximo);
            
            if (puntaje > puntajeMaximo) {
                puntajeInput.value = puntajeMaximo;
            }
        });
    </script>
</x-app-layout>