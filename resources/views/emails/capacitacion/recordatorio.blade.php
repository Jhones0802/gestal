@extends('emails.layout')

@section('content')
<div class="card">
    <h2 style="color: #f59e0b; margin-top: 0;">Recordatorio de Capacitación</h2>

    <p>Hola <strong>{{ $empleado->nombres }} {{ $empleado->apellidos }}</strong>,</p>

    <p>Te recordamos que tienes una capacitación próxima:</p>

    <div style="background: #fef3c7; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #f59e0b;">
        <h3 style="margin-top: 0; color: #92400e;">{{ $capacitacion->titulo }}</h3>

        <table style="width: 100%; margin-top: 15px;">
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
                <td><a href="{{ $capacitacion->link_virtual }}" style="color: #f59e0b; font-weight: bold;">Acceder a la capacitación</a></td>
            </tr>
            @endif
        </table>
    </div>

    <div style="background: #e0e7ff; padding: 15px; border-radius: 6px; margin: 20px 0;">
        <p style="margin: 0; color: #3730a3;">
            <strong>Importante:</strong> Por favor, asegúrate de estar disponible en el horario indicado.
            @if($capacitacion->tipo === 'virtual')
            Verifica tu conexión a internet y que el link funcione correctamente antes de la sesión.
            @endif
        </p>
    </div>

    @if($capacitacion->materiales)
    <div style="margin: 20px 0;">
        <h4 style="color: #374151;">Recuerda tener listos los siguientes materiales:</h4>
        <p style="color: #6b7280;">{{ $capacitacion->materiales }}</p>
    </div>
    @endif

    <p style="margin-top: 30px;">
        ¡Te esperamos!
    </p>
</div>
@endsection
