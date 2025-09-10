<x-portal-layout :title="$vacante->titulo">
    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Breadcrumb -->
            <nav class="mb-8">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li><a href="{{ route('portal.index') }}" class="hover:text-blue-600">Inicio</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="{{ route('portal.index') }}" class="hover:text-blue-600">Vacantes</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-gray-900">{{ $vacante->titulo }}</li>
                </ol>
            </nav>

            <!-- Header de la vacante -->
            <div class="bg-white rounded-lg shadow-md p-8 mb-6">
                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-4">
                            <h1 class="text-3xl font-bold text-gray-900 mr-4">{{ $vacante->titulo }}</h1>
                            @if($vacante->prioridad === 'alta')
                                <span class="bg-red-100 text-red-800 text-sm font-medium px-3 py-1 rounded-full">
                                    Urgente
                                </span>
                            @endif
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <span>{{ $vacante->area }}</span>
                            </div>
                            
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>{{ $vacante->ubicacion }}</span>
                            </div>
                            
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0v2a2 2 0 01-2 2H10a2 2 0 01-2-2V6"></path>
                                </svg>
                                <span>{{ ucfirst(str_replace('_', ' ', $vacante->tipo_contrato)) }}</span>
                            </div>
                            
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ ucfirst($vacante->modalidad) }}</span>
                            </div>
                            
                            @if($vacante->salario_minimo || $vacante->salario_maximo)
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                                <span class="font-semibold text-green-600">
                                    @if($vacante->salario_minimo && $vacante->salario_maximo)
                                        ${{ number_format($vacante->salario_minimo) }} - ${{ number_format($vacante->salario_maximo) }}
                                    @elseif($vacante->salario_minimo)
                                        Desde ${{ number_format($vacante->salario_minimo) }}
                                    @else
                                        Hasta ${{ number_format($vacante->salario_maximo) }}
                                    @endif
                                </span>
                            </div>
                            @endif
                            
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4m0 0h2a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V9a2 2 0 012-2h2m0 0V7a1 1 0 011-1h2a1 1 0 011 1v0"></path>
                                </svg>
                                <span>{{ $vacante->vacantes_disponibles }} posición{{ $vacante->vacantes_disponibles != 1 ? 'es' : '' }}</span>
                            </div>
                        </div>

                        <!-- Estadísticas -->
                        <div class="grid grid-cols-3 gap-4 py-4 border-t border-gray-200">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600">{{ $vacante->visualizaciones }}</div>
                                <div class="text-sm text-gray-500">Visualizaciones</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600">{{ $vacante->aplicaciones }}</div>
                                <div class="text-sm text-gray-500">Aplicaciones</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-purple-600">
                                    {{ \Carbon\Carbon::parse($vacante->fecha_cierre)->diffInDays(now()) }}
                                </div>
                                <div class="text-sm text-gray-500">Días restantes</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sidebar de aplicación -->
                    <div class="lg:ml-8 lg:w-80 mt-6 lg:mt-0">
                        <div class="bg-blue-50 rounded-lg p-6">
                            <div class="text-center mb-4">
                                <div class="text-sm text-gray-600 mb-2">Fecha límite de aplicación</div>
                                <div class="text-lg font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($vacante->fecha_cierre)->format('d \d\e F, Y') }}
                                </div>
                            </div>
                            
                            <a href="{{ route('portal.aplicar', $vacante) }}" 
                               class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-lg font-semibold text-center block transition-colors mb-4">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Aplicar Ahora
                            </a>
                            
                            <div class="text-xs text-gray-600 text-center">
                                Al aplicar, aceptas nuestros términos y condiciones
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenido principal -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Columna principal -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Descripción -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Descripción del Cargo</h2>
                        <div class="prose prose-blue max-w-none">
                            {!! nl2br(e($vacante->descripcion)) !!}
                        </div>
                    </div>

                    <!-- Responsabilidades -->
                    @if($vacante->responsabilidades)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Responsabilidades</h2>
                        <div class="prose prose-blue max-w-none">
                            {!! nl2br(e($vacante->responsabilidades)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Requisitos -->
                    @if($vacante->requisitos)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Requisitos</h2>
                        <div class="prose prose-blue max-w-none">
                            {!! nl2br(e($vacante->requisitos)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Competencias -->
                    @if($vacante->competencias)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Competencias Requeridas</h2>
                        <div class="prose prose-blue max-w-none">
                            {!! nl2br(e($vacante->competencias)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Proceso de selección -->
                    @if($vacante->proceso_seleccion)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Proceso de Selección</h2>
                        <div class="prose prose-blue max-w-none">
                            {!! nl2br(e($vacante->proceso_seleccion)) !!}
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    
                    <!-- Información adicional -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Información Adicional</h3>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-gray-700 block">Nivel educativo:</span>
                                <span class="text-sm text-gray-900">{{ ucfirst($vacante->nivel_educativo ?? 'No especificado') }}</span>
                            </div>
                            
                            @if($vacante->experiencia_requerida)
                            <div>
                                <span class="text-sm font-medium text-gray-700 block">Experiencia:</span>
                                <span class="text-sm text-gray-900">{{ $vacante->experiencia_requerida }}</span>
                            </div>
                            @endif
                            
                            @if($vacante->contacto_responsable)
                            <div>
                                <span class="text-sm font-medium text-gray-700 block">Contacto:</span>
                                <span class="text-sm text-gray-900">{{ $vacante->contacto_responsable }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Documentos requeridos -->
                    @if($vacante->documentos_requeridos)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Documentos Requeridos</h3>
                        <div class="prose prose-sm max-w-none">
                            {!! nl2br(e($vacante->documentos_requeridos)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Call to action -->
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg p-6 text-white text-center">
                        <h3 class="text-lg font-semibold mb-2">¿Listo para aplicar?</h3>
                        <p class="text-sm mb-4 text-blue-100">
                            No pierdas esta oportunidad de unirte a nuestro equipo
                        </p>
                        <a href="{{ route('portal.aplicar', $vacante) }}" 
                           class="bg-white text-blue-600 py-2 px-6 rounded-lg font-semibold hover:bg-blue-50 transition-colors inline-block">
                            Aplicar Ahora
                        </a>
                    </div>

                    <!-- Compartir -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Compartir Vacante</h3>
                        <div class="flex space-x-3">
                            <button onclick="shareOnWhatsApp()" 
                                    class="flex-1 bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-md text-sm font-medium transition-colors">
                                WhatsApp
                            </button>
                            <button onclick="copyLink()" 
                                    class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-md text-sm font-medium transition-colors">
                                Copiar Link
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function shareOnWhatsApp() {
            const text = `¡Mira esta oportunidad laboral!\n\n*{{ $vacante->titulo }}*\n{{ $vacante->area }} - {{ $vacante->ubicacion }}\n\n{{ url()->current() }}`;
            const url = `https://wa.me/?text=${encodeURIComponent(text)}`;
            window.open(url, '_blank');
        }

        function copyLink() {
            navigator.clipboard.writeText(window.location.href).then(function() {
                alert('Link copiado al portapapeles');
            });
        }
    </script>
    @endpush
</x-portal-layout>