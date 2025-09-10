<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado de Afiliación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }
        
        .certificado {
            background: white;
            padding: 40px;
            border: 3px solid #0066cc;
            border-radius: 10px;
            position: relative;
            min-height: 700px;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #0066cc;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #0066cc, #004499);
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }
        
        .empresa {
            font-size: 24px;
            font-weight: bold;
            color: #0066cc;
            margin: 10px 0;
        }
        
        .titulo {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin: 20px 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .numero-certificado {
            background: #f0f8ff;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
            color: #0066cc;
            margin: 20px 0;
        }
        
        .contenido {
            line-height: 1.8;
            text-align: justify;
            margin: 30px 0;
            font-size: 14px;
        }
        
        .datos-empleado {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #0066cc;
        }
        
        .datos-entidad {
            background: #e8f4fd;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #0066cc;
        }
        
        .fila {
            display: table;
            width: 100%;
            margin: 8px 0;
        }
        
        .etiqueta {
            display: table-cell;
            font-weight: bold;
            width: 40%;
            color: #333;
        }
        
        .valor {
            display: table-cell;
            color: #666;
        }
        
        .footer {
            position: absolute;
            bottom: 40px;
            left: 40px;
            right: 40px;
        }
        
        .firmas {
            display: table;
            width: 100%;
            margin-top: 60px;
        }
        
        .firma {
            display: table-cell;
            text-align: center;
            width: 50%;
            vertical-align: top;
        }
        
        .linea-firma {
            border-top: 1px solid #333;
            width: 200px;
            margin: 0 auto 10px;
        }
        
        .qr-container {
            position: absolute;
            top: 40px;
            right: 40px;
            text-align: center;
        }
        
        .qr-code {
            width: 80px;
            height: 80px;
            border: 1px solid #ddd;
        }
        
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            opacity: 0.1;
            font-size: 72px;
            font-weight: bold;
            color: #0066cc;
            z-index: -1;
        }
        
        .sello {
            position: absolute;
            bottom: 200px;
            right: 50px;
            width: 120px;
            height: 120px;
            border: 3px solid #cc0000;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(204, 0, 0, 0.1);
            transform: rotate(15deg);
        }
        
        .sello-texto {
            text-align: center;
            color: #cc0000;
            font-size: 12px;
            font-weight: bold;
            line-height: 1.2;
        }
        
        .validez {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="certificado">
        <!-- Marca de agua -->
        <div class="watermark">CERTIFICADO</div>
        
        <!-- Código QR -->
        <div class="qr-container">
            <img src="{{ $qr_code }}" alt="Código QR" class="qr-code">
            <div style="font-size: 8px; margin-top: 5px;">Verificación</div>
        </div>
        
        <!-- Header -->
        <div class="header">
            <div class="logo">{{ strtoupper(substr($afiliacion->entidad_nombre, 0, 1)) }}</div>
            <div class="empresa">{{ $afiliacion->entidad_nombre }}</div>
            <div style="font-size: 14px; color: #666;">{{ $entidad_info['nombre_completo'] }}</div>
            <div style="font-size: 12px; color: #999;">NIT: {{ $entidad_info['nit'] }}</div>
        </div>
        
        <!-- Título -->
        <div class="titulo" style="text-align: center;">
            Certificado de Afiliación
        </div>
        
        <!-- Número de certificado -->
        <div class="numero-certificado" style="text-align: center;">
            Certificado No. {{ $numero_certificado }}
        </div>
        
        <!-- Contenido principal -->
        <div class="contenido">
            <p><strong>LA ENTIDAD CERTIFICA QUE:</strong></p>
            <p>El(la) señor(a) <strong>{{ strtoupper($empleado->nombres . ' ' . $empleado->apellidos) }}</strong>, 
            identificado(a) con cédula de ciudadanía número <strong>{{ $empleado->cedula }}</strong>, 
            se encuentra debidamente afiliado(a) a esta entidad desde el 
            <strong>{{ $afiliacion->fecha_afiliacion_efectiva->format('d/m/Y') }}</strong>.</p>
        </div>
        
        <!-- Datos del empleado -->
        <div class="datos-empleado">
            <h4 style="margin-top: 0; color: #0066cc;">DATOS DEL AFILIADO</h4>
            
            <div class="fila">
                <div class="etiqueta">Nombres:</div>
                <div class="valor">{{ $empleado->nombres }} {{ $empleado->apellidos }}</div>
            </div>
            
            <div class="fila">
                <div class="etiqueta">Documento:</div>
                <div class="valor">Cédula de Ciudadanía {{ $empleado->cedula }}</div>
            </div>
            
            <div class="fila">
                <div class="etiqueta">Número de Afiliado:</div>
                <div class="valor">{{ $afiliacion->numero_afiliado }}</div>
            </div>
            
            <div class="fila">
                <div class="etiqueta">Fecha de Afiliación:</div>
                <div class="valor">{{ $afiliacion->fecha_afiliacion_efectiva->format('d/m/Y') }}</div>
            </div>
            
            <div class="fila">
                <div class="etiqueta">Estado:</div>
                <div class="valor" style="color: #28a745; font-weight: bold;">ACTIVO</div>
            </div>
        </div>
        
        <!-- Datos de la entidad -->
        <div class="datos-entidad">
            <h4 style="margin-top: 0; color: #0066cc;">DATOS DE LA ENTIDAD</h4>
            
            <div class="fila">
                <div class="etiqueta">Razón Social:</div>
                <div class="valor">{{ $afiliacion->entidad_nombre }}</div>
            </div>
            
            <div class="fila">
                <div class="etiqueta">NIT:</div>
                <div class="valor">{{ $entidad_info['nit'] }}</div>
            </div>
            
            <div class="fila">
                <div class="etiqueta">Código de Habilitación:</div>
                <div class="valor">{{ $entidad_info['codigo_habilitacion'] }}</div>
            </div>
            
            <div class="fila">
                <div class="etiqueta">Dirección:</div>
                <div class="valor">{{ $entidad_info['direccion'] }}</div>
            </div>
            
            <div class="fila">
                <div class="etiqueta">Teléfono:</div>
                <div class="valor">{{ $entidad_info['telefono'] }}</div>
            </div>
        </div>
        
        <!-- Validez -->
        <div class="validez">
            <strong>VALIDEZ:</strong> Este certificado tiene validez indefinida mientras se mantenga activa la afiliación.<br>
            <strong>Fecha de expedición:</strong> {{ $fecha_generacion->format('d/m/Y') }}
        </div>
        
        <!-- Sello oficial -->
        <div class="sello">
            <div class="sello-texto">
                SELLO<br>
                OFICIAL<br>
                {{ date('Y') }}
            </div>
        </div>
        
        <!-- Footer con firmas -->
        <div class="footer">
            <div class="firmas">
                <div class="firma">
                    <img src="{{ $firma_digital }}" alt="Firma Digital" style="height: 40px;">
                    <div class="linea-firma"></div>
                    <strong>Dr. Juan Carlos Pérez</strong><br>
                    <small>Director de Afiliaciones</small><br>
                    <small>{{ $afiliacion->entidad_nombre }}</small>
                </div>
                
                <div class="firma">
                    <div style="height: 40px; margin-bottom: 10px;">
                        <small style="color: #666;">Documento generado digitalmente</small>
                    </div>
                    <div class="linea-firma"></div>
                    <strong>Sistema GESTAL</strong><br>
                    <small>GESTAL RRHH</small><br>
                    <small>{{ $fecha_generacion->format('d/m/Y H:i') }}</small>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 30px; font-size: 10px; color: #666;">
                Este documento ha sido generado electrónicamente y tiene plena validez legal.<br>
                Para verificar su autenticidad escanee el código QR o visite: www.verificacion-certificados.co
            </div>
        </div>
    </div>
</body>
</html>