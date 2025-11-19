<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Editar Nómina') }}
            </h2>
            <a href="{{ route('nomina.show', $nomina) }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

         <!-- Mensajes de éxito/error -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                    <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                    <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif
            <form method="POST" action="{{ route('nomina.update', $nomina) }}">
                @csrf
                @method('PUT')

                <!-- Información General -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Información General</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Empleado</label>
                                <input type="text" 
                                       value="{{ $nomina->empleado->nombre_completo }}" 
                                       disabled
                                       class="w-full border-gray-300 rounded-md bg-gray-50">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Periodo</label>
                                <input type="text" 
                                       value="{{ $nomina->periodo_formateado }}" 
                                       disabled
                                       class="w-full border-gray-300 rounded-md bg-gray-50">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Salario Base</label>
                                <input type="text" 
                                       value="${{ number_format($nomina->salario_basico, 0, ',', '.') }}" 
                                       disabled
                                       class="w-full border-gray-300 rounded-md bg-gray-50">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Devengados Variables -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded mr-2">+</span>
                            Devengados Variables
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">Agregue valores adicionales a los devengados base del empleado.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Horas Extras -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Horas Extras</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-500">$</span>
                                    <input type="number" 
                                           name="horas_extras" 
                                           value="{{ old('horas_extras', $nomina->horas_extras) }}"
                                           min="0"
                                           step="1000"
                                           class="w-full pl-8 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('horas_extras') border-red-500 @enderror">
                                </div>
                                @error('horas_extras')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Recargos Nocturnos -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Recargos Nocturnos</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-500">$</span>
                                    <input type="number" 
                                           name="recargos_nocturnos" 
                                           value="{{ old('recargos_nocturnos', $nomina->recargos_nocturnos) }}"
                                           min="0"
                                           step="1000"
                                           class="w-full pl-8 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('recargos_nocturnos') border-red-500 @enderror">
                                </div>
                                @error('recargos_nocturnos')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Dominicales y Festivos -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Dominicales y Festivos</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-500">$</span>
                                    <input type="number" 
                                           name="dominicales_festivos" 
                                           value="{{ old('dominicales_festivos', $nomina->dominicales_festivos) }}"
                                           min="0"
                                           step="1000"
                                           class="w-full pl-8 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('dominicales_festivos') border-red-500 @enderror">
                                </div>
                                @error('dominicales_festivos')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Comisiones -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Comisiones</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-500">$</span>
                                    <input type="number" 
                                           name="comisiones" 
                                           value="{{ old('comisiones', $nomina->comisiones) }}"
                                           min="0"
                                           step="1000"
                                           class="w-full pl-8 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('comisiones') border-red-500 @enderror">
                                </div>
                                @error('comisiones')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Bonificaciones -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Bonificaciones</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-500">$</span>
                                    <input type="number" 
                                           name="bonificaciones" 
                                           value="{{ old('bonificaciones', $nomina->bonificaciones) }}"
                                           min="0"
                                           step="1000"
                                           class="w-full pl-8 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('bonificaciones') border-red-500 @enderror">
                                </div>
                                @error('bonificaciones')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Otros Devengados -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Otros Devengados</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-500">$</span>
                                    <input type="number" 
                                           name="otros_devengados" 
                                           value="{{ old('otros_devengados', $nomina->otros_devengados) }}"
                                           min="0"
                                           step="1000"
                                           class="w-full pl-8 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('otros_devengados') border-red-500 @enderror">
                                </div>
                                @error('otros_devengados')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Deducciones Variables -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded mr-2">-</span>
                            Deducciones Adicionales
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">Las deducciones de ley (salud, pensión) se calculan automáticamente.</p>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Préstamos -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Préstamos</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-500">$</span>
                                    <input type="number" 
                                           name="prestamos" 
                                           value="{{ old('prestamos', $nomina->prestamos) }}"
                                           min="0"
                                           step="1000"
                                           class="w-full pl-8 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('prestamos') border-red-500 @enderror">
                                </div>
                                @error('prestamos')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Embargos -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Embargos</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-500">$</span>
                                    <input type="number" 
                                           name="embargos" 
                                           value="{{ old('embargos', $nomina->embargos) }}"
                                           min="0"
                                           step="1000"
                                           class="w-full pl-8 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('embargos') border-red-500 @enderror">
                                </div>
                                @error('embargos')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Otros Descuentos -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Otros Descuentos</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-500">$</span>
                                    <input type="number" 
                                           name="otros_descuentos" 
                                           value="{{ old('otros_descuentos', $nomina->otros_descuentos) }}"
                                           min="0"
                                           step="1000"
                                           class="w-full pl-8 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('otros_descuentos') border-red-500 @enderror">
                                </div>
                                @error('otros_descuentos')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Observaciones -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Observaciones</h3>
                        <textarea name="observaciones" 
                                  rows="3"
                                  class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('observaciones') border-red-500 @enderror"
                                  placeholder="Notas adicionales sobre esta nómina...">{{ old('observaciones', $nomina->observaciones) }}</textarea>
                        @error('observaciones')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Información Importante -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <svg class="h-5 w-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="text-sm text-yellow-800">
                            <p class="font-medium">Información importante:</p>
                            <ul class="list-disc list-inside mt-2 space-y-1">
                                <li>Después de guardar los cambios, deberá <strong>recalcular la nómina</strong> para actualizar los valores.</li>
                                <li>Las deducciones de ley (salud, pensión, solidaridad) se calculan automáticamente sobre el salario base.</li>
                                <li>Los aportes patronales y provisiones se calculan según la legislación vigente.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('nomina.show', $nomina) }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                        💾 Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>