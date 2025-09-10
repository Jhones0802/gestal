<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Programar Nueva Evaluación') }}
            </h2>
            <a href="{{ route('proceso-seleccion.index') }}" 
               style="display: inline-flex; align-items: center; padding: 10px 20px; background-color: #6b7280; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 14px;">
                <svg style="width: 16px; height: 16px; margin-right: 8px; fill: none; stroke: currentColor;" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('proceso-seleccion.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Selección de Candidato -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Selección de Candidato</h3>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Candidato *</label>
                            <select name="candidato_id" 
                                    required
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('candidato_id') border-red-500 @enderror">
                                <option value="">Seleccione el candidato...</option>
                                @foreach($candidatos as $candidato_option)
                                    <option value="{{ $candidato_option->id }}" 
                                            {{ old('candidato_id', $candidato?->id) == $candidato_option->id ? 'selected' : '' }}>
                                        {{ $candidato_option->nombre_completo }} - {{ $candidato_option->vacante->titulo }}
                                        ({{ ucfirst(str_replace('_', ' ', $candidato_option->estado)) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('candidato_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            @if($candidatos->isEmpty())
                                <p class="text-yellow-600 text-sm mt-1">
                                    No hay candidatos disponibles para evaluación. Solo se muestran candidatos en proceso de selección.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Tipo de Evaluación -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Tipo de Evaluación</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Evaluación *</label>
                                <select name="tipo_evaluacion" 
                                        required
                                        onchange="mostrarInformacionTipo(this.value)"
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('tipo_evaluacion') border-red-500 @enderror">
                                    <option value="">Seleccione el tipo...</option>
                                    <option value="entrevista_inicial" {{ old('tipo_evaluacion') == 'entrevista_inicial' ? 'selected' : '' }}>Entrevista Inicial</option>
                                    <option value="prueba_psicotecnica" {{ old('tipo_evaluacion') == 'prueba_psicotecnica' ? 'selected' : '' }}>Prueba Psicotécnica</option>
                                    <option value="entrevista_tecnica" {{ old('tipo_evaluacion') == 'entrevista_tecnica' ? 'selected' : '' }}>Entrevista Técnica</option>
                                    <option value="verificacion_referencias" {{ old('tipo_evaluacion') == 'verificacion_referencias' ? 'selected' : '' }}>Verificación de Referencias</option>
                                    <option value="examen_medico" {{ old('tipo_evaluacion') == 'examen_medico' ? 'selected' : '' }}>Examen Médico</option>
                                </select>
                                @error('tipo_evaluacion')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Información específica según el tipo -->
                            <div id="info-entrevista_inicial" class="hidden bg-blue-50 p-4 rounded-md">
                                <h4 class="font-medium text-blue-900 mb-2">Entrevista Inicial</h4>
                                <p class="text-blue-700 text-sm">
                                    Primera entrevista para conocer al candidato, evaluar motivación, comunicación y ajuste cultural. 
                                    Duración aproximada: 30-45 minutos.
                                </p>
                            </div>

                            <div id="info-prueba_psicotecnica" class="hidden bg-purple-50 p-4 rounded-md">
                                <h4 class="font-medium text-purple-900 mb-2">Prueba Psicotécnica</h4>
                                <p class="text-purple-700 text-sm">
                                    Evaluación psicológica para medir competencias, personalidad y aptitudes. 
                                    Se realiza con psicólogo externo. Duración: 1-2 horas.
                                </p>
                            </div>

                            <div id="info-entrevista_tecnica" class="hidden bg-green-50 p-4 rounded-md">
                                <h4 class="font-medium text-green-900 mb-2">Entrevista Técnica</h4>
                                <p class="text-green-700 text-sm">
                                    Evaluación de conocimientos técnicos específicos del cargo. 
                                    Incluye preguntas técnicas y ejercicios prácticos. Duración: 45-60 minutos.
                                </p>
                            </div>

                            <div id="info-verificacion_referencias" class="hidden bg-yellow-50 p-4 rounded-md">
                                <h4 class="font-medium text-yellow-900 mb-2">Verificación de Referencias</h4>
                                <p class="text-yellow-700 text-sm">
                                    Contacto con anteriores empleadores para validar experiencia laboral y comportamiento. 
                                    Se realizan llamadas telefónicas y se documenta la información.
                                </p>
                            </div>

                            <div id="info-examen_medico" class="hidden bg-red-50 p-4 rounded-md">
                                <h4 class="font-medium text-red-900 mb-2">Examen Médico Ocupacional</h4>
                                <p class="text-red-700 text-sm">
                                    Examen médico de ingreso según resolución 2346 de 2007. 
                                    Se realiza en IPS autorizada. Incluye exámenes generales y específicos según el cargo.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Programación -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Programación</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Programada *</label>
                                <input type="date" 
                                       name="fecha_programada" 
                                       value="{{ old('fecha_programada', date('Y-m-d', strtotime('+1 day'))) }}" 
                                       required
                                       min="{{ date('Y-m-d') }}"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('fecha_programada') border-red-500 @enderror">
                                @error('fecha_programada')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Hora Programada</label>
                                <input type="time" 
                                       name="hora_programada" 
                                       value="{{ old('hora_programada') }}" 
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('hora_programada') border-red-500 @enderror">
                                @error('hora_programada')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Entrevistador/Responsable</label>
                                <input type="text" 
                                       name="entrevistador" 
                                       value="{{ old('entrevistador', Auth::user()->name) }}" 
                                       placeholder="Nombre del entrevistador o responsable"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('entrevistador') border-red-500 @enderror">
                                @error('entrevistador')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Lugar de Evaluación</label>
                                <input type="text" 
                                       name="lugar_evaluacion" 
                                       value="{{ old('lugar_evaluacion') }}" 
                                       placeholder="Ej: Oficina principal, Sala de juntas, IPS externa"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('lugar_evaluacion') border-red-500 @enderror">
                                @error('lugar_evaluacion')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Observaciones -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Observaciones Adicionales</h3>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                            <textarea name="observaciones" 
                                      rows="4"
                                      placeholder="Observaciones especiales sobre la evaluación, instrucciones adicionales, etc."
                                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('observaciones') border-red-500 @enderror">{{ old('observaciones') }}</textarea>
                            @error('observaciones')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('proceso-seleccion.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Programar Evaluación
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function mostrarInformacionTipo(tipo) {
            // Ocultar todas las cajas de información
            const infos = ['entrevista_inicial', 'prueba_psicotecnica', 'entrevista_tecnica', 'verificacion_referencias', 'examen_medico'];
            infos.forEach(info => {
                document.getElementById('info-' + info).classList.add('hidden');
            });

            // Mostrar la información del tipo seleccionado
            if (tipo) {
                document.getElementById('info-' + tipo).classList.remove('hidden');
            }

            // Configurar valores por defecto según el tipo
            const entrevistadorInput = document.querySelector('input[name="entrevistador"]');
            const lugarInput = document.querySelector('input[name="lugar_evaluacion"]');
            
            switch (tipo) {
                case 'entrevista_inicial':
                    entrevistadorInput.value = 'Analista de RRHH';
                    lugarInput.value = 'Oficina principal';
                    break;
                case 'prueba_psicotecnica':
                    entrevistadorInput.value = 'Psicólogo Externo';
                    lugarInput.value = 'Consultorio psicológico';
                    break;
                case 'entrevista_tecnica':
                    entrevistadorInput.value = 'Jefe del Área';
                    lugarInput.value = 'Sala de juntas';
                    break;
                case 'verificacion_referencias':
                    entrevistadorInput.value = 'Analista de RRHH';
                    lugarInput.value = 'Oficina RRHH - Llamadas telefónicas';
                    break;
                case 'examen_medico':
                    entrevistadorInput.value = 'Médico Ocupacional';
                    lugarInput.value = 'IPS Autorizada';
                    break;
            }
        }

        // Si hay un tipo seleccionado al cargar la página, mostrar su información
        document.addEventListener('DOMContentLoaded', function() {
            const tipoSelect = document.querySelector('select[name="tipo_evaluacion"]');
            if (tipoSelect.value) {
                mostrarInformacionTipo(tipoSelect.value);
            }
        });
    </script>
</x-app-layout>