<x-portal-layout title="Consultar Estado">
    <div class="py-12 bg-gray-50">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Consultar Estado</h1>
                <p class="text-gray-600">
                    Ingresa tus datos para consultar el estado de tu aplicación
                </p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <form method="POST" action="{{ route('portal.consultar.post') }}" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Número de Documento</label>
                        <input type="text" 
                               name="numero_documento" 
                               value="{{ old('numero_documento') }}" 
                               required
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    @if($errors->has('consulta'))
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                            {{ $errors->first('consulta') }}
                        </div>
                    @endif

                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-md font-semibold transition-colors">
                        Consultar Estado
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-portal-layout>