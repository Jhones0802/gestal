<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalles del Candidato') }}: {{ $candidato->nombre_completo }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('candidatos.edit', $candidato) }}" 
                   style="display: inline-flex; align-items: center; padding: 8px 16px; background-color: #d97706; color: white; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px;">
                    <svg style="width: 16px; height: 16px; margin-right: 8px; fill: none; stroke: currentColor;" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Editar
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Mensajes de éxito -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Información General y Estado -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Información General</h3>
                        <div class="flex items-center space-x-3">
                            @if($candidato->estado == 'aplicado')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    Aplicado
                                </span>
                            @elseif($candidato->estado == 'preseleccionado')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    Preseleccionado
                                </span>
                            @elseif(in_array($candidato->estado, ['entrevista_inicial', 'pruebas_psicotecnicas', 'entrevista_tecnica', 'verificacion_referencias']))
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                                    En Proceso
                                </span>
                            @elseif($candidato->estado == 'aprobado')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    Aprobado
                                </span>
                            @elseif($candidato->estado == 'contratado')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                    Contratado
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    Rechazado
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-16 w-16">
                                <div class="h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center">
                                    <span class="text-xl font-medium text-gray-700">
                                        {{ substr($candidato->nombres, 0, 1) }}{{ substr($candidato->apellidos, 0, 1) }}
                                    </span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-lg font-medium text-gray-900">
                                    {{ $candidato->nombre_completo }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $candidato->vacante->titulo }}
                                </div>
                            </div>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Cédula</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $candidato->cedula }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Fecha de Nacimiento</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $candidato->fecha_nacimiento->format('d/m/Y') }}
                                <span class="text-gray-500">({{ $candidato->edad }} años)</span>
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Género</dt>
                            <dd class="mt-1 text-sm text-gray-900 capitalize">{{ $candidato->genero }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <a href="mailto:{{ $candidato->email }}" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $candidato->email }}
                                </a>
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Teléfonos</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $candidato->telefono }}
                                @if($candidato->celular)
                                    <br><span class="text-gray-500">Cel: {{ $candidato->celular }}</span>
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Fecha de Aplicación</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $candidato->fecha_aplicacion->format('d/m/Y') }}
                                <span class="text-gray-500">({{ $candidato->dias_aplicacion }})</span>
                            </dd>
                        </div>

                        @if($candidato->pretension_salarial)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Pretensión Salarial</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $candidato->pretension_formateada }}</dd>
                        </div>
                        @endif

                        @if($candidato->puntaje_total)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Puntaje Total</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $candidato->puntaje_total }}</dd>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Vacante -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Vacante</h3>
                        <a href="{{ route('vacantes.show', $candidato->vacante) }}" 
                           class="text-indigo-600 hover:text-indigo-900 text-sm">
                            Ver detalles de la vacante →
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Título</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $candidato->vacante->titulo }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Área</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $candidato->vacante->area }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Salario Ofrecido</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $candidato->vacante->salario_rango }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Estado de la Vacante</dt>
                            <dd class="mt-1 text-sm text-gray-900 capitalize">{{ $candidato->vacante->estado }}</dd>
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
                            <dt class="text-sm font-medium text-gray-500">Ciudad / Departamento</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $candidato->ciudad }}, {{ $candidato->departamento }}</dd>
                        </div>

                        <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Dirección</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $candidato->direccion }}</dd>
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
                            <dt class="text-sm font-medium text-gray-500">Nivel Educativo</dt>
                            <dd class="mt-1 text-sm text-gray-900 capitalize">{{ str_replace('_', ' ', $candidato->nivel_educativo) }}</dd>
                        </div>

                        @if($candidato->titulo_obtenido)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Título Obtenido</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $candidato->titulo_obtenido }}</dd>
                        </div>
                        @endif

                        @if($candidato->institucion)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Institución</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $candidato->institucion }}</dd>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Experiencia Laboral -->
            @if($candidato->experiencia_laboral)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Experiencia Laboral</h3>
                    <div class="prose max-w-none">
                        <p class="text-gray-700 whitespace-pre-line">{{ $candidato->experiencia_laboral }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Documentos -->
            @if($candidato->hoja_vida_path)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Documentos</h3>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <svg class="w-8 h-8 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Hoja de Vida</p>
                                <p class="text-xs text-gray-500">{{ basename($candidato->hoja_vida_path) }}</p>
                            </div>
                        </div>
                        <a href="{{ Storage::url($candidato->hoja_vida_path) }}" 
                           target="_blank"
                           style="display: inline-flex; align-items: center; padding: 8px 16px; background-color: #059669; color: white; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px;">
                            <svg style="width: 16px; height: 16px; margin-right: 8px; fill: none; stroke: currentColor;" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Descargar
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Observaciones -->
            @if($candidato->observaciones)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Observaciones</h3>
                    <div class="prose max-w-none">
                        <p class="text-gray-700 whitespace-pre-line">{{ $candidato->observaciones }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Proceso de Selección -->
            @if($candidato->evaluaciones->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Proceso de Selección</h3>
                    <div class="space-y-4">
                        @foreach($candidato->evaluaciones as $evaluacion)
                            <div class="border rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-medium text-gray-900">{{ $evaluacion->tipo_evaluacion_formateada }}</h4>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($evaluacion->estado == 'realizada') bg-green-100 text-green-800
                                        @elseif($evaluacion->estado == 'programada') bg-blue-100 text-blue-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($evaluacion->estado) }}
                                    </span>
                                </div>
                                
                                @if($evaluacion->fecha_programada)
                                <p class="text-sm text-gray-600">Fecha: {{ $evaluacion->fecha_programada->format('d/m/Y') }}</p>
                                @endif
                                
                                @if($evaluacion->puntaje)
                                <p class="text-sm text-gray-600">Puntaje: {{ $evaluacion->puntaje }}/{{ $evaluacion->puntaje_maximo }} ({{ $evaluacion->porcentaje }}%)</p>
                                @endif
                                
                                @if($evaluacion->observaciones)
                                <p class="text-sm text-gray-700 mt-2">{{ $evaluacion->observaciones }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Información de Auditoría -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Información de Auditoría</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Registrado por</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $candidato->createdBy ? $candidato->createdBy->name : 'Sistema' }}
                                @if($candidato->created_at)
                                    <span class="text-gray-500">el {{ $candidato->created_at->format('d/m/Y H:i') }}</span>
                                @endif
                            </dd>
                        </div>

                        @if($candidato->updated_at && $candidato->updatedBy)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Última modificación</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $candidato->updatedBy->name }}
                                <span class="text-gray-500">el {{ $candidato->updated_at->format('d/m/Y H:i') }}</span>
                            </dd>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Acciones</h3>
                    <div class="flex flex-wrap gap-3">
                        @if($candidato->puedeSerPreseleccionado())
                            <form action="{{ route('candidatos.cambiar-estado', $candidato) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="nuevo_estado" value="preseleccionado">
                                <button type="submit" 
                                        class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                    Preseleccionar
                                </button>
                            </form>
                        @endif

                        @if($candidato->puedeSerEntrevistado())
                            <form action="{{ route('candidatos.cambiar-estado', $candidato) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="nuevo_estado" value="entrevista_inicial">
                                <button type="submit" 
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Programar Entrevista
                                </button>
                            </form>
                        @endif

                        @if(in_array($candidato->estado, ['entrevista_inicial', 'pruebas_psicotecnicas', 'entrevista_tecnica', 'verificacion_referencias']))
                            <form action="{{ route('candidatos.cambiar-estado', $candidato) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="nuevo_estado" value="aprobado">
                                <button type="submit" 
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Aprobar
                                </button>
                            </form>
                        @endif

                        @if($candidato->puedeSerContratado())
                            <form action="{{ route('candidatos.cambiar-estado', $candidato) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="nuevo_estado" value="contratado">
                                <button type="submit" 
                                        class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                    Contratar
                                </button>
                            </form>
                        @endif

                        @if(!in_array($candidato->estado, ['rechazado', 'contratado']))
                            <form action="{{ route('candidatos.cambiar-estado', $candidato) }}" method="POST" class="inline"
                                  onsubmit="return confirm('¿Está seguro de rechazar este candidato?')">
                                @csrf
                                <input type="hidden" name="nuevo_estado" value="rechazado">
                                <button type="submit" 
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Rechazar
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>