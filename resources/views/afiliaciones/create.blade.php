<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Nueva Afiliación de Seguridad Social') }}
            </h2>
            <a href="{{ route('afiliaciones.index') }}" 
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
            <form action="{{ route('afiliaciones.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Selección de Empleado -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Información del Empleado</h3>
                        
                        @if($empleado)
                            <!-- Empleado preseleccionado -->
                            <input type="hidden" name="empleado_id" value="{{ $empleado->id }}">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-lg font-medium text-blue-900">
                                            {{ $empleado->nombres }} {{ $empleado->apellidos }}
                                        </h4>
                                        <div class="text-sm text-blue-700">
                                            <div>{{ $empleado->numero_documento }} - {{ $empleado->cargo }}</div>
                                            <div>{{ $empleado->email }} - {{ $empleado->telefono }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Selector de empleado -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Empleado *</label>
                                <select name="empleado_id" 
                                        required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('empleado_id') border-red-500 @enderror">
                                    <option value="">Seleccione un empleado...</option>
                                    @foreach($empleados as $emp)
                                        <option value="{{ $emp->id }}" {{ old('empleado_id') == $emp->id ? 'selected' : '' }}>
                                            {{ $emp->nombres }} {{ $emp->apellidos }} - {{ $emp->numero_documento }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('empleado_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Selección de Entidades -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Entidades de Seguridad Social</h3>
                        <p class="text-sm text-gray-600 mb-6">
                            Seleccione las entidades para las cuales desea iniciar el proceso de afiliación. 
                            Se crearán solicitudes independientes para cada entidad seleccionada.
                        </p>

                        <div class="space-y-6" id="entidades-container">
                            @foreach($entidades as $tipo => $entidad)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-center mb-3">
                                        <input type="checkbox" 
                                               name="entidades_seleccionadas[]" 
                                               value="{{ $tipo }}"
                                               id="entidad_{{ $tipo }}"
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                               onchange="toggleEntidad('{{ $tipo }}')">
                                        <label for="entidad_{{ $tipo }}" class="ml-2 text-lg font-medium text-gray-900">
                                            {{ $entidad['label'] }}
                                        </label>
                                    </div>

                                    <div id="config_{{ $tipo }}" class="hidden space-y-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                                    Entidad {{ $entidad['label'] }} *
                                                </label>
                                                <select name="entidades[{{ $tipo }}][nombre]" 
                                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                    <option value="">Seleccione...</option>
                                                    @foreach($entidad['opciones'] as $opcion)
                                                        <option value="{{ $opcion }}">{{ $opcion }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="entidades[{{ $tipo }}][tipo]" value="{{ $tipo }}">
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                                    Días de Respuesta Estimados
                                                </label>
                                                <select name="entidades[{{ $tipo }}][dias_respuesta]" 
                                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                    <option value="3">3 días</option>
                                                    <option value="5" selected>5 días</option>
                                                    <option value="7">7 días</option>
                                                    <option value="10">10 días</option>
                                                    <option value="15">15 días</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Documentos requeridos -->
                                        <div class="bg-gray-50 rounded-md p-3">
                                            <h5 class="text-sm font-medium text-gray-900 mb-2">Documentos requeridos:</h5>
                                            <ul class="text-xs text-gray-600 space-y-1">
                                                @php
                                                    $docs = \App\Models\Afiliacion::getDocumentosRequeridos($tipo);
                                                @endphp
                                                @foreach($docs as $doc)
                                                    <li class="flex items-center">
                                                        <svg class="w-3 h-3 text-gray-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        {{ $doc }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @error('entidades')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Observaciones Generales -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Observaciones Generales</h3>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                            <textarea name="observaciones_generales" 
                                      rows="4"
                                      placeholder="Información adicional sobre el proceso de afiliación, instrucciones especiales, etc."
                                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('observaciones_generales') border-red-500 @enderror">{{ old('observaciones_generales') }}</textarea>
                            @error('observaciones_generales')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Información del Proceso -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Información del Proceso</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>Se crearán solicitudes independientes para cada entidad seleccionada</li>
                                    <li>Cada solicitud iniciará en estado "Pendiente" hasta que se envíe a la entidad</li>
                                    <li>Se notificará automáticamente al empleado sobre el inicio del proceso</li>
                                    <li>Podrá hacer seguimiento individual de cada afiliación desde el panel principal</li>
                                    <li>Los documentos requeridos se deben adjuntar antes de enviar las solicitudes</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('afiliaciones.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Crear Afiliaciones
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
    function toggleEntidad(tipo) {
        const checkbox = document.getElementById('entidad_' + tipo);
        const config = document.getElementById('config_' + tipo);
        const selectEntidad = config.querySelector('select[name*="[nombre]"]');
        
        if (checkbox.checked) {
            config.classList.remove('hidden');
            selectEntidad.required = true;
        } else {
            config.classList.add('hidden');
            selectEntidad.required = false;
            selectEntidad.value = '';
        }
    }

    // Validación simple del formulario
    document.querySelector('form').addEventListener('submit', function(e) {
        const checkboxes = document.querySelectorAll('input[name="entidades_seleccionadas[]"]:checked');
        if (checkboxes.length === 0) {
            e.preventDefault();
            alert('Debe seleccionar al menos una entidad para crear las afiliaciones.');
            return false;
        }

        // Validar que cada entidad seleccionada tenga nombre
        let valid = true;
        checkboxes.forEach(function(checkbox) {
            const tipo = checkbox.value;
            const selectEntidad = document.querySelector(`select[name="entidades[${tipo}][nombre]"]`);
            if (!selectEntidad.value) {
                alert(`Debe seleccionar la entidad para ${tipo.replace('_', ' ').toUpperCase()}`);
                valid = false;
                return false;
            }
        });

        if (!valid) {
            e.preventDefault();
            return false;
        }
    });
    </script>
</x-app-layout>