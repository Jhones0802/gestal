@extends('emails.layout')

@section('content')
<div class="card">
    <h2 style="color: #667eea; margin-top: 0;">Invitación a Capacitación</h2>

    <p>Hola <strong>{{ $empleado->nombres }} {{ $empleado->apellidos }}</strong>,</p>

    <p>Te hemos inscrito en la siguiente capacitación:</p>

    <div style="background: #f3f4f6; padding: 20px; border-radius: 8px; margin: 20px 0;">
        <h3 style="margin-top: 0; color: #374151;">{{ $capacitacion->titulo }}</h3>

        @if($capacitacion->descripcion)
        <p style="color: #6b7280;">{{ $capacitacion->descripcion }}</p>
        @endif

        <table style="width: 100%; margin-top: 15px;">
            <tr>
                <td style="padding: 8px 0;"><strong>Tipo:</strong></td>
                <td>
                    @if($capacitacion->tipo === 'presencial')
                        Presencial
                    @elseif($capacitacion->tipo === 'virtual')
                        Virtual
                    @else
                        Híbrida
                    @endif
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
            @if($capacitacion->instructor)
            <tr>
                <td style="padding: 8px 0;"><strong>Instructor:</strong></td>
                <td>{{ $capacitacion->instructor }}</td>
            </tr>
            @endif
            @if($capacitacion->tipo === 'presencial' && $capacitacion->lugar)
            <tr>
                <td style="padding: 8px 0;"><strong>Lugar:</strong></td>
                <td>{{ $capacitacion->lugar }}</td>
            </tr>
            @endif
            @if($capacitacion->tipo === 'virtual' && $capacitacion->link_virtual)
            <tr>
                <td style="padding: 8px 0;"><strong>Link:</strong></td>
                <td><a href="{{ $capacitacion->link_virtual }}" style="color: #667eea;">Acceder a la capacitación</a></td>
            </tr>
            @endif
            @if($capacitacion->duracion_horas)
            <tr>
                <td style="padding: 8px 0;"><strong>Duración:</strong></td>
                <td>{{ $capacitacion->duracion_formateada }}</td>
            </tr>
            @endif
        </table>
    </div>

    @if($capacitacion->objetivos)
    <div style="margin: 20px 0;">
        <h4 style="color: #374151;">Objetivos:</h4>
        <p style="color: #6b7280;">{{ $capacitacion->objetivos }}</p>
    </div>
    @endif

    @if($capacitacion->requisitos)
    <div style="margin: 20px 0;">
        <h4 style="color: #374151;">Requisitos:</h4>
        <p style="color: #6b7280;">{{ $capacitacion->requisitos }}</p>
    </div>
    @endif

    @if($capacitacion->materiales)
    <div style="margin: 20px 0;">
        <h4 style="color: #374151;">Materiales necesarios:</h4>
        <p style="color: #6b7280;">{{ $capacitacion->materiales }}</p>
    </div>
    @endif

    <p style="margin-top: 30px;">
        Por favor, confirma tu asistencia lo antes posible.
    </p>

    <p style="color: #6b7280; font-size: 14px; margin-top: 20px;">
        Si tienes alguna pregunta o necesitas más información, no dudes en contactarnos.
    </p>
</div>
@endsection
