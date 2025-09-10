<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Editar Candidato') }}: {{ $candidato->nombre_completo }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('candidatos.show', $candidato) }}" 
                   style="display: inline-flex; align-items: center; padding: 8px 16px; background-color: #4f46e5; color: white; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px;">
                    <svg style="width: 16px; height: 16px; margin-right: 8px; fill: none; stroke: currentColor;" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Ver
                </a>
                <a href="{{ route('candidatos.index') }}" 
                   style="display: inline-flex; align-items: center; padding: 8px 16px; background-color: #6b7280; color: white; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px;">
                    <svg style="width: 16px; height: 16px; margin-right: 8px; fill: none; stroke: currentColor;" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('candidatos.update', $candidato) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

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
                                            {{ old('vacante_id', $candidato->vacante_id) == $vacante_option->id ? 'selected' : '' }}>
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
                                       value="{{ old('cedula', $candidato->cedula) }}" 
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
                                       value="{{ old('nombres', $candidato->nombres) }}" 
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
                                       value="{{ old('apellidos', $candidato->apellidos) }}" 
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
                                       value="{{ old('fecha_nacimiento', $candidato->fecha_nacimiento->format('Y-m-d')) }}" 
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
                                    <option value="masculino" {{ old('genero', $candidato->genero) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="femenino" {{ old('genero', $candidato->genero) == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                </select>
                                @error('genero')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                <input type="email" 
                                       name="email" 
                                       value="{{ old('email', $candidato->email) }}" 
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
                                       value="{{ old('telefono', $candidato->telefono) }}" 
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
                                       value="{{ old('celular', $candidato->celular) }}" 
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
                                       value="{{ old('ciudad', $candidato->ciudad) }}" 
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
                                       value="{{ old('departamento', $candidato->departamento) }}" 
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
                                          class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('direccion') border-red-500 @enderror">{{ old('direccion', $candidato->direccion) }}</textarea>
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
                                    <option value="primaria" {{ old('nivel_educativo', $candidato->nivel_educativo) == 'primaria' ? 'selected' : '' }}>Primaria</option>
                                    <option value="bachillerato" {{ old('nivel_educativo', $candidato->nivel_educativo) == 'bachillerato' ? 'selected' : '' }}>Bachillerato</option>
                                    <option value="tecnico" {{ old('nivel_educativo', $candidato->nivel_educativo) == 'tecnico' ? 'selected' : '' }}>Técnico</option>
                                    <option value="tecnologo" {{ old('nivel_educativo', $candidato->nivel_educativo) == 'tecnologo' ? 'selected' : '' }}>Tecnólogo</option>
                                    <option value="profesional" {{ old('nivel_educativo', $candidato->nivel_educativo) == 'profesional' ? 'selected' : '' }}>Profesional</option>
                                    <option value="especializacion" {{ old('nivel_educativo', $candidato->nivel_educativo) == 'especializacion' ? 'selected' : '' }}>Especialización</option>
                                    <option value="maestria" {{ old('nivel_educativo', $candidato->nivel_educativo) == 'maestria' ? 'selected' : '' }}>Maestría</option>
                                    <option value="doctorado" {{ old('nivel_educativo', $candidato->nivel_educativo) == 'doctorado' ? 'selected' : '' }}>Doctorado</option>
                                </select>
                                @error('nivel_educativo')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Título Obtenido</label>
                                <input type="text" 
                                       name="titulo_obtenido" 
                                       value="{{ old('titulo_obtenido', $candidato->titulo_obtenido) }}" 
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
                                       value="{{ old('institucion', $candidato->institucion) }}" 
                                       placeholder="Ej: Universidad Tecnológica de Pereira"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('institucion') border-red-500 @enderror">
                                @error('institucion')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estado y Experiencia -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Estado y Experiencia</h3>
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Estado del Candidato *</label>
                                <select name="estado" 
                                        required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('estado') border-red-500 @enderror">
                                    <option value="aplicado" {{ old('estado', $candidato->estado) == 'aplicado' ? 'selected' : '' }}>Aplicado</option>
                                    <option value="preseleccionado" {{ old('estado', $candidato->estado) == 'preseleccionado' ? 'selected' : '' }}>Preseleccionado</option>
                                    <option value="entrevista_inicial" {{ old('estado', $candidato->estado) == 'entrevista_inicial' ? 'selected' : '' }}>Entrevista Inicial</option>
                                    <option value="pruebas_psicotecnicas" {{ old('estado', $candidato->estado) == 'pruebas_psicotecnicas' ? 'selected' : '' }}>Pruebas Psicotécnicas</option>
                                    <option value="entrevista_tecnica" {{ old('estado', $candidato->estado) == 'entrevista_tecnica' ? 'selected' : '' }}>Entrevista Técnica</option>
                                    <option value="verificacion_referencias" {{ old('estado', $candidato->estado) == 'verificacion_referencias' ? 'selected' : '' }}>Verificación de Referencias</option>
                                    <option value="aprobado" {{ old('estado', $candidato->estado) == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                                    <option value="rechazado" {{ old('estado', $candidato->estado) == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                                    <option value="contratado" {{ old('estado', $candidato->estado) == 'contratado' ? 'selected' : '' }}>Contratado</option>
                                </select>
                                @error('estado')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Experiencia Laboral</label>
                                <textarea name="experiencia_laboral" 
                                          rows="4"
                                          placeholder="Describa la experiencia laboral relevante del candidato..."
                                          class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('experiencia_laboral') border-red-500 @enderror">{{ old('experiencia_laboral', $candidato->experiencia_laboral) }}</textarea>
                                @error('experiencia_laboral')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pretensión Salarial</label>
                                <input type="number" 
                                       name="pretension_salarial" 
                                       value="{{ old('pretension_salarial', $candidato->pretension_salarial) }}" 
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
                                
                                @if($candidato->hoja_vida_path)
                                    <div class="mb-3 p-3 bg-gray-50 rounded-md">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <svg class="w-6 h-6 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                                </svg>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">Archivo actual:</p>
                                                    <p class="text-xs text-gray-500">{{ basename($candidato->hoja_vida_path) }}</p>
                                                </div>
                                            </div>
                                            <a href="{{ Storage::url($candidato->hoja_vida_path) }}" 
                                               target="_blank"
                                               class="text-indigo-600 hover:text-indigo-900 text-sm">
                                                Ver archivo
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                
                                <input type="file" 
                                       name="hoja_vida" 
                                       accept=".pdf,.doc,.docx"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('hoja_vida') border-red-500 @enderror">
                                <p class="text-xs text-gray-500 mt-1">
                                    Formatos permitidos: PDF, DOC, DOCX. Tamaño máximo: 5MB
                                    @if($candidato->hoja_vida_path)
                                        <br><strong>Nota:</strong> Si selecciona un nuevo archivo, reemplazará el archivo actual.
                                    @endif
                                </p>
                                @error('hoja_vida')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                                <textarea name="observaciones" 
                                          rows="3"
                                          placeholder="Observaciones sobre el candidato, canal de aplicación, etc."
                                          class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('observaciones') border-red-500 @enderror">{{ old('observaciones', $candidato->observaciones) }}</textarea>
                                @error('observaciones')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('candidatos.show', $candidato) }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Actualizar Candidato
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>