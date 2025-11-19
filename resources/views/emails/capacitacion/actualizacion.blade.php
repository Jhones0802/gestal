@extends('emails.layout')

@section('content')
<div class="card">
    <h2 style="color: #3b82f6; margin-top: 0;">Actualización de Capacitación</h2>

    <p>Hola <strong>{{ $empleado->nombres }} {{ $empleado->apellidos }}</strong>,</p>

    <p>Te informamos que se ha realizado una actualización en la siguiente capacitación:</p>

    <div style="background: #dbeafe; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #3b82f6;">
        <h3 style="margin-top: 0; color: #1e40af;">{{ $capacitacion->titulo }}</h3>

        <table style="width: 100%; margin-top: 15px;">
            <tr>
                <td style="padding: 8px 0;"><strong>Estado:</strong></td>
                <td>
                    <span style="background: {{ $capacitacion->estado_badge }}; padding: 4px 12px; border-radius: 12px; font-size: 12px;">
                        {{ $capacitacion->estado_texto }}
                    </span>
                </td>
            </tr>
            <tr>
                <td style="padding: 8px 0;"><strong>Fecha:</strong></td>
                <td>{{ $capacitacion->fecha_formateada }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;"><strong>Horario:</strong></td>
                <td>{{ $capacitacion->horario_formateado }}</td>
            </tr>
            @if($capacitacion->tipo === 'presencial' && $capacitacion->lugar)
            <tr>
                <td style="padding: 8px 0;"><strong>Lugar:</strong></td>
                <td>{{ $capacitacion->lugar }}</td>
            </tr>
            @endif
            @if($capacitacion->tipo === 'virtual' && $capacitacion->link_virtual)
            <tr>
                <td style="padding: 8px 0;"><strong>Link:</strong></td>
                <td><a href="{{ $capacitacion->link_virtual }}" style="color: #3b82f6;">Acceder a la capacitación</a></td>
            </tr>
            @endif
        </table>
    </div>

    @if($capacitacion->observaciones)
    <div style="background: #f3f4f6; padding: 15px; border-radius: 6px; margin: 20px 0;">
        <h4 style="margin-top: 0; color: #374151;">Observaciones:</h4>
        <p style="margin: 0; color: #6b7280;">{{ $capacitacion->observaciones }}</p>
    </div>
    @endif

    <p style="margin-top: 30px;">
        Por favor, toma nota de esta actualización.
    </p>

    <p style="color: #6b7280; font-size: 14px; margin-top: 20px;">
        Si tienes alguna pregunta sobre estos cambios, no dudes en contactarnos.
    </p>
</div>
@endsection
