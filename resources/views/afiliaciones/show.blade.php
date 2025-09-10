<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalle de Afiliación') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('afiliaciones.edit', $afiliacion) }}" 
                   class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500 focus:bg-yellow-500 active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-5m-5 5L20 4m-2 0h4v4m-4-4L9 13"></path>
                    </svg>
                    Editar
                </a>
                <a href="{{ route('afiliaciones.index') }}" 
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
            
            <!-- Estado y Acciones Rápidas -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">
                                {{ $afiliacion->entidad_tipo_label }} - {{ $afiliacion->entidad_nombre }}
                            </h3>
                            <div class="flex items-center space-x-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    @if($afiliacion->estado_color === 'gray') bg-gray-100 text-gray-800
                                    @elseif($afiliacion->estado_color === 'yellow') bg-yellow-100 text-yellow-800
                                    @elseif($afiliacion->estado_color === 'blue') bg-blue-100 text-blue-800
                                    @elseif($afiliacion->estado_color === 'green') bg-green-100 text-green-800
                                    @elseif($afiliacion->estado_color === 'red') bg-red-100 text-red-800
                                    @elseif($afiliacion->estado_color === 'emerald') bg-emerald-100 text-emerald-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $afiliacion->estado_label }}
                                </span>
                                
                                @if($afiliacion->estaVencida())
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        Vencida
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Acciones rápidas -->
                        <div class="flex space-x-2">
                            @if($afiliacion->puedeEnviarse())
                                <form method="POST" action="{{ route('afiliaciones.enviar', $afiliacion) }}" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="inline-flex items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:bg-green-500 active:bg-green-700 transition ease-in-out duration-150"
                                            onclick="return confirm('¿Confirma el envío de esta solicitud?')">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                        Enviar
                                    </button>
                                </form>
                            @endif
                            
                            @if($afiliacion->puedeCompletarse())
                                <form method="POST" action="{{ route('afiliaciones.completar', $afiliacion) }}" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="inline-flex items-center px-3 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-500 focus:bg-purple-500 active:bg-purple-700 transition ease-in-out duration-150"
                                            onclick="return confirm('¿Confirma completar esta afiliación?')">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Completar
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del Empleado -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Información del Empleado</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $afiliacion->empleado->nombres }} {{ $afiliacion->empleado->apellidos }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Número de Documento</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $afiliacion->empleado->cedula }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $afiliacion->empleado->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $afiliacion->empleado->telefono }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cargo</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $afiliacion->empleado->cargo ?? 'No especificado' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha de Ingreso</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $afiliacion->empleado->fecha_ingreso ? $afiliacion->empleado->fecha_ingreso->format('d/m/Y') : 'No especificada' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detalles de la Afiliación -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Detalles de la Afiliación</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tipo de Entidad</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $afiliacion->entidad_tipo_label }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Entidad</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $afiliacion->entidad_nombre }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha de Solicitud</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $afiliacion->fecha_solicitud->format('d/m/Y') }}</p>
                        </div>
                        
                        @if($afiliacion->numero_radicado)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Número de Radicado</label>
                            <p class="mt-1 text-sm text-gray-900 font-mono">{{ $afiliacion->numero_radicado }}</p>
                        </div>
                        @endif
                        
                        @if($afiliacion->fecha_envio)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha de Envío</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $afiliacion->fecha_envio->format('d/m/Y') }}</p>
                        </div>
                        @endif
                        
                        @if($afiliacion->fecha_respuesta_estimada)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Respuesta Estimada</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $afiliacion->fecha_respuesta_estimada->format('d/m/Y') }}</p>
                        </div>
                        @endif
                        
                        @if($afiliacion->fecha_respuesta)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha de Respuesta</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $afiliacion->fecha_respuesta->format('d/m/Y') }}</p>
                        </div>
                        @endif
                        
                        @if($afiliacion->fecha_afiliacion_efectiva)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Afiliación Efectiva</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $afiliacion->fecha_afiliacion_efectiva->format('d/m/Y') }}</p>
                        </div>
                        @endif
                        
                        @if($afiliacion->numero_afiliado)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Número de Afiliado</label>
                            <p class="mt-1 text-sm text-gray-900 font-mono text-green-600 font-semibold">{{ $afiliacion->numero_afiliado }}</p>
                        </div>
                        @endif
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Días de Respuesta Estimados</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $afiliacion->dias_respuesta_estimados }} días</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documentos Requeridos -->
            @if($afiliacion->documentos_requeridos)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Documentos Requeridos</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($afiliacion->documentos_requeridos as $documento)
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm text-gray-700">{{ $documento }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Documentos Adjuntos -->
            @if($afiliacion->documentos_adjuntos && count($afiliacion->documentos_adjuntos) > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Documentos Adjuntos</h3>
                    <div class="space-y-3">
                        @foreach($afiliacion->documentos_adjuntos as $archivo)
                            <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                                <div class="flex items-center">
                                    <svg class="w-8 h-8 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $archivo['nombre'] ?? 'Documento' }}</p>
                                        <p class="text-xs text-gray-500">{{ $archivo['tipo'] ?? 'PDF' }} - {{ $archivo['tamaño'] ?? 'Tamaño no disponible' }}</p>
                                    </div>
                                </div>
                                <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Descargar</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Certificado de Afiliación -->
            @if($afiliacion->certificado_afiliacion && $afiliacion->estado === 'completada')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Certificado de Afiliación</h3>
                    <div class="flex items-center justify-between p-4 border border-green-200 bg-green-50 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-8 h-8 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-green-900">Certificado Oficial de Afiliación</p>
                                <p class="text-xs text-green-700">Documento PDF generado automáticamente</p>
                            </div>
                        </div>
                        <a href="{{ route('afiliaciones.certificado', $afiliacion) }}" 
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                            Descargar PDF
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Observaciones y Comentarios -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Observaciones y Comentarios</h3>
                    <div class="space-y-6">
                        @if($afiliacion->observaciones)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones Generales</label>
                            <div class="bg-gray-50 rounded-md p-3">
                                <p class="text-sm text-gray-900">{{ $afiliacion->observaciones }}</p>
                            </div>
                        </div>
                        @endif

                        @if($afiliacion->motivo_rechazo)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Motivo de Rechazo</label>
                            <div class="bg-red-50 border border-red-200 rounded-md p-3">
                                <p class="text-sm text-red-900">{{ $afiliacion->motivo_rechazo }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Información de Auditoría -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Información de Auditoría</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Creado por</label>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $afiliacion->createdBy->name ?? 'Sistema' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha de Creación</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $afiliacion->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @if($afiliacion->updated_by)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Última Actualización por</label>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $afiliacion->updatedBy->name ?? 'Sistema' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha de Actualización</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $afiliacion->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @endif
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Notificación al Empleado</label>
                            <p class="mt-1 text-sm">
                                @if($afiliacion->notificacion_empleado_enviada)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                        </svg>
                                        Enviada
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Pendiente
                                    </span>
                                @endif
                            </p>
                        </div>
                        @if($afiliacion->fecha_ultima_notificacion)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Última Notificación</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $afiliacion->fecha_ultima_notificacion->format('d/m/Y H:i') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>