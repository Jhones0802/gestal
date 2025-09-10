<x-app-layout>
    <x-slot name="header">


    
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Candidatos') }}
            </h2>
            <div class="flex space-x-2">
    <a href="{{ route('proceso-seleccion.index') }}" 
       style="display: inline-flex; align-items: center; padding: 10px 20px; background-color: #7c3aed; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 14px;">
        <svg style="width: 16px; height: 16px; margin-right: 8px; fill: none; stroke: currentColor;" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
        </svg>
        Proceso Selección
    </a>
    <a href="{{ route('candidatos.create') }}" 
       style="display: inline-flex; align-items: center; padding: 10px 20px; background-color: #2563eb; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 14px;">
        Registrar Candidato
    </a>
</div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Mensajes de éxito -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filtros -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('candidatos.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                            <input type="text" 
                                   name="buscar" 
                                   value="{{ request('buscar') }}"
                                   placeholder="Nombre, cédula o email..."
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                            <select name="estado" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Todos</option>
                                <option value="aplicado" {{ request('estado') == 'aplicado' ? 'selected' : '' }}>Aplicado</option>
                                <option value="preseleccionado" {{ request('estado') == 'preseleccionado' ? 'selected' : '' }}>Preseleccionado</option>
                                <option value="entrevista_inicial" {{ request('estado') == 'entrevista_inicial' ? 'selected' : '' }}>Entrevista Inicial</option>
                                <option value="pruebas_psicotecnicas" {{ request('estado') == 'pruebas_psicotecnicas' ? 'selected' : '' }}>Pruebas Psicotécnicas</option>
                                <option value="entrevista_tecnica" {{ request('estado') == 'entrevista_tecnica' ? 'selected' : '' }}>Entrevista Técnica</option>
                                <option value="verificacion_referencias" {{ request('estado') == 'verificacion_referencias' ? 'selected' : '' }}>Verificación Referencias</option>
                                <option value="aprobado" {{ request('estado') == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                                <option value="rechazado" {{ request('estado') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                                <option value="contratado" {{ request('estado') == 'contratado' ? 'selected' : '' }}>Contratado</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Vacante</label>
                            <select name="vacante_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Todas</option>
                                @foreach($vacantes as $vacante)
                                    <option value="{{ $vacante->id }}" {{ request('vacante_id') == $vacante->id ? 'selected' : '' }}>
                                        {{ $vacante->titulo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="flex items-end space-x-2">
                            <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Filtrar
                            </button>
                            <a href="{{ route('candidatos.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Limpiar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de candidatos -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Candidato
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Vacante
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Contacto
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Estado
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fecha Aplicación
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Puntaje
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($candidatos as $candidato)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                        <span class="text-sm font-medium text-gray-700">
                                                            {{ substr($candidato->nombres, 0, 1) }}{{ substr($candidato->apellidos, 0, 1) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $candidato->nombre_completo }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $candidato->cedula }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">{{ $candidato->vacante->titulo }}</div>
                                            <div class="text-sm text-gray-500">{{ $candidato->vacante->area }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">{{ $candidato->email }}</div>
                                            <div class="text-sm text-gray-500">{{ $candidato->celular ?: $candidato->telefono }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($candidato->estado == 'aplicado')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Aplicado
                                                </span>
                                            @elseif($candidato->estado == 'preseleccionado')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Preseleccionado
                                                </span>
                                            @elseif(in_array($candidato->estado, ['entrevista_inicial', 'pruebas_psicotecnicas', 'entrevista_tecnica', 'verificacion_referencias']))
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                    En Proceso
                                                </span>
                                            @elseif($candidato->estado == 'aprobado')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Aprobado
                                                </span>
                                            @elseif($candidato->estado == 'contratado')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                    Contratado
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Rechazado
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $candidato->fecha_aplicacion->format('d/m/Y') }}
                                            <div class="text-xs text-gray-400">{{ $candidato->dias_aplicacion }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($candidato->puntaje_total)
                                                <span class="font-semibold">{{ $candidato->puntaje_total }}</span>
                                            @else
                                                <span class="text-gray-400">Pendiente</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-2">
                                                <a href="{{ route('candidatos.show', $candidato) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900" title="Ver detalles">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </a>
                                                
                                                <a href="{{ route('candidatos.edit', $candidato) }}" 
                                                   class="text-yellow-600 hover:text-yellow-900" title="Editar">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>

                                                @if($candidato->hoja_vida_path)
                                                    <a href="{{ Storage::url($candidato->hoja_vida_path) }}" 
                                                       target="_blank"
                                                       class="text-green-600 hover:text-green-900" title="Ver hoja de vida">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                        </svg>
                                                    </a>
                                                @endif

                                                <!-- Dropdown para cambiar estado -->
                                                <div class="relative inline-block text-left">
                                                    <button type="button" 
                                                            class="text-gray-600 hover:text-gray-900" 
                                                            onclick="toggleDropdown('dropdown-{{ $candidato->id }}')"
                                                            title="Cambiar estado">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                                        </svg>
                                                    </button>
                                                    
                                                    <div id="dropdown-{{ $candidato->id }}" 
                                                         class="hidden absolute right-0 z-10 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                                        <div class="py-1">
                                                            @if($candidato->estado == 'aplicado')
                                                                <a href="#" onclick="cambiarEstado({{ $candidato->id }}, 'preseleccionado')" 
                                                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Preseleccionar</a>
                                                            @endif
                                                            
                                                            @if($candidato->estado == 'preseleccionado')
                                                                <a href="#" onclick="cambiarEstado({{ $candidato->id }}, 'entrevista_inicial')" 
                                                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Entrevista Inicial</a>
                                                            @endif
                                                            
                                                            @if(in_array($candidato->estado, ['entrevista_inicial', 'pruebas_psicotecnicas', 'entrevista_tecnica', 'verificacion_referencias']))
                                                                <a href="#" onclick="cambiarEstado({{ $candidato->id }}, 'aprobado')" 
                                                                   class="block px-4 py-2 text-sm text-green-700 hover:bg-gray-100">Aprobar</a>
                                                            @endif
                                                            
                                                            @if($candidato->estado == 'aprobado')
                                                                <a href="#" onclick="cambiarEstado({{ $candidato->id }}, 'contratado')" 
                                                                   class="block px-4 py-2 text-sm text-purple-700 hover:bg-gray-100">Contratar</a>
                                                            @endif
                                                            
                                                            @if(!in_array($candidato->estado, ['rechazado', 'contratado']))
                                                                <a href="#" onclick="cambiarEstado({{ $candidato->id }}, 'rechazado')" 
                                                                   class="block px-4 py-2 text-sm text-red-700 hover:bg-gray-100">Rechazar</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <form action="{{ route('candidatos.destroy', $candidato) }}" 
                                                      method="POST" 
                                                      class="inline"
                                                      onsubmit="return confirm('¿Está seguro de eliminar este candidato?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Eliminar">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            No se encontraron candidatos con los criterios seleccionados.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="mt-6">
                        {{ $candidatos->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para cambiar estado -->
    <div id="modal-cambiar-estado" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 bg-black opacity-50"></div>
            <div class="relative bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-medium mb-4">Cambiar Estado del Candidato</h3>
                <form id="form-cambiar-estado" method="POST">
                    @csrf
                    <input type="hidden" name="nuevo_estado" id="nuevo_estado">
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones</label>
                        <textarea name="observaciones" rows="3" 
                                  class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                  placeholder="Agregar observaciones sobre este cambio de estado..."></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="cerrarModal()" 
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Confirmar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleDropdown(id) {
            document.getElementById(id).classList.toggle('hidden');
        }

        function cambiarEstado(candidatoId, nuevoEstado) {
            document.getElementById('nuevo_estado').value = nuevoEstado;
            document.getElementById('form-cambiar-estado').action = `/candidatos/${candidatoId}/cambiar-estado`;
            document.getElementById('modal-cambiar-estado').classList.remove('hidden');
        }

        function cerrarModal() {
            document.getElementById('modal-cambiar-estado').classList.add('hidden');
        }

        // Cerrar dropdowns al hacer clic fuera
        document.addEventListener('click', function(event) {
            const dropdowns = document.querySelectorAll('[id^="dropdown-"]');
            dropdowns.forEach(dropdown => {
                if (!dropdown.contains(event.target) && !event.target.closest('button')) {
                    dropdown.classList.add('hidden');
                }
            });
        });
    </script>
</x-app-layout>