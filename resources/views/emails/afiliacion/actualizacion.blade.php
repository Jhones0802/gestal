@extends('emails.layout', ['title' => 'Actualización de afiliación'])

@section('content')
<h2>Actualización de tu afiliación</h2>

<p>Hola {{ $empleado->nombres }},</p>

<p>Te informamos que hay una actualización en el estado de tu afiliación:</p>

<div class="card">
    <h3>{{ $afiliacion->entidad_tipo_label }} - {{ $afiliacion->entidad_nombre }}</h3>
    
    <div style="margin: 20px 0;">
        <strong>Estado actual:</strong> 
        <span class="status {{ $afiliacion->estado }}">{{ $afiliacion->estado_label }}</span>
    </div>

    @if($afiliacion->numero_radicado)
        <p><strong>Número de radicado:</strong> {{ $afiliacion->numero_radicado }}</p>
    @endif

    @if($afiliacion->fecha_respuesta_estimada)
        <p><strong>Respuesta estimada:</strong> {{ $afiliacion->fecha_respuesta_estimada->format('d/m/Y') }}</p>
    @endif

    @if($afiliacion->observaciones)
        <div style="background: #f0f9ff; padding: 15px; border-radius: 6px; margin: 15px 0;">
            <strong>Observaciones:</strong><br>
            {{ $afiliacion->observaciones }}
        </div>
    @endif
</div>

@if($afiliacion->estado === 'rechazada' && $afiliacion->motivo_rechazo)
    <div class="card" style="border-left: 4px solid #ef4444;">
        <h4 style="color: #dc2626;">Motivo del rechazo:</h4>
        <p>{{ $afiliacion->motivo_rechazo }}</p>
        <p><em>Nuestro equipo de RRHH se pondrá en contacto contigo para resolver esta situación.</em></p>
    </div>
@endif

<p>Cualquier duda, no dudes en contactarnos.</p>

<p><strong>Equipo de Recursos Humanos</strong><br>
Localizamos TSA S.A.S</p>
@endsection