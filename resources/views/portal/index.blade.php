<x-portal-layout title="Oportunidades Laborales">
    <!-- Hero Section -->
    <section class="hero-gradient py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                Construye tu futuro con nosotros
            </h1>
            <p class="text-xl text-blue-100 mb-8 max-w-3xl mx-auto">
                Únete al equipo líder en monitoreo vehicular y tecnología GPS. 
                Encuentra oportunidades que impulsen tu carrera profesional.
            </p>
            <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="#vacantes" 
                   class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors shadow-lg">
                    Ver Vacantes Disponibles
                </a>
                <a href="{{ route('portal.consultar') }}" 
                   class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                    Consultar mi Aplicación
                </a>
            </div>
        </div>
    </section>

    <!-- Search and Filters -->
    <section class="py-8 bg-white shadow-sm" id="vacantes">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('portal.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Área</label>
                        <select name="area" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Todas las áreas</option>
                            @foreach($areas as $area)
                                <option value="{{ $area }}" {{ request('area') == $area ? 'selected' : '' }}>
                                    {{ $area }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ubicación</label>
                        <select name="ubicacion" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Todas las ubicaciones</option>
                            @foreach($ubicaciones as $ubicacion)
                                <option value="{{ $ubicacion }}" {{ request('ubicacion') == $ubicacion ? 'selected' : '' }}>
                                    {{ $ubicacion }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Contrato</label>
                        <select name="tipo_contrato" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Todos los tipos</option>
                            <option value="indefinido" {{ request('tipo_contrato') == 'indefinido' ? 'selected' : '' }}>Indefinido</option>
                            <option value="fijo" {{ request('tipo_contrato') == 'fijo' ? 'selected' : '' }}>Término Fijo</option>
                            <option value="prestacion_servicios" {{ request('tipo_contrato') == 'prestacion_servicios' ? 'selected' : '' }}>Prestación de Servicios</option>
                            <option value="temporal" {{ request('tipo_contrato') == 'temporal' ? 'selected' : '' }}>Temporal</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Modalidad</label>
                        <select name="modalidad" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Todas las modalidades</option>
                            <option value="presencial" {{ request('modalidad') == 'presencial' ? 'selected' : '' }}>Presencial</option>
                            <option value="remoto" {{ request('modalidad') == 'remoto' ? 'selected' : '' }}>Remoto</option>
                            <option value="hibrido" {{ request('modalidad') == 'hibrido' ? 'selected' : '' }}>Híbrido</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-center">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2 rounded-md font-medium transition-colors">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Buscar Vacantes
                    </button>
                    @if(request()->hasAny(['area', 'ubicacion', 'tipo_contrato', 'modalidad']))
                        <a href="{{ route('portal.index') }}" 
                           class="ml-4 bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-md font-medium transition-colors">
                            Limpiar Filtros
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </section>

    <!-- Vacantes List -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">
                    Vacantes Disponibles
                </h2>
                <p class="text-gray-600">
                    {{ $vacantes->total() }} oportunidad{{ $vacantes->total() != 1 ? 'es' : '' }} encontrada{{ $vacantes->total() != 1 ? 's' : '' }}
                </p>
            </div>

            @if($vacantes->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                    @foreach($vacantes as $vacante)
                        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow card-hover">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex-1">
                                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                            {{ $vacante->titulo }}
                                        </h3>
                                        <p class="text-blue-600 font-medium">{{ $vacante->area }}</p>
                                    </div>
                                    @if($vacante->prioridad === 'alta')
                                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                            Urgente
                                        </span>
                                    @endif
                                </div>

                                <div class="space-y-2 mb-4 text-sm text-gray-600">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ $vacante->ubicacion }}
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0v2a2 2 0 01-2 2H10a2 2 0 01-2-2V6"></path>
                                        </svg>
                                        {{ ucfirst(str_replace('_', ' ', $vacante->tipo_contrato)) }}
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ ucfirst($vacante->modalidad) }}
                                    </div>
                                    @if($vacante->salario_minimo || $vacante->salario_maximo)
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                            </svg>
                                            @if($vacante->salario_minimo && $vacante->salario_maximo)
                                                ${{ number_format($vacante->salario_minimo) }} - ${{ number_format($vacante->salario_maximo) }}
                                            @elseif($vacante->salario_minimo)
                                                Desde ${{ number_format($vacante->salario_minimo) }}
                                            @else
                                                Hasta ${{ number_format($vacante->salario_maximo) }}
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                    {{ Str::limit(strip_tags($vacante->descripcion), 120) }}
                                </p>

                                <div class="flex justify-between items-center">
                                    <div class="text-xs text-gray-500">
                                        <div>Cierra: {{ \Carbon\Carbon::parse($vacante->fecha_cierre)->format('d/m/Y') }}</div>
                                        <div>{{ $vacante->aplicaciones }} aplicacion{{ $vacante->aplicaciones != 1 ? 'es' : '' }}</div>
                                    </div>
                                    <div class="space-x-2">
                                        <a href="{{ route('portal.vacante', $vacante) }}" 
                                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            Ver Detalles
                                        </a>
                                        <a href="{{ route('portal.aplicar', $vacante) }}" 
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                            Aplicar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $vacantes->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No se encontraron vacantes</h3>
                    <p class="text-gray-500 mb-4">
                        No hay vacantes disponibles que coincidan con los filtros seleccionados.
                    </p>
                    <a href="{{ route('portal.index') }}" 
                       class="text-blue-600 hover:text-blue-800 font-medium">
                        Ver todas las vacantes disponibles
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Why Work With Us -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">
                    ¿Por qué trabajar con nosotros?
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Ofrecemos un ambiente de trabajo dinámico, oportunidades de crecimiento 
                    y beneficios competitivos en la industria de tecnología vehicular.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Innovación Constante</h3>
                    <p class="text-gray-600 text-sm">
                        Trabajamos con las últimas tecnologías en monitoreo vehicular y GPS.
                    </p>
                </div>

                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Salarios Competitivos</h3>
                    <p class="text-gray-600 text-sm">
                        Ofrecemos salarios acordes al mercado y beneficios adicionales.
                    </p>
                </div>

                <div class="text-center">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Crecimiento Profesional</h3>
                    <p class="text-gray-600 text-sm">
                        Capacitaciones constantes y oportunidades de ascenso interno.
                    </p>
                </div>

                <div class="text-center">
                    <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Buen Ambiente</h3>
                    <p class="text-gray-600 text-sm">
                        Trabajo en equipo, flexibilidad y balance vida-trabajo.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-16 bg-gray-900 text-white">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold mb-4">
                ¿Listo para unirte a nuestro equipo?
            </h2>
            <p class="text-xl text-gray-300 mb-8">
                Explora nuestras vacantes disponibles y encuentra la oportunidad perfecta para tu carrera.
            </p>
            <div class="space-x-4">
                <a href="#vacantes" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors inline-block">
                    Ver Todas las Vacantes
                </a>
                <a href="{{ route('portal.consultar') }}" 
                   class="border-2 border-white text-white hover:bg-white hover:text-gray-900 px-8 py-3 rounded-lg font-semibold transition-colors inline-block">
                    Consultar mi Estado
                </a>
            </div>
        </div>
    </section>
</x-portal-layout>

@push('scripts')
<script>
    // Smooth scroll para enlaces internos
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
</script>
@endpush