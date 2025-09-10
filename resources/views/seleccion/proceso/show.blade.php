<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalle de Evaluación') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('proceso-seleccion.edit', $procesoSeleccion) }}" 
                   class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500 focus:bg-yellow-500 active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-5m-5 5L20 4m-2 0h4v4m-4-4L9 13"></path>
                    </svg>
                    Editar
                </a>
                <a href="{{ route('proceso-seleccion.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:bg-gray-500 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Información del Candidato -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Información del Candidato</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Candidato</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $procesoSeleccion->candidato->nombres }} {{ $procesoSeleccion->candidato->apellidos }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $procesoSeleccion->candidato->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $procesoSeleccion->candidato->telefono }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Vacante</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $procesoSeleccion->candidato->vacante->titulo }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Estado del Candidato</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($procesoSeleccion->candidato->estado === 'aplicado') bg-blue-100 text-blue-800
                                @elseif($procesoSeleccion->candidato->estado === 'preseleccionado') bg-yellow-100 text-yellow-800
                                @elseif($procesoSeleccion->candidato->estado === 'entrevista_inicial') bg-purple-100 text-purple-800
                                @elseif($procesoSeleccion->candidato->estado === 'pruebas_psicotecnicas') bg-indigo-100 text-indigo-800
                                @elseif($procesoSeleccion->candidato->estado === 'entrevista_tecnica') bg-pink-100 text-pink-800
                                @elseif($procesoSeleccion->candidato->estado === 'verificacion_referencias') bg-orange-100 text-orange-800
                                @elseif($procesoSeleccion->candidato->estado === 'aprobado') bg-green-100 text-green-800
                                @elseif($procesoSeleccion->candidato->estado === 'rechazado') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $procesoSeleccion->candidato->estado)) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información de la Evaluación -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Detalles de la Evaluación</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tipo de Evaluación</label>
                            <p class="mt-1 text-sm text-gray-900">
                                @switch($procesoSeleccion->tipo_evaluacion)
                                    @case('entrevista_inicial') Entrevista Inicial @break
                                    @case('prueba_psicotecnica') Prueba Psicotécnica @break
                                    @case('entrevista_tecnica') Entrevista Técnica @break
                                    @case('verificacion_referencias') Verificación de Referencias @break
                                    @case('examen_medico') Examen Médico @break
                                    @default {{ $procesoSeleccion->tipo_evaluacion }}
                                @endswitch
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Estado</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($procesoSeleccion->estado === 'programada') bg-blue-100 text-blue-800
                                @elseif($procesoSeleccion->estado === 'realizada') bg-green-100 text-green-800
                                @elseif($procesoSeleccion->estado === 'cancelada') bg-red-100 text-red-800
                                @elseif($procesoSeleccion->estado === 'reprogramada') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($procesoSeleccion->estado) }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Resultado</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($procesoSeleccion->resultado === 'aprobado') bg-green-100 text-green-800
                                @elseif($procesoSeleccion->resultado === 'rechazado') bg-red-100 text-red-800
                                @elseif($procesoSeleccion->resultado === 'pendiente') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($procesoSeleccion->resultado) }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha Programada</label>
                            <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($procesoSeleccion->fecha_programada)->format('d/m/Y') }}</p>
                        </div>
                        @if($procesoSeleccion->hora_programada)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Hora Programada</label>
                            <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($procesoSeleccion->hora_programada)->format('H:i') }}</p>
                        </div>
                        @endif
                        @if($procesoSeleccion->fecha_realizada)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha Realizada</label>
                            <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($procesoSeleccion->fecha_realizada)->format('d/m/Y') }}</p>
                        </div>
                        @endif
                        @if($procesoSeleccion->entrevistador)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Entrevistador/Evaluador</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $procesoSeleccion->entrevistador }}</p>
                        </div>
                        @endif
                        @if($procesoSeleccion->lugar_evaluacion)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Lugar de Evaluación</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $procesoSeleccion->lugar_evaluacion }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Resultados y Calificación -->
            @if($procesoSeleccion->estado === 'realizada')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Resultados y Calificación</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($procesoSeleccion->puntaje !== null)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Puntaje Obtenido</label>
                            <div class="mt-1 flex items-center">
                                <span class="text-2xl font-bold text-gray-900">{{ $procesoSeleccion->puntaje }}</span>
                                <span class="text-sm text-gray-500 ml-1">/ {{ $procesoSeleccion->puntaje_maximo ?? 100 }}</span>
                                <div class="ml-3 flex-1 bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($procesoSeleccion->puntaje / ($procesoSeleccion->puntaje_maximo ?? 100)) * 100 }}%"></div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Observaciones y Comentarios -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Observaciones y Comentarios</h3>
                    <div class="space-y-6">
                        @if($procesoSeleccion->observaciones)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones Generales</label>
                            <div class="bg-gray-50 rounded-md p-3">
                                <p class="text-sm text-gray-900">{{ $procesoSeleccion->observaciones }}</p>
                            </div>
                        </div>
                        @endif

                        @if($procesoSeleccion->fortalezas)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fortalezas Identificadas</label>
                            <div class="bg-green-50 rounded-md p-3">
                                <p class="text-sm text-green-900">{{ $procesoSeleccion->fortalezas }}</p>
                            </div>
                        </div>
                        @endif

                        @if($procesoSeleccion->debilidades)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Áreas de Mejora</label>
                            <div class="bg-yellow-50 rounded-md p-3">
                                <p class="text-sm text-yellow-900">{{ $procesoSeleccion->debilidades }}</p>
                            </div>
                        </div>
                        @endif

                        @if($procesoSeleccion->recomendaciones)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Recomendaciones</label>
                            <div class="bg-blue-50 rounded-md p-3">
                                <p class="text-sm text-blue-900">{{ $procesoSeleccion->recomendaciones }}</p>
                            </div>
                        </div>
                        @endif
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
                            <label class="block text-sm font-medium text-gray-700">Creado por</label>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $procesoSeleccion->createdBy->name ?? 'Sistema' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha de Creación</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $procesoSeleccion->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @if($procesoSeleccion->updated_by)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Última Actualización por</label>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $procesoSeleccion->updatedBy->name ?? 'Sistema' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha de Actualización</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $procesoSeleccion->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>