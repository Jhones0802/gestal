<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Editar Capacitación') }}
            </h2>
            <a href="{{ route('capacitaciones.show', $capacitacion) }}"
               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500">
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('capacitaciones.update', $capacitacion) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Título -->
                            <div class="md:col-span-2">
                                <label for="titulo" class="block text-sm font-medium text-gray-700">Título *</label>
                                <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $capacitacion->titulo) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('titulo')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Descripción -->
                            <div class="md:col-span-2">
                                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                                <textarea name="descripcion" id="descripcion" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('descripcion', $capacitacion->descripcion) }}</textarea>
                            </div>

                            <!-- Tipo -->
                            <div>
                                <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo *</label>
                                <select name="tipo" id="tipo" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="presencial" {{ old('tipo', $capacitacion->tipo) === 'presencial' ? 'selected' : '' }}>Presencial</option>
                                    <option value="virtual" {{ old('tipo', $capacitacion->tipo) === 'virtual' ? 'selected' : '' }}>Virtual</option>
                                    <option value="hibrida" {{ old('tipo', $capacitacion->tipo) === 'hibrida' ? 'selected' : '' }}>Híbrida</option>
                                </select>
                            </div>

                            <!-- Estado -->
                            <div>
                                <label for="estado" class="block text-sm font-medium text-gray-700">Estado *</label>
                                <select name="estado" id="estado" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="programada" {{ old('estado', $capacitacion->estado) === 'programada' ? 'selected' : '' }}>Programada</option>
                                    <option value="en_curso" {{ old('estado', $capacitacion->estado) === 'en_curso' ? 'selected' : '' }}>En Curso</option>
                                    <option value="completada" {{ old('estado', $capacitacion->estado) === 'completada' ? 'selected' : '' }}>Completada</option>
                                    <option value="cancelada" {{ old('estado', $capacitacion->estado) === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                </select>
                            </div>

                            <!-- Instructor -->
                            <div>
                                <label for="instructor" class="block text-sm font-medium text-gray-700">Instructor</label>
                                <input type="text" name="instructor" id="instructor" value="{{ old('instructor', $capacitacion->instructor) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- Lugar -->
                            <div>
                                <label for="lugar" class="block text-sm font-medium text-gray-700">Lugar</label>
                                <input type="text" name="lugar" id="lugar" value="{{ old('lugar', $capacitacion->lugar) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- Link Virtual -->
                            <div class="md:col-span-2">
                                <label for="link_virtual" class="block text-sm font-medium text-gray-700">Link Virtual</label>
                                <input type="url" name="link_virtual" id="link_virtual" value="{{ old('link_virtual', $capacitacion->link_virtual) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- Fecha Inicio -->
                            <div>
                                <label for="fecha_inicio" class="block text-sm font-medium text-gray-700">Fecha Inicio *</label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio', $capacitacion->fecha_inicio->format('Y-m-d')) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- Fecha Fin -->
                            <div>
                                <label for="fecha_fin" class="block text-sm font-medium text-gray-700">Fecha Fin *</label>
                                <input type="date" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin', $capacitacion->fecha_fin->format('Y-m-d')) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- Hora Inicio -->
                            <div>
                                <label for="hora_inicio" class="block text-sm font-medium text-gray-700">Hora Inicio *</label>
                                <input type="time" name="hora_inicio" id="hora_inicio" value="{{ old('hora_inicio', \Carbon\Carbon::parse($capacitacion->hora_inicio)->format('H:i')) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- Hora Fin -->
                            <div>
                                <label for="hora_fin" class="block text-sm font-medium text-gray-700">Hora Fin *</label>
                                <input type="time" name="hora_fin" id="hora_fin" value="{{ old('hora_fin', \Carbon\Carbon::parse($capacitacion->hora_fin)->format('H:i')) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- Duración Horas -->
                            <div>
                                <label for="duracion_horas" class="block text-sm font-medium text-gray-700">Duración (horas)</label>
                                <input type="number" step="0.5" name="duracion_horas" id="duracion_horas" value="{{ old('duracion_horas', $capacitacion->duracion_horas) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- Cupo Máximo -->
                            <div>
                                <label for="cupo_maximo" class="block text-sm font-medium text-gray-700">Cupo Máximo</label>
                                <input type="number" name="cupo_maximo" id="cupo_maximo" value="{{ old('cupo_maximo', $capacitacion->cupo_maximo) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- Objetivos -->
                            <div class="md:col-span-2">
                                <label for="objetivos" class="block text-sm font-medium text-gray-700">Objetivos</label>
                                <textarea name="objetivos" id="objetivos" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('objetivos', $capacitacion->objetivos) }}</textarea>
                            </div>

                            <!-- Contenido -->
                            <div class="md:col-span-2">
                                <label for="contenido" class="block text-sm font-medium text-gray-700">Contenido</label>
                                <textarea name="contenido" id="contenido" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('contenido', $capacitacion->contenido) }}</textarea>
                            </div>

                            <!-- Costo -->
                            <div>
                                <label for="costo" class="block text-sm font-medium text-gray-700">Costo</label>
                                <input type="number" step="0.01" name="costo" id="costo" value="{{ old('costo', $capacitacion->costo) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- Certificado Tipo -->
                            <div>
                                <label for="certificado_tipo" class="block text-sm font-medium text-gray-700">Tipo de Certificado</label>
                                <input type="text" name="certificado_tipo" id="certificado_tipo" value="{{ old('certificado_tipo', $capacitacion->certificado_tipo) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- Observaciones -->
                            <div class="md:col-span-2">
                                <label for="observaciones" class="block text-sm font-medium text-gray-700">Observaciones</label>
                                <textarea name="observaciones" id="observaciones" rows="2"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('observaciones', $capacitacion->observaciones) }}</textarea>
                            </div>

                            <!-- Empleados -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Empleados Invitados</label>
                                <div class="border rounded-md p-4 max-h-60 overflow-y-auto">
                                    @foreach($empleados as $empleado)
                                        <div class="flex items-center mb-2">
                                            <input type="checkbox" name="empleados[]" value="{{ $empleado->id }}" id="empleado_{{ $empleado->id }}"
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                   {{ in_array($empleado->id, old('empleados', $inscritosIds)) ? 'checked' : '' }}>
                                            <label for="empleado_{{ $empleado->id }}" class="ml-2 text-sm text-gray-700">
                                                {{ $empleado->nombre_completo }} - {{ $empleado->cargo }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('capacitaciones.show', $capacitacion) }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500">
                                Actualizar Capacitación
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tipoSelect = document.getElementById('tipo');
            const lugarDiv = document.getElementById('lugar').closest('div');
            const linkVirtualDiv = document.getElementById('link_virtual').closest('div');
            const lugarInput = document.getElementById('lugar');
            const linkVirtualInput = document.getElementById('link_virtual');

            function toggleFields() {
                const tipo = tipoSelect.value;

                if (tipo === 'presencial') {
                    // Mostrar lugar, ocultar link
                    lugarDiv.style.display = 'block';
                    linkVirtualDiv.style.display = 'none';
                    lugarInput.required = true;
                    linkVirtualInput.required = false;
                    linkVirtualInput.value = '';
                } else if (tipo === 'virtual') {
                    // Ocultar lugar, mostrar link
                    lugarDiv.style.display = 'none';
                    linkVirtualDiv.style.display = 'block';
                    lugarInput.required = false;
                    linkVirtualInput.required = true;
                    lugarInput.value = '';
                } else if (tipo === 'hibrida') {
                    // Mostrar ambos
                    lugarDiv.style.display = 'block';
                    linkVirtualDiv.style.display = 'block';
                    lugarInput.required = true;
                    linkVirtualInput.required = true;
                }
            }

            // Ejecutar al cargar la página
            toggleFields();

            // Ejecutar al cambiar el tipo
            tipoSelect.addEventListener('change', toggleFields);
        });
    </script>
</x-app-layout>
