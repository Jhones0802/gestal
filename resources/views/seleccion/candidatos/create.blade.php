<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Registrar Nuevo Candidato') }}
            </h2>
            <a href="{{ route('candidatos.index') }}" 
               style="display: inline-flex; align-items: center; padding: 10px 20px; background-color: #6b7280; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 14px;">
                <svg style="width: 16px; height: 16px; margin-right: 8px; fill: none; stroke: currentColor;" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('candidatos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Selección de Vacante -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Vacante a la que Aplica</h3>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Vacante *</label>
                            <select name="vacante_id" 
                                    required
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('vacante_id') border-red-500 @enderror">
                                <option value="">Seleccione la vacante...</option>
                                @foreach($vacantes as $vacante_option)
                                    <option value="{{ $vacante_option->id }}" 
                                            {{ old('vacante_id', $vacante?->id) == $vacante_option->id ? 'selected' : '' }}>
                                        {{ $vacante_option->titulo }} - {{ $vacante_option->area }}
                                        ({{ $vacante_option->salario_rango }})
                                    </option>
                                @endforeach
                            </select>
                            @error('vacante_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Información Personal -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Información Personal</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Cédula *</label>
                                <input type="text" 
                                       name="cedula" 
                                       value="{{ old('cedula') }}" 
                                       required
                                       placeholder="Ej: 1094567890"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('cedula') border-red-500 @enderror">
                                @error('cedula')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nombres *</label>
                                <input type="text" 
                                       name="nombres" 
                                       value="{{ old('nombres') }}" 
                                       required
                                       placeholder="Ej: Carlos Andrés"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nombres') border-red-500 @enderror">
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
                                       placeholder="Ej: García Rodríguez"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('apellidos') border-red-500 @enderror">
                                @error('apellidos')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Nacimiento *</label>
                                <input type="date" 
                                       name="fecha_nacimiento" 
                                       value="{{ old('fecha_nacimiento') }}" 
                                       required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('fecha_nacimiento') border-red-500 @enderror">
                                @error('fecha_nacimiento')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Género *</label>
                                <select name="genero" 
                                        required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('genero') border-red-500 @enderror">
                                    <option value="">Seleccione...</option>
                                    <option value="masculino" {{ old('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="femenino" {{ old('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                </select>
                                @error('genero')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                <input type="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required
                                       placeholder="candidato@email.com"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información de Contacto -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Información de Contacto</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono *</label>
                                <input type="text" 
                                       name="telefono" 
                                       value="{{ old('telefono') }}" 
                                       required
                                       placeholder="Ej: 3151234567"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('telefono') border-red-500 @enderror">
                                @error('telefono')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Celular</label>
                                <input type="text" 
                                       name="celular" 
                                       value="{{ old('celular') }}" 
                                       placeholder="Ej: 3209876543"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('celular') border-red-500 @enderror">
                                @error('celular')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ciudad *</label>
                                <input type="text" 
                                       name="ciudad" 
                                       value="{{ old('ciudad') }}" 
                                       required
                                       placeholder="Ej: Pereira"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('ciudad') border-red-500 @enderror">
                                @error('ciudad')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Departamento *</label>
                                <input type="text" 
                                       name="departamento" 
                                       value="{{ old('departamento') }}" 
                                       required
                                       placeholder="Ej: Risaralda"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('departamento') border-red-500 @enderror">
                                @error('departamento')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Dirección *</label>
                                <textarea name="direccion" 
                                          required
                                          rows="2"
                                          placeholder="Ej: Calle 25 #45-67 Barrio Los Alpes"
                                          class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('direccion') border-red-500 @enderror">{{ old('direccion') }}</textarea>
                                @error('direccion')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información Académica -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Información Académica</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nivel Educativo *</label>
                                <select name="nivel_educativo" 
                                        required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nivel_educativo') border-red-500 @enderror">
                                    <option value="">Seleccione...</option>
                                    <option value="primaria" {{ old('nivel_educativo') == 'primaria' ? 'selected' : '' }}>Primaria</option>
                                    <option value="bachillerato" {{ old('nivel_educativo') == 'bachillerato' ? 'selected' : '' }}>Bachillerato</option>
                                    <option value="tecnico" {{ old('nivel_educativo') == 'tecnico' ? 'selected' : '' }}>Técnico</option>
                                    <option value="tecnologo" {{ old('nivel_educativo') == 'tecnologo' ? 'selected' : '' }}>Tecnólogo</option>
                                    <option value="profesional" {{ old('nivel_educativo') == 'profesional' ? 'selected' : '' }}>Profesional</option>
                                    <option value="especializacion" {{ old('nivel_educativo') == 'especializacion' ? 'selected' : '' }}>Especialización</option>
                                    <option value="maestria" {{ old('nivel_educativo') == 'maestria' ? 'selected' : '' }}>Maestría</option>
                                    <option value="doctorado" {{ old('nivel_educativo') == 'doctorado' ? 'selected' : '' }}>Doctorado</option>
                                </select>
                                @error('nivel_educativo')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Título Obtenido</label>
                                <input type="text" 
                                       name="titulo_obtenido" 
                                       value="{{ old('titulo_obtenido') }}" 
                                       placeholder="Ej: Administrador de Empresas"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('titulo_obtenido') border-red-500 @enderror">
                                @error('titulo_obtenido')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Institución</label>
                                <input type="text" 
                                       name="institucion" 
                                       value="{{ old('institucion') }}" 
                                       placeholder="Ej: Universidad Tecnológica de Pereira"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('institucion') border-red-500 @enderror">
                                @error('institucion')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Experiencia y Pretensión Salarial -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Experiencia y Aspiraciones</h3>
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Experiencia Laboral</label>
                                <textarea name="experiencia_laboral" 
                                          rows="4"
                                          placeholder="Describa la experiencia laboral relevante del candidato..."
                                          class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('experiencia_laboral') border-red-500 @enderror">{{ old('experiencia_laboral') }}</textarea>
                                @error('experiencia_laboral')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pretensión Salarial</label>
                                <input type="number" 
                                       name="pretension_salarial" 
                                       value="{{ old('pretension_salarial') }}" 
                                       min="0"
                                       step="10000"
                                       placeholder="Ej: 2500000"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('pretension_salarial') border-red-500 @enderror">
                                @error('pretension_salarial')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hoja de Vida y Observaciones -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Documentos y Observaciones</h3>
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Hoja de Vida</label>
                                <input type="file" 
                                       name="hoja_vida" 
                                       accept=".pdf,.doc,.docx"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('hoja_vida') border-red-500 @enderror">
                                <p class="text-xs text-gray-500 mt-1">Formatos permitidos: PDF, DOC, DOCX. Tamaño máximo: 5MB</p>
                                @error('hoja_vida')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones Iniciales</label>
                                <textarea name="observaciones" 
                                          rows="3"
                                          placeholder="Observaciones sobre el candidato, canal de aplicación, etc."
                                          class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('observaciones') border-red-500 @enderror">{{ old('observaciones') }}</textarea>
                                @error('observaciones')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('candidatos.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Registrar Candidato
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>