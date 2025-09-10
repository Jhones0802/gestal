<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'GESTAL RRHH' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .card {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .button {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 10px 0;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #666;
        }
        .status {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .status.pendiente { background: #fef3c7; color: #92400e; }
        .status.enviada { background: #dbeafe; color: #1e40af; }
        .status.completada { background: #dcfce7; color: #166534; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $empresa ?? 'GESTAL RRHH' }}</h1>
        <p>Recursos Humanos</p>
    </div>
    
    <div class="content">
        @yield('content')
    </div>
    
    <div class="footer">
        <p>© {{ date('Y') }} Localizamos TSA S.A.S - Todos los derechos reservados</p>
        <p>Pereira, Risaralda - Colombia</p>
        <p>Este es un mensaje automático, por favor no responder a este correo.</p>
    </div>
</body>
</html>