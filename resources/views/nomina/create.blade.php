<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Crear Nómina') }}
            </h2>
            <a href="{{ route('nomina.index') }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('nomina.store') }}">
                        @csrf

                        <!-- Periodo -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Periodo *</label>
                            <input type="month" 
                                   name="periodo" 
                                   value="{{ old('periodo', $periodoSugerido) }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('periodo') border-red-500 @enderror">
                            @error('periodo')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tipo de creación -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Creación *</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" 
                                           name="tipo_creacion" 
                                           value="individual" 
                                           {{ old('tipo_creacion', 'individual') === 'individual' ? 'checked' : '' }}
                                           class="mr-2"
                                           onchange="toggleEmpleadoSelect()">
                                    <span>Individual - Crear para un empleado específico</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" 
                                           name="tipo_creacion" 
                                           value="masivo" 
                                           {{ old('tipo_creacion') === 'masivo' ? 'checked' : '' }}
                                           class="mr-2"
                                           onchange="toggleEmpleadoSelect()">
                                    <span>Masivo - Crear para todos los empleados activos</span>
                                </label>
                            </div>
                        </div>

                        <!-- Empleado (solo para individual) -->
                        <div id="empleado-select" class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Empleado *</label>
                            <select name="empleado_id" 
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('empleado_id') border-red-500 @enderror">
                                <option value="">Seleccione un empleado</option>
                                @foreach($empleados as $empleado)
                                    <option value="{{ $empleado->id }}" {{ old('empleado_id') == $empleado->id ? 'selected' : '' }}>
                                        {{ $empleado->nombre_completo }} - {{ $empleado->cargo }} - ${{ number_format($empleado->salario, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('empleado_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Información adicional -->
                        <div class="bg-blue-50 border border-blue-200 rounded-md p-4 mb-6">
                            <div class="flex">
                                <svg class="h-5 w-5 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <h3 class="text-sm font-medium text-blue-800">Información importante</h3>
                                    <div class="text-sm text-blue-700 mt-1">
                                        <ul class="list-disc list-inside space-y-1">
                                            <li><strong>Individual:</strong> Se creará una nómina en estado "borrador" para el empleado seleccionado</li>
                                            <li><strong>Masivo:</strong> Se crearán nóminas para todos los empleados activos del periodo</li>
                                            <li>Después de crear las nóminas, deberá calcular y aprobar cada una individualmente</li>
                                            <li>No se pueden crear nóminas duplicadas para el mismo empleado y periodo</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('nomina.index') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Crear Nómina(s)
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleEmpleadoSelect() {
            const tipoCreacion = document.querySelector('input[name="tipo_creacion"]:checked').value;
            const empleadoSelect = document.getElementById('empleado-select');
            
            if (tipoCreacion === 'masivo') {
                empleadoSelect.style.display = 'none';
                document.querySelector('select[name="empleado_id"]').value = '';
            } else {
                empleadoSelect.style.display = 'block';
            }
        }

        // Inicializar al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            toggleEmpleadoSelect();
        });
    </script>
</x-app-layout>