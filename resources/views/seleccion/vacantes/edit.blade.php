<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Editar Vacante') }}: {{ $vacante->titulo }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('vacantes.show', $vacante) }}" 
                   style="display: inline-flex; align-items: center; padding: 8px 16px; background-color: #4f46e5; color: white; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px;">
                    <svg style="width: 16px; height: 16px; margin-right: 8px; fill: none; stroke: currentColor;" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Ver
                </a>
                <a href="{{ route('vacantes.index') }}" 
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
            <form action="{{ route('vacantes.update', $vacante) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Información Básica -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Información Básica de la Vacante</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Título de la Vacante *</label>
                                <input type="text" 
                                       name="titulo" 
                                       value="{{ old('titulo', $vacante->titulo) }}" 
                                       required
                                       placeholder="Ej: Asesor Comercial Senior"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('titulo') border-red-500 @enderror">
                                @error('titulo')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Área *</label>
                                <select name="area" 
                                        required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('area') border-red-500 @enderror">
                                    <option value="">Seleccione...</option>
                                    @foreach($areas as $area)
                                        <option value="{{ $area }}" {{ old('area', $vacante->area) == $area ? 'selected' : '' }}>{{ $area }}</option>
                                    @endforeach
                                    <option value="Otra" {{ old('area', $vacante->area) == 'Otra' ? 'selected' : '' }}>Otra</option>
                                </select>
                                @error('area')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ubicación *</label>
                                <input type="text" 
                                       name="ubicacion" 
                                       value="{{ old('ubicacion', $vacante->ubicacion) }}" 
                                       required
                                       placeholder="Ej: Pereira, Risaralda"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('ubicacion') border-red-500 @enderror">
                                @error('ubicacion')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Modalidad *</label>
                                <select name="modalidad" 
                                        required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('modalidad') border-red-500 @enderror">
                                    <option value="">Seleccione...</option>
                                    <option value="presencial" {{ old('modalidad', $vacante->modalidad) == 'presencial' ? 'selected' : '' }}>Presencial</option>
                                    <option value="remoto" {{ old('modalidad', $vacante->modalidad) == 'remoto' ? 'selected' : '' }}>Remoto</option>
                                    <option value="hibrido" {{ old('modalidad', $vacante->modalidad) == 'hibrido' ? 'selected' : '' }}>Híbrido</option>
                                </select>
                                @error('modalidad')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Número de Vacantes *</label>
                                <input type="number" 
                                       name="vacantes_disponibles" 
                                       value="{{ old('vacantes_disponibles', $vacante->vacantes_disponibles) }}" 
                                       required
                                       min="1"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('vacantes_disponibles') border-red-500 @enderror">
                                @error('vacantes_disponibles')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción del Cargo *</label>
                                <textarea name="descripcion" 
                                          required
                                          rows="4"
                                          placeholder="Describa de manera general las funciones y el perfil del cargo..."
                                          class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $vacante->descripcion) }}</textarea>
                                @error('descripcion')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Responsabilidades y Requisitos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Responsabilidades y Requisitos</h3>
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Responsabilidades Principales *</label>
                                <textarea name="responsabilidades" 
                                          required
                                          rows="5"
                                          placeholder="• Función 1&#10;• Función 2&#10;• Función 3..."
                                          class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('responsabilidades') border-red-500 @enderror">{{ old('responsabilidades', $vacante->responsabilidades) }}</textarea>
                                @error('responsabilidades')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Requisitos Mínimos *</label>
                                <textarea name="requisitos" 
                                          required
                                          rows="5"
                                          placeholder="• Educación requerida&#10;• Experiencia mínima&#10;• Conocimientos específicos..."
                                          class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('requisitos') border-red-500 @enderror">{{ old('requisitos', $vacante->requisitos) }}</textarea>
                                @error('requisitos')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Competencias Deseadas</label>
                                <textarea name="competencias" 
                                          rows="4"
                                          placeholder="• Competencia 1&#10;• Competencia 2&#10;• Competencia 3..."
                                          class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('competencias') border-red-500 @enderror">{{ old('competencias', $vacante->competencias) }}</textarea>
                                @error('competencias')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información Contractual y Salarial -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Información Contractual y Salarial</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Salario Mínimo *</label>
                                <input type="number" 
                                       name="salario_minimo" 
                                       value="{{ old('salario_minimo', $vacante->salario_minimo) }}" 
                                       required
                                       min="0"
                                       step="1000"
                                       placeholder="1000000"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('salario_minimo') border-red-500 @enderror">
                                @error('salario_minimo')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Salario Máximo *</label>
                                <input type="number" 
                                       name="salario_maximo" 
                                       value="{{ old('salario_maximo', $vacante->salario_maximo) }}" 
                                       required
                                       min="0"
                                       step="1000"
                                       placeholder="2000000"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('salario_maximo') border-red-500 @enderror">
                                @error('salario_maximo')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Contrato *</label>
                                <select name="tipo_contrato" 
                                        required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('tipo_contrato') border-red-500 @enderror">
                                    <option value="">Seleccione...</option>
                                    <option value="indefinido" {{ old('tipo_contrato', $vacante->tipo_contrato) == 'indefinido' ? 'selected' : '' }}>Indefinido</option>
                                    <option value="fijo" {{ old('tipo_contrato', $vacante->tipo_contrato) == 'fijo' ? 'selected' : '' }}>Término Fijo</option>
                                    <option value="prestacion_servicios" {{ old('tipo_contrato', $vacante->tipo_contrato) == 'prestacion_servicios' ? 'selected' : '' }}>Prestación de Servicios</option>
                                    <option value="temporal" {{ old('tipo_contrato', $vacante->tipo_contrato) == 'temporal' ? 'selected' : '' }}>Temporal</option>
                                </select>
                                @error('tipo_contrato')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Prioridad *</label>
                                <select name="prioridad" 
                                        required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('prioridad') border-red-500 @enderror">
                                    <option value="baja" {{ old('prioridad', $vacante->prioridad) == 'baja' ? 'selected' : '' }}>Baja</option>
                                    <option value="media" {{ old('prioridad', $vacante->prioridad) == 'media' ? 'selected' : '' }}>Media</option>
                                    <option value="alta" {{ old('prioridad', $vacante->prioridad) == 'alta' ? 'selected' : '' }}>Alta</option>
                                    <option value="urgente" {{ old('prioridad', $vacante->prioridad) == 'urgente' ? 'selected' : '' }}>Urgente</option>
                                </select>
                                @error('prioridad')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estado y Fechas -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Estado y Fechas</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Estado *</label>
                                <select name="estado" 
                                        required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('estado') border-red-500 @enderror">
                                    <option value="borrador" {{ old('estado', $vacante->estado) == 'borrador' ? 'selected' : '' }}>Borrador</option>
                                    <option value="publicada" {{ old('estado', $vacante->estado) == 'publicada' ? 'selected' : '' }}>Publicada</option>
                                    <option value="cerrada" {{ old('estado', $vacante->estado) == 'cerrada' ? 'selected' : '' }}>Cerrada</option>
                                    <option value="cancelada" {{ old('estado', $vacante->estado) == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                </select>
                                @error('estado')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Publicación *</label>
                                <input type="date" 
                                       name="fecha_publicacion" 
                                       value="{{ old('fecha_publicacion', $vacante->fecha_publicacion->format('Y-m-d')) }}" 
                                       required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('fecha_publicacion') border-red-500 @enderror">
                                @error('fecha_publicacion')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Cierre</label>
                                <input type="date" 
                                       name="fecha_cierre" 
                                       value="{{ old('fecha_cierre', $vacante->fecha_cierre?->format('Y-m-d')) }}" 
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('fecha_cierre') border-red-500 @enderror">
                                @error('fecha_cierre')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">Opcional. Si no se especifica, la vacante permanece abierta indefinidamente.</p>
                            </div>

                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Contacto Responsable *</label>
                                <input type="text" 
                                       name="contacto_responsable" 
                                       value="{{ old('contacto_responsable', $vacante->contacto_responsable) }}" 
                                       required
                                       placeholder="Nombre del responsable del proceso de selección"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('contacto_responsable') border-red-500 @enderror">
                                @error('contacto_responsable')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Proceso de Selección -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Proceso de Selección</h3>
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción del Proceso</label>
                                <textarea name="proceso_seleccion" 
                                          rows="4"
                                          placeholder="Describa las etapas del proceso de selección: entrevista inicial, pruebas psicotécnicas, entrevista técnica, etc."
                                          class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('proceso_seleccion') border-red-500 @enderror">{{ old('proceso_seleccion', $vacante->proceso_seleccion) }}</textarea>
                                @error('proceso_seleccion')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Documentos Requeridos</label>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="documentos_requeridos[]" value="hoja_vida" 
                                               {{ in_array('hoja_vida', old('documentos_requeridos', $vacante->documentos_requeridos ?? [])) ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">Hoja de vida</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="documentos_requeridos[]" value="cedula" 
                                               {{ in_array('cedula', old('documentos_requeridos', $vacante->documentos_requeridos ?? [])) ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">Cédula de ciudadanía</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="documentos_requeridos[]" value="certificados_educacion" 
                                               {{ in_array('certificados_educacion', old('documentos_requeridos', $vacante->documentos_requeridos ?? [])) ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">Certificados de educación</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="documentos_requeridos[]" value="referencias_laborales" 
                                               {{ in_array('referencias_laborales', old('documentos_requeridos', $vacante->documentos_requeridos ?? [])) ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">Referencias laborales</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="documentos_requeridos[]" value="antecedentes" 
                                               {{ in_array('antecedentes', old('documentos_requeridos', $vacante->documentos_requeridos ?? [])) ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">Antecedentes judiciales</span>
                                    </label>
                                </div>
                                @error('documentos_requeridos')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('vacantes.show', $vacante) }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Actualizar Vacante
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>