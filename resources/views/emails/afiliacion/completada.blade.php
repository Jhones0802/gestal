@extends('emails.layout', ['title' => 'Afiliación completada'])

@section('content')
<h2>¡Felicitaciones {{ $empleado->nombres }}!</h2>

<p>Tu afiliación ha sido completada exitosamente:</p>

<div class="card">
    <h3>{{ $afiliacion->entidad_tipo_label }} - {{ $afiliacion->entidad_nombre }}</h3>
    
    <div style="margin: 20px 0;">
        <strong>Estado:</strong> 
        <span class="status completada">COMPLETADA</span>
    </div>

    <p><strong>Número de afiliado:</strong> {{ $afiliacion->numero_afiliado }}</p>
    <p><strong>Fecha de afiliación efectiva:</strong> {{ $afiliacion->fecha_afiliacion_efectiva->format('d/m/Y') }}</p>
</div>

<div class="card">
    <h3>📄 Certificado de Afiliación</h3>
    <p>Adjunto a este correo encontrarás tu <strong>certificado oficial de afiliación</strong> en formato PDF.</p>
    
    <div style="background: #e8f5e8; padding: 15px; border-radius: 6px; margin: 15px 0;">
        <strong>Importante:</strong>
        <ul style="margin: 10px 0; padding-left: 20px;">
            <li>Guarda este certificado en lugar seguro</li>
            <li>Úsalo como comprobante de tu afiliación</li>
            <li>Este documento tiene validez legal</li>
        </ul>
    </div>
</div>

<div class="card">
    <h3>¿Qué hacer ahora?</h3>
    <ul>
        <li>✅ Tu afiliación está activa desde {{ $afiliacion->fecha_afiliacion_efectiva->format('d/m/Y') }}</li>
        <li>📋 Puedes usar los servicios de {{ $afiliacion->entidad_tipo_label }}</li>
        <li>📞 Para dudas, contacta directamente la entidad</li>
        <li>💼 Presenta tu certificado cuando sea requerido</li>
    </ul>
</div>

<p><strong>¡Bienvenido al sistema de seguridad social colombiano!</strong></p>

<p><strong>Equipo de Recursos Humanos</strong><br>
Localizamos TSA S.A.S</p>
@endsection