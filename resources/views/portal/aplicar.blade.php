<x-portal-layout :title="'Aplicar a ' . $vacante->titulo">
    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Aplicar a la Vacante</h1>
                <div class="bg-white rounded-lg shadow-sm p-4 inline-block">
                    <h2 class="text-xl font-semibold text-blue-600">{{ $vacante->titulo }}</h2>
                    <p class="text-gray-600">{{ $vacante->area }} - {{ $vacante->ubicacion }}</p>
                </div>
            </div>

            <form action="{{ route('portal.store', $vacante) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- Información Personal -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Información Personal</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Universidad/Institución</label>
                            <input type="text" 
                                   name="universidad" 
                                   value="{{ old('universidad') }}" 
                                   placeholder="Nombre de la institución educativa"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('universidad') border-red-500 @enderror">
                            @error('universidad')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Años de Experiencia *</label>
                            <select name="experiencia_anos" 
                                    required
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('experiencia_anos') border-red-500 @enderror">
                                <option value="">Seleccione...</option>
                                <option value="0" {{ old('experiencia_anos') == '0' ? 'selected' : '' }}>Sin experiencia</option>
                                <option value="1" {{ old('experiencia_anos') == '1' ? 'selected' : '' }}>1 año</option>
                                <option value="2" {{ old('experiencia_anos') == '2' ? 'selected' : '' }}>2 años</option>
                                <option value="3" {{ old('experiencia_anos') == '3' ? 'selected' : '' }}>3 años</option>
                                <option value="4" {{ old('experiencia_anos') == '4' ? 'selected' : '' }}>4 años</option>
                                <option value="5" {{ old('experiencia_anos') == '5' ? 'selected' : '' }}>5 años</option>
                                <option value="10" {{ old('experiencia_anos') == '10' ? 'selected' : '' }}>Más de 5 años</option>
                            </select>
                            @error('experiencia_anos')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Experiencia en el Área</label>
                            <textarea name="experiencia_area" 
                                      rows="3"
                                      placeholder="Describe tu experiencia relevante para esta posición..."
                                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('experiencia_area') border-red-500 @enderror">{{ old('experiencia_area') }}</textarea>
                            @error('experiencia_area')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Información Laboral -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Información Laboral</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Salario Aspirado</label>
                            <input type="number" 
                                   name="salario_aspirado" 
                                   value="{{ old('salario_aspirado') }}" 
                                   min="0"
                                   step="100000"
                                   placeholder="1500000"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('salario_aspirado') border-red-500 @enderror">
                            <p class="text-xs text-gray-500 mt-1">Opcional - Ingrese el valor mensual en pesos</p>
                            @error('salario_aspirado')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Disponibilidad *</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" 
                                           name="disponibilidad_inmediata" 
                                           value="1" 
                                           {{ old('disponibilidad_inmediata') == '1' ? 'checked' : '' }}
                                           class="text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">Disponibilidad inmediata</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" 
                                           name="disponibilidad_inmediata" 
                                           value="0" 
                                           {{ old('disponibilidad_inmediata') == '0' ? 'checked' : '' }}
                                           class="text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">Fecha específica</span>
                                </label>
                            </div>
                            @error('disponibilidad_inmediata')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="fecha_disponibilidad_container" style="display: none;">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Disponibilidad</label>
                            <input type="date" 
                                   name="fecha_disponibilidad" 
                                   value="{{ old('fecha_disponibilidad') }}" 
                                   min="{{ now()->toDateString() }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('fecha_disponibilidad') border-red-500 @enderror">
                            @error('fecha_disponibilidad')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Documentos -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Documentos</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Hoja de Vida *</label>
                            <input type="file" 
                                   name="hoja_vida" 
                                   required
                                   accept=".pdf,.doc,.docx"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('hoja_vida') border-red-500 @enderror">
                            <p class="text-xs text-gray-500 mt-1">Formatos: PDF, DOC, DOCX. Máximo 5MB</p>
                            @error('hoja_vida')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Carta de Presentación</label>
                            <input type="file" 
                                   name="carta_presentacion" 
                                   accept=".pdf,.doc,.docx"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('carta_presentacion') border-red-500 @enderror">
                            <p class="text-xs text-gray-500 mt-1">Opcional - Formatos: PDF, DOC, DOCX. Máximo 2MB</p>
                            @error('carta_presentacion')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Observaciones -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Información Adicional</h3>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                        <textarea name="observaciones" 
                                  rows="4"
                                  placeholder="Cuéntanos por qué eres el candidato ideal para esta posición, información adicional relevante, etc."
                                  class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('observaciones') border-red-500 @enderror">{{ old('observaciones') }}</textarea>
                        @error('observaciones')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Términos y Condiciones -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Términos y Condiciones</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <input type="checkbox" 
                                   name="acepta_terminos" 
                                   value="1" 
                                   required
                                   {{ old('acepta_terminos') ? 'checked' : '' }}
                                   class="mt-1 text-blue-600 focus:ring-blue-500 @error('acepta_terminos') border-red-500 @enderror">
                            <label class="ml-3 text-sm text-gray-700">
                                Acepto los <a href="#" class="text-blue-600 hover:text-blue-800">términos y condiciones</a> del proceso de selección *
                            </label>
                        </div>
                        @error('acepta_terminos')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror

                        <div class="flex items-start">
                            <input type="checkbox" 
                                   name="acepta_datos" 
                                   value="1" 
                                   required
                                   {{ old('acepta_datos') ? 'checked' : '' }}
                                   class="mt-1 text-blue-600 focus:ring-blue-500 @error('acepta_datos') border-red-500 @enderror">
                            <label class="ml-3 text-sm text-gray-700">
                                Autorizo el tratamiento de mis datos personales conforme a la <a href="#" class="text-blue-600 hover:text-blue-800">política de privacidad</a> *
                            </label>
                        </div>
                        @error('acepta_datos')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror

                        <div class="bg-blue-50 p-4 rounded-md">
                            <p class="text-sm text-blue-800">
                                <strong>Información importante:</strong> Una vez enviada tu aplicación, recibirás un email de confirmación. 
                                Podrás consultar el estado de tu proceso en cualquier momento usando tu número de documento y email.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('portal.vacante', $vacante) }}" 
                           class="w-full sm:w-auto text-center bg-gray-300 hover:bg-gray-400 text-gray-700 py-3 px-8 rounded-lg font-semibold transition-colors">
                            Volver a la Vacante
                        </a>
                        
                        <button type="submit" 
                                class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white py-3 px-8 rounded-lg font-semibold transition-colors">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Enviar Aplicación
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Mostrar/ocultar fecha de disponibilidad
        document.querySelectorAll('input[name="disponibilidad_inmediata"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const fechaContainer = document.getElementById('fecha_disponibilidad_container');
                if (this.value === '0') {
                    fechaContainer.style.display = 'block';
                    fechaContainer.querySelector('input').required = true;
                } else {
                    fechaContainer.style.display = 'none';
                    fechaContainer.querySelector('input').required = false;
                }
            });
        });

        // Validar tamaños de archivo
        document.querySelector('input[name="hoja_vida"]').addEventListener('change', function() {
            validateFileSize(this, 5 * 1024 * 1024); // 5MB
        });

        document.querySelector('input[name="carta_presentacion"]').addEventListener('change', function() {
            validateFileSize(this, 2 * 1024 * 1024); // 2MB
        });

        function validateFileSize(input, maxSize) {
            if (input.files[0] && input.files[0].size > maxSize) {
                alert('El archivo es demasiado grande. Máximo permitido: ' + (maxSize / 1024 / 1024) + 'MB');
                input.value = '';
            }
        }

        // Inicializar estado de disponibilidad
        const selectedRadio = document.querySelector('input[name="disponibilidad_inmediata"]:checked');
        if (selectedRadio && selectedRadio.value === '0') {
            document.getElementById('fecha_disponibilidad_container').style.display = 'block';
        }
    </script>
    @endpush
</x-portal-layout> text-gray-700 mb-1">Nombres *</label>
                            <input type="text" 
                                   name="nombres" 
                                   value="{{ old('nombres') }}" 
                                   required
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nombres') border-red-500 @enderror">
                            @error('nombres')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Apellidos *</label>
                            <input type="text" 
                                   name="apellidos" 
                                   value="{{ old('apellidos') }}" 
                                   required
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('apellidos') border-red-500 @enderror">
                            @error('apellidos')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Documento *</label>
                            <select name="tipo_documento" 
                                    required
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tipo_documento') border-red-500 @enderror">
                                <option value="">Seleccione...</option>
                                <option value="cedula" {{ old('tipo_documento') == 'cedula' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                                <option value="cedula_extranjeria" {{ old('tipo_documento') == 'cedula_extranjeria' ? 'selected' : '' }}>Cédula de Extranjería</option>
                                <option value="pasaporte" {{ old('tipo_documento') == 'pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                            </select>
                            @error('tipo_documento')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Número de Documento *</label>
                            <input type="text" 
                                   name="numero_documento" 
                                   value="{{ old('numero_documento') }}" 
                                   required
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('numero_documento') border-red-500 @enderror">
                            @error('numero_documento')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono *</label>
                            <input type="tel" 
                                   name="telefono" 
                                   value="{{ old('telefono') }}" 
                                   required
                                   placeholder="3001234567"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('telefono') border-red-500 @enderror">
                            @error('telefono')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Nacimiento *</label>
                            <input type="date" 
                                   name="fecha_nacimiento" 
                                   value="{{ old('fecha_nacimiento') }}" 
                                   required
                                   max="{{ now()->subYears(16)->toDateString() }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('fecha_nacimiento') border-red-500 @enderror">
                            @error('fecha_nacimiento')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Género *</label>
                            <select name="genero" 
                                    required
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('genero') border-red-500 @enderror">
                                <option value="">Seleccione...</option>
                                <option value="masculino" {{ old('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="femenino" {{ old('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                <option value="otro" {{ old('genero') == 'otro' ? 'selected' : '' }}>Otro</option>
                                <option value="prefiero_no_decir" {{ old('genero') == 'prefiero_no_decir' ? 'selected' : '' }}>Prefiero no decir</option>
                            </select>
                            @error('genero')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dirección *</label>
                            <input type="text" 
                                   name="direccion" 
                                   value="{{ old('direccion') }}" 
                                   required
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('direccion') border-red-500 @enderror">
                            @error('direccion')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ciudad *</label>
                            <input type="text" 
                                   name="ciudad" 
                                   value="{{ old('ciudad') }}" 
                                   required
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('ciudad') border-red-500 @enderror">
                            @error('ciudad')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Información Académica y Profesional -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Información Académica y Profesional</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nivel Educativo *</label>
                            <select name="nivel_educativo" 
                                    required
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nivel_educativo') border-red-500 @enderror">
                                <option value="">Seleccione...</option>
                                <option value="primaria" {{ old('nivel_educativo') == 'primaria' ? 'selected' : '' }}>Primaria</option>
                                <option value="secundaria" {{ old('nivel_educativo') == 'secundaria' ? 'selected' : '' }}>Secundaria</option>
                                <option value="tecnico" {{ old('nivel_educativo') == 'tecnico' ? 'selected' : '' }}>Técnico</option>
                                <option value="tecnologo" {{ old('nivel_educativo') == 'tecnologo' ? 'selected' : '' }}>Tecnólogo</option>
                                <option value="universitario" {{ old('nivel_educativo') == 'universitario' ? 'selected' : '' }}>Universitario</option>
                                <option value="posgrado" {{ old('nivel_educativo') == 'posgrado' ? 'selected' : '' }}>Posgrado</option>
                            </select>
                            @error('nivel_educativo')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Profesión</label>
                            <input type="text" 
                                   name="profesion" 
                                   value="{{ old('profesion') }}" 
                                   placeholder="Ej: Ingeniero de Sistemas"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('profesion') border-red-500 @enderror">
                            @error('profesion')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium