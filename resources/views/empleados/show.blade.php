<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalles del Empleado') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('empleados.edit', $empleado) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Editar
                </a>
                <a href="{{ route('empleados.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Información Personal -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Información Personal</h3>
                        <div class="flex items-center space-x-2">
                            @if($empleado->estado == 'activo')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Activo
                                </span>
                            @elseif($empleado->estado == 'inactivo')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Inactivo
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Liquidado
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-16 w-16">
                                <div class="h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center">
                                    <span class="text-xl font-medium text-gray-700">
                                        {{ substr($empleado->nombres, 0, 1) }}{{ substr($empleado->apellidos, 0, 1) }}
                                    </span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-lg font-medium text-gray-900">
                                    {{ $empleado->nombre_completo }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $empleado->cargo }}
                                </div>
                            </div>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Cédula</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $empleado->cedula }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Fecha de Nacimiento</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $empleado->fecha_nacimiento->format('d/m/Y') }}
                                <span class="text-gray-500">({{ $empleado->edad }} años)</span>
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Género</dt>
                            <dd class="mt-1 text-sm text-gray-900 capitalize">{{ $empleado->genero }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Estado Civil</dt>
                            <dd class="mt-1 text-sm text-gray-900 capitalize">{{ str_replace('_', ' ', $empleado->estado_civil) }}</dd>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información de Contacto -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Información de Contacto</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $empleado->telefono }}</dd>
                        </div>

                        @if($empleado->celular)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Celular</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $empleado->celular }}</dd>
                        </div>
                        @endif

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <a href="mailto:{{ $empleado->email }}" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $empleado->email }}
                                </a>
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Ciudad / Departamento</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $empleado->ciudad }}, {{ $empleado->departamento }}</dd>
                        </div>

                        <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Dirección</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $empleado->direccion }}</dd>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información Laboral -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Información Laboral</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Cargo</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $empleado->cargo }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Área</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $empleado->area }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Salario</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $empleado->salario_formateado }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tipo de Contrato</dt>
                            <dd class="mt-1 text-sm text-gray-900 capitalize">{{ str_replace('_', ' ', $empleado->tipo_contrato) }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Fecha de Ingreso</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $empleado->fecha_ingreso->format('d/m/Y') }}
                                <span class="text-gray-500">({{ $empleado->antiguedad }})</span>
                            </dd>
                        </div>

                        @if($empleado->fecha_fin_contrato)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Fecha Fin Contrato</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $empleado->fecha_fin_contrato->format('d/m/Y') }}</dd>
                        </div>
                        @endif

                        @if($empleado->jefe_inmediato)
                        <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Jefe Inmediato</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $empleado->jefe_inmediato }}</dd>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Información de Seguridad Social -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Seguridad Social</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($empleado->eps)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">EPS</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $empleado->eps }}</dd>
                        </div>
                        @endif

                        @if($empleado->arl)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">ARL</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $empleado->arl }}</dd>
                        </div>
                        @endif

                        @if($empleado->fondo_pension)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Fondo de Pensión</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $empleado->fondo_pension }}</dd>
                        </div>
                        @endif

                        @if($empleado->caja_compensacion)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Caja de Compensación</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $empleado->caja_compensacion }}</dd>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Información Académica -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Información Académica</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nivel Educativo</dt>
                            <dd class="mt-1 text-sm text-gray-900 capitalize">{{ str_replace('_', ' ', $empleado->nivel_educativo) }}</dd>
                        </div>

                        @if($empleado->titulo_obtenido)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Título Obtenido</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $empleado->titulo_obtenido }}</dd>
                        </div>
                        @endif

                        @if($empleado->institucion)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Institución</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $empleado->institucion }}</dd>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Contacto de Emergencia -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Contacto de Emergencia</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nombre Completo</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $empleado->contacto_emergencia_nombre }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $empleado->contacto_emergencia_telefono }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Parentesco</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $empleado->contacto_emergencia_parentesco }}</dd>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información de Auditoría -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Información de Auditoría</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Creado por</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $empleado->createdBy ? $empleado->createdBy->name : 'Sistema' }}
                                @if($empleado->created_at)
                                    <span class="text-gray-500">el {{ $empleado->created_at->format('d/m/Y H:i') }}</span>
                                @endif
                            </dd>
                        </div>

                        @if($empleado->updated_at && $empleado->updatedBy)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Última modificación</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $empleado->updatedBy->name }}
                                <span class="text-gray-500">el {{ $empleado->updated_at->format('d/m/Y H:i') }}</span>
                            </dd>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>