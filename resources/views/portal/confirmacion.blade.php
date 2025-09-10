<x-portal-layout title="Aplicación Enviada">
    <div class="py-16 bg-gray-50">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            
            <!-- Icono de éxito -->
            <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-4">¡Aplicación Enviada!</h1>
            
            <p class="text-lg text-gray-600 mb-8">
                Tu aplicación para la posición de <strong>{{ $vacante->titulo }}</strong> 
                ha sido enviada exitosamente.
            </p>

            <div class="bg-white rounded-lg shadow-md p-6 mb-8 text-left">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Detalles de tu aplicación:</h3>
                <div class="space-y-2 text-sm">
                    <div><strong>Candidato:</strong> {{ $candidato->nombres }} {{ $candidato->apellidos }}</div>
                    <div><strong>Email:</strong> {{ $candidato->email }}</div>
                    <div><strong>Documento:</strong> {{ $candidato->numero_documento }}</div>
                    <div><strong>Fecha de aplicación:</strong> {{ $candidato->fecha_aplicacion->format('d/m/Y H:i') }}</div>
                    <div><strong>Estado:</strong> <span class="text-blue-600">Aplicado</span></div>
                </div>
            </div>

            <div class="bg-blue-50 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-blue-900 mb-2">¿Qué sigue ahora?</h3>
                <ul class="text-blue-800 text-sm space-y-2 text-left">
                    <li>• Recibirás un email de confirmación en los próximos minutos</li>
                    <li>• Nuestro equipo de RRHH revisará tu aplicación</li>
                    <li>• Te contactaremos si cumples con el perfil requerido</li>
                    <li>• Puedes consultar el estado de tu proceso en cualquier momento</li>
                </ul>
            </div>

            <div class="space-y-4 sm:space-y-0 sm:space-x-4 sm:flex sm:justify-center">
                <a href="{{ route('portal.consultar') }}" 
                   class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-lg font-semibold transition-colors inline-block">
                    Consultar Estado
                </a>
                <a href="{{ route('portal.index') }}" 
                   class="w-full sm:w-auto bg-gray-300 hover:bg-gray-400 text-gray-700 py-3 px-6 rounded-lg font-semibold transition-colors inline-block">
                    Ver Más Vacantes
                </a>
            </div>
        </div>
    </div>
</x-portal-layout>