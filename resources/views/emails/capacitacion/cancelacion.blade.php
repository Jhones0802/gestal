@extends('emails.layout')

@section('content')
<div class="card">
    <h2 style="color: #dc2626; margin-top: 0;">Cancelación de Capacitación</h2>

    <p>Hola <strong>{{ $empleado->nombres }} {{ $empleado->apellidos }}</strong>,</p>

    <p>Lamentamos informarte que la siguiente capacitación ha sido <strong style="color: #dc2626;">cancelada</strong>:</p>

    <div style="background: #fee2e2; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #dc2626;">
        <h3 style="margin-top: 0; color: #991b1b;">{{ $capacitacion->titulo }}</h3>

        <table style="width: 100%; margin-top: 15px;">
            <tr>
                <td style="padding: 8px 0;"><strong>Fecha programada:</strong></td>
                <td>{{ $capacitacion->fecha_formateada }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;"><strong>Horario:</strong></td>
                <td>{{ $capacitacion->horario_formateado }}</td>
            </tr>
        </table>
    </div>

    @if($capacitacion->observaciones)
    <div style="background: #f3f4f6; padding: 15px; border-radius: 6px; margin: 20px 0;">
        <h4 style="margin-top: 0; color: #374151;">Motivo:</h4>
        <p style="margin: 0; color: #6b7280;">{{ $capacitacion->observaciones }}</p>
    </div>
    @endif

    <p style="margin-top: 30px;">
        Te mantendremos informado sobre futuras capacitaciones relacionadas con este tema.
    </p>

    <p style="color: #6b7280; font-size: 14px; margin-top: 20px;">
        Disculpa las molestias ocasionadas. Si tienes alguna pregunta, no dudes en contactarnos.
    </p>
</div>
@endsection
