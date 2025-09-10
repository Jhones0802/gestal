@extends('emails.layout', ['title' => 'Inicio del proceso de afiliaciones'])

@section('content')
<h2>¡Bienvenid@ {{ $empleado->nombres }}!</h2>

<p>Nos complace informarte que hemos iniciado el proceso de afiliación a las entidades de seguridad social para tu vinculación laboral con nuestra empresa.</p>

<div class="card">
    <h3>Afiliaciones iniciadas:</h3>
    @if($afiliaciones)
        @foreach($afiliaciones as $afiliacion)
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #eee;">
                <div>
                    <strong>{{ $afiliacion->entidad_tipo_label }}</strong><br>
                    <small>{{ $afiliacion->entidad_nombre }}</small>
                </div>
                <span class="status {{ $afiliacion->estado }}">{{ $afiliacion->estado_label }}</span>
            </div>
        @endforeach
    @endif
</div>

<div class="card">
    <h3>¿Qué sigue ahora?</h3>
    <ul>
        <li>📋 Revisaremos que tengamos todos los documentos necesarios</li>
        <li>📤 Enviaremos las solicitudes a cada entidad</li>
        <li>⏰ Te mantendremos informado sobre el progreso</li>
        <li>✅ Recibirás los certificados una vez completadas</li>
    </ul>
</div>

<div class="card">
    <h3>Información importante:</h3>
    <p><strong>Tiempos estimados:</strong> Entre 5 a 15 días hábiles por entidad</p>
    <p><strong>Documentos requeridos:</strong> Ya tienes todos los documentos en tu expediente</p>
    <p><strong>Dudas:</strong> Puedes contactarnos en gestal37@gmail.com</p>
</div>

<p>Gracias por tu paciencia durante este proceso. ¡Te contactaremos pronto!</p>

<p><strong>Equipo de Recursos Humanos</strong><br>
GESTAL RRHH</p>
@endsection