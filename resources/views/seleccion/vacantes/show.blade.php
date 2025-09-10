<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalles de la Vacante') }}: {{ $vacante->titulo }}
            </h2>
            <div class="flex space-x-2">
                @if($vacante->estado == 'borrador')
                    <form action="{{ route('vacantes.publicar', $vacante) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                style="display: inline-flex; align-items: center; padding: 8px 16px; background-color: #059669; color: white; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px; border: none; cursor: pointer;">
                            <svg style="width: 16px; height: 16px; margin-right: 8px; fill: none; stroke: currentColor;" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            Publicar
                        </button>
                    </form>
                @elseif($vacante->estado == 'publicada')
                    <form action="{{ route('vacantes.cerrar', $vacante) }}" method="POST" class="inline"
                          onsubmit="return confirm('¿Está seguro de cerrar esta vacante?')">
                        @csrf
                        <button type="submit" 
                                style="display: inline-flex; align-items: center; padding: 8px 16px; background-color: #2563eb; color: white; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px; border: none; cursor: pointer;">
                            <svg style="width: 16px; height: 16px; margin-right: 8px; fill: none; stroke: currentColor;" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Cerrar
                        </button>
                    </form>
                @endif
                
                <a href="{{ route('vacantes.edit', $vacante) }}" 
                   style="display: inline-flex; align-items: center; padding: 8px 16px; background-color: #d97706; color: white; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px;">
                    <svg style="width: 16px; height: 16px; margin-right: 8px; fill: none; stroke: currentColor;" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Editar
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Mensajes de éxito -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Información General -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Información General</h3>
                        <div class="flex items-center space-x-3">
                            @if($vacante->estado == 'publicada')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    Publicada
                                </span>
                            @elseif($vacante->estado == 'borrador')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    Borrador
                                </span>
                            @elseif($vacante->estado == 'cerrada')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    Cerrada
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    Cancelada
                                </span>
                            @endif

                            @if($vacante->prioridad == 'urgente')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    Urgente
                                </span>
                            @elseif($vacante->prioridad == 'alta')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                                    Prioridad Alta
                                </span>
                            @elseif($vacante->prioridad == 'media')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    Prioridad Media
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    Prioridad Baja
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Título</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $vacante->titulo }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Área</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $vacante->area }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Ubicación</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $vacante->ubicacion }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Modalidad</dt>
                            <dd class="mt-1 text-sm text-gray-900 capitalize">{{ $vacante->modalidad }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Vacantes Disponibles</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $vacante->vacantes_disponibles }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Candidatos Aplicados</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $vacante->candidatos->count() }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Rango Salarial</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $vacante->salario_rango }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tipo de Contrato</dt>
                            <dd class="mt-1 text-sm text-gray-900 capitalize">{{ str_replace('_', ' ', $vacante->tipo_contrato) }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Contacto Responsable</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $vacante->contacto_responsable }}</dd>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Fecha de Publicación</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $vacante->fecha_publicacion->format('d/m/Y') }}
                                <span class="text-gray-500">({{ $vacante->dias_publicada }})</span>
                            </dd>
                        </div>

                        @if($vacante->fecha_cierre)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Fecha de Cierre</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $vacante->fecha_cierre->format('d/m/Y') }}
                                <span class="text-gray-500">({{ $vacante->dias_para_cierre }})</span>
                            </dd>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Descripción del Cargo -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Descripción del Cargo</h3>
                    <div class="prose max-w-none">
                        <p class="text-gray-700 whitespace-pre-line">{{ $vacante->descripcion }}</p>
                    </div>
                </div>
            </div>

            <!-- Responsabilidades y Requisitos -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Responsabilidades Principales</h3>
                        <div class="prose max-w-none">
                            <p class="text-gray-700 whitespace-pre-line">{{ $vacante->responsabilidades }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Requisitos Mínimos</h3>
                        <div class="prose max-w-none">
                            <p class="text-gray-700 whitespace-pre-line">{{ $vacante->requisitos }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($vacante->competencias)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Competencias Deseadas</h3>
                    <div class="prose max-w-none">
                        <p class="text-gray-700 whitespace-pre-line">{{ $vacante->competencias }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if($vacante->proceso_seleccion)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Proceso de Selección</h3>
                    <div class="prose max-w-none">
                        <p class="text-gray-700 whitespace-pre-line">{{ $vacante->proceso_seleccion }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if($vacante->documentos_requeridos && count($vacante->documentos_requeridos) > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Documentos Requeridos</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        @foreach($vacante->documentos_requeridos as $documento)
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm text-gray-700 capitalize">{{ str_replace('_', ' ', $documento) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Lista de Candidatos -->
            @if($vacante->candidatos->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Candidatos ({{ $vacante->candidatos->count() }})</h3>
                        <a href="#" 
                           style="display: inline-flex; align-items: center; padding: 8px 16px; background-color: #2563eb; color: white; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px;">
                            Ver Todos los Candidatos
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Candidato</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aplicación</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Puntaje</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($vacante->candidatos->take(5) as $candidato)
                                    <tr>
                                        <td class="px-4 py-4">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $candidato->nombre_completo }}</div>
                                                <div class="text-sm text-gray-500">{{ $candidato->email }}</div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                @if($candidato->estado == 'aplicado') bg-blue-100 text-blue-800
                                                @elseif($candidato->estado == 'preseleccionado') bg-yellow-100 text-yellow-800
                                                @elseif($candidato->estado == 'aprobado') bg-green-100 text-green-800
                                                @elseif($candidato->estado == 'rechazado') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst(str_replace('_', ' ', $candidato->estado)) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-500">
                                            {{ $candidato->fecha_aplicacion->format('d/m/Y') }}
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-500">
                                            {{ $candidato->puntaje_total ?? 'Pendiente' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                            <dt class="text-sm font-medium text-gray-500">Creada por</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $vacante->createdBy ? $vacante->createdBy->name : 'Sistema' }}
                                @if($vacante->created_at)
                                    <span class="text-gray-500">el {{ $vacante->created_at->format('d/m/Y H:i') }}</span>
                                @endif
                            </dd>
                        </div>

                        @if($vacante->updated_at && $vacante->updatedBy)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Última modificación</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $vacante->updatedBy->name }}
                                <span class="text-gray-500">el {{ $vacante->updated_at->format('d/m/Y H:i') }}</span>
                            </dd>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>