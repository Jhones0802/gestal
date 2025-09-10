<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Crear Nuevo Empleado') }}
            </h2>
            <a href="{{ route('empleados.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('empleados.store') }}" method="POST" class="space-y-6">
                @csrf

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
                                <label class="block text-sm font-medium text-gray-700 mb-1">Estado Civil *</label>
                                <select name="estado_civil" 
                                        required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('estado_civil') border-red-500 @enderror">
                                    <option value="">Seleccione...</option>
                                    <option value="soltero" {{ old('estado_civil') == 'soltero' ? 'selected' : '' }}>Soltero</option>
                                    <option value="casado" {{ old('estado_civil') == 'casado' ? 'selected' : '' }}>Casado</option>
                                    <option value="union_libre" {{ old('estado_civil') == 'union_libre' ? 'selected' : '' }}>Unión Libre</option>
                                    <option value="divorciado" {{ old('estado_civil') == 'divorciado' ? 'selected' : '' }}>Divorciado</option>
                                    <option value="viudo" {{ old('estado_civil') == 'viudo' ? 'selected' : '' }}>Viudo</option>
                                </select>
                                @error('estado_civil')
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
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('celular') border-red-500 @enderror">
                                @error('celular')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                <input type="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ciudad *</label>
                                <input type="text" 
                                       name="ciudad" 
                                       value="{{ old('ciudad') }}" 
                                       required
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
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('departamento') border-red-500 @enderror">
                                @error('departamento')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Dirección *</label>
                                <textarea name="direccion" 
                                          required
                                          rows="3"
                                          class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('direccion') border-red-500 @enderror">{{ old('direccion') }}</textarea>
                                @error('direccion')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información Laboral -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Información Laboral</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Cargo *</label>
                                <input type="text" 
                                       name="cargo" 
                                       value="{{ old('cargo') }}" 
                                       required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('cargo') border-red-500 @enderror">
                                @error('cargo')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Área *</label>
                                <select name="area" 
                                        required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('area') border-red-500 @enderror">
                                    <option value="">Seleccione...</option>
                                    <option value="Administrativa" {{ old('area') == 'Administrativa' ? 'selected' : '' }}>Administrativa</option>
                                    <option value="Comercial" {{ old('area') == 'Comercial' ? 'selected' : '' }}>Comercial</option>
                                    <option value="Técnica" {{ old('area') == 'Técnica' ? 'selected' : '' }}>Técnica</option>
                                    <option value="Operaciones" {{ old('area') == 'Operaciones' ? 'selected' : '' }}>Operaciones</option>
                                    <option value="Recursos Humanos" {{ old('area') == 'Recursos Humanos' ? 'selected' : '' }}>Recursos Humanos</option>
                                    <option value="Contabilidad" {{ old('area') == 'Contabilidad' ? 'selected' : '' }}>Contabilidad</option>
                                    <option value="Gerencia" {{ old('area') == 'Gerencia' ? 'selected' : '' }}>Gerencia</option>
                                </select>
                                @error('area')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Salario *</label>
                                <input type="number" 
                                       name="salario" 
                                       value="{{ old('salario') }}" 
                                       required
                                       min="0"
                                       step="0.01"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('salario') border-red-500 @enderror">
                                @error('salario')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Contrato *</label>
                                <select name="tipo_contrato" 
                                        required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('tipo_contrato') border-red-500 @enderror">
                                    <option value="">Seleccione...</option>
                                    <option value="indefinido" {{ old('tipo_contrato') == 'indefinido' ? 'selected' : '' }}>Indefinido</option>
                                    <option value="fijo" {{ old('tipo_contrato') == 'fijo' ? 'selected' : '' }}>Término Fijo</option>
                                    <option value="prestacion_servicios" {{ old('tipo_contrato') == 'prestacion_servicios' ? 'selected' : '' }}>Prestación de Servicios</option>
                                    <option value="temporal" {{ old('tipo_contrato') == 'temporal' ? 'selected' : '' }}>Temporal</option>
                                </select>
                                @error('tipo_contrato')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Ingreso *</label>
                                <input type="date" 
                                       name="fecha_ingreso" 
                                       value="{{ old('fecha_ingreso') }}" 
                                       required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('fecha_ingreso') border-red-500 @enderror">
                                @error('fecha_ingreso')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Fin Contrato</label>
                                <input type="date" 
                                       name="fecha_fin_contrato" 
                                       value="{{ old('fecha_fin_contrato') }}" 
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('fecha_fin_contrato') border-red-500 @enderror">
                                @error('fecha_fin_contrato')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jefe Inmediato</label>
                                <input type="text" 
                                       name="jefe_inmediato" 
                                       value="{{ old('jefe_inmediato') }}" 
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('jefe_inmediato') border-red-500 @enderror">
                                @error('jefe_inmediato')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información de Seguridad Social -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Seguridad Social</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">EPS</label>
                                <input type="text" 
                                       name="eps" 
                                       value="{{ old('eps') }}" 
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('eps') border-red-500 @enderror">
                                @error('eps')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">ARL</label>
                                <input type="text" 
                                       name="arl" 
                                       value="{{ old('arl') }}" 
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('arl') border-red-500 @enderror">
                                @error('arl')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fondo de Pensión</label>
                                <input type="text" 
                                       name="fondo_pension" 
                                       value="{{ old('fondo_pension') }}" 
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('fondo_pension') border-red-500 @enderror">
                                @error('fondo_pension')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Caja de Compensación</label>
                                <input type="text" 
                                       name="caja_compensacion" 
                                       value="{{ old('caja_compensacion') }}" 
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('caja_compensacion') border-red-500 @enderror">
                                @error('caja_compensacion')
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
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('institucion') border-red-500 @enderror">
                                @error('institucion')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contacto de Emergencia -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Contacto de Emergencia</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo *</label>
                                <input type="text" 
                                       name="contacto_emergencia_nombre" 
                                       value="{{ old('contacto_emergencia_nombre') }}" 
                                       required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('contacto_emergencia_nombre') border-red-500 @enderror">
                                @error('contacto_emergencia_nombre')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono *</label>
                                <input type="text" 
                                       name="contacto_emergencia_telefono" 
                                       value="{{ old('contacto_emergencia_telefono') }}" 
                                       required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('contacto_emergencia_telefono') border-red-500 @enderror">
                                @error('contacto_emergencia_telefono')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Parentesco *</label>
                                <select name="contacto_emergencia_parentesco" 
                                        required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('contacto_emergencia_parentesco') border-red-500 @enderror">
                                    <option value="">Seleccione...</option>
                                    <option value="Padre" {{ old('contacto_emergencia_parentesco') == 'Padre' ? 'selected' : '' }}>Padre</option>
                                    <option value="Madre" {{ old('contacto_emergencia_parentesco') == 'Madre' ? 'selected' : '' }}>Madre</option>
                                    <option value="Esposo(a)" {{ old('contacto_emergencia_parentesco') == 'Esposo(a)' ? 'selected' : '' }}>Esposo(a)</option>
                                    <option value="Hermano(a)" {{ old('contacto_emergencia_parentesco') == 'Hermano(a)' ? 'selected' : '' }}>Hermano(a)</option>
                                    <option value="Hijo(a)" {{ old('contacto_emergencia_parentesco') == 'Hijo(a)' ? 'selected' : '' }}>Hijo(a)</option>
                                    <option value="Tío(a)" {{ old('contacto_emergencia_parentesco') == 'Tío(a)' ? 'selected' : '' }}>Tío(a)</option>
                                    <option value="Primo(a)" {{ old('contacto_emergencia_parentesco') == 'Primo(a)' ? 'selected' : '' }}>Primo(a)</option>
                                    <option value="Amigo(a)" {{ old('contacto_emergencia_parentesco') == 'Amigo(a)' ? 'selected' : '' }}>Amigo(a)</option>
                                    <option value="Otro" {{ old('contacto_emergencia_parentesco') == 'Otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                @error('contacto_emergencia_parentesco')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('empleados.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Guardar Empleado
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>