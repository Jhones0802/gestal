<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentación API - GESTAL RRHH</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f5f7fa;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .api-section {
            background: white;
            margin: 2rem 0;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        
        h2 {
            color: #667eea;
            margin: 1.5rem 0 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #667eea;
        }
        
        h3 {
            color: #555;
            margin: 1rem 0 0.5rem;
        }
        
        .endpoint {
            background: #f8f9fa;
            padding: 1rem;
            margin: 1rem 0;
            border-left: 4px solid #667eea;
            border-radius: 4px;
        }
        
        .method {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-weight: bold;
            font-size: 0.875rem;
            margin-right: 0.5rem;
        }
        
        .method.post {
            background: #28a745;
            color: white;
        }
        
        .method.get {
            background: #007bff;
            color: white;
        }
        
        .method.put {
            background: #ffc107;
            color: #333;
        }
        
        .method.delete {
            background: #dc3545;
            color: white;
        }
        
        .url {
            font-family: 'Courier New', monospace;
            color: #333;
            font-size: 1rem;
        }
        
        pre {
            background: #2d3748;
            color: #68d391;
            padding: 1rem;
            border-radius: 4px;
            overflow-x: auto;
            margin: 1rem 0;
        }
        
        code {
            font-family: 'Courier New', monospace;
        }
        
        .params {
            margin: 1rem 0;
        }
        
        .params table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .params th {
            background: #667eea;
            color: white;
            padding: 0.75rem;
            text-align: left;
        }
        
        .params td {
            padding: 0.75rem;
            border-bottom: 1px solid #ddd;
        }
        
        .params tr:hover {
            background: #f8f9fa;
        }
        
        .badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: bold;
        }
        
        .badge.required {
            background: #ffc107;
            color: #333;
        }
        
        .badge.optional {
            background: #6c757d;
            color: white;
        }
        
        .response-example {
            margin: 1rem 0;
        }
        
        .toc {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .toc ul {
            list-style: none;
        }
        
        .toc li {
            margin: 0.5rem 0;
        }
        
        .toc a {
            color: #667eea;
            text-decoration: none;
        }
        
        .toc a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📡 API GESTAL RRHH</h1>
        <p>Documentación de APIs REST - Sistema de Gestión de Talento Humano</p>
        <p style="margin-top: 1rem; opacity: 0.9;">Versión 1.0.0</p>
    </div>

    <div class="container">
        <!-- Tabla de contenidos -->
        <div class="toc">
            <h2>📋 Índice</h2>
            <ul>
                <li><a href="#introduccion">1. Introducción</a></li>
                <li><a href="#base-url">2. URL Base</a></li>
                <li><a href="#autenticacion">3. Autenticación</a></li>
                <li><a href="#api-entidades">4. API Entidades de Seguridad Social</a></li>
                <li><a href="#api-banco">5. API Pagos y Nómina Electrónica</a></li>
                <li><a href="#codigos-error">6. Códigos de Error</a></li>
            </ul>
        </div>

        <!-- Introducción -->
        <div id="introduccion" class="api-section">
            <h2>1. Introducción</h2>
            <p>El sistema GESTAL RRHH expone dos APIs REST simuladas para integración con servicios externos:</p>
            <ul style="margin: 1rem 0 1rem 2rem;">
                <li><strong>API de Entidades de Seguridad Social:</strong> Gestión de afiliaciones a EPS, ARL, Cajas de Compensación y Fondos de Pensiones</li>
                <li><strong>API de Pagos y Nómina Electrónica:</strong> Dispersión de pagos de nómina a través de entidades bancarias</li>
            </ul>
            <p>Ambas APIs utilizan el formato JSON para solicitudes y respuestas.</p>
        </div>

        <!-- Base URL -->
        <div id="base-url" class="api-section">
            <h2>2. URL Base</h2>
            <pre>http://localhost:8000/api/</pre>
            <p><strong>Nota:</strong> En producción, reemplazar con el dominio real del servidor.</p>
        </div>

        <!-- Autenticación -->
        <div id="autenticacion" class="api-section">
            <h2>3. Autenticación</h2>
            <p>Actualmente las APIs están configuradas para uso local sin autenticación. En producción se recomienda usar Laravel Sanctum con tokens Bearer:</p>
            <pre>Authorization: Bearer {token}</pre>
        </div>

        <!-- API #1: Entidades -->
        <div id="api-entidades" class="api-section">
            <h2>4. API Entidades de Seguridad Social</h2>
            <p>Esta API simula la comunicación con entidades como EPS, ARL, Cajas de Compensación y Fondos de Pensiones para gestionar afiliaciones de empleados.</p>

            <!-- Endpoint 1.1 -->
            <div class="endpoint">
                <h3>
                    <span class="method post">POST</span>
                    <span class="url">/api/entidades/afiliaciones</span>
                </h3>
                <p><strong>Descripción:</strong> Envía una solicitud de afiliación a una entidad de seguridad social.</p>
                
                <div class="params">
                    <h4>Parámetros del body (JSON):</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>Parámetro</th>
                                <th>Tipo</th>
                                <th>Requerido</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>afiliacion_id</td>
                                <td>integer</td>
                                <td><span class="badge required">Requerido</span></td>
                                <td>ID de la afiliación en el sistema</td>
                            </tr>
                            <tr>
                                <td>entidad_tipo</td>
                                <td>string</td>
                                <td><span class="badge required">Requerido</span></td>
                                <td>Tipo: eps, arl, caja_compensacion, fondo_pensiones</td>
                            </tr>
                            <tr>
                                <td>empleado</td>
                                <td>object</td>
                                <td><span class="badge required">Requerido</span></td>
                                <td>Datos del empleado (nombres, apellidos, cedula, fecha_nacimiento)</td>
                            </tr>
                            <tr>
                                <td>documentos</td>
                                <td>array</td>
                                <td><span class="badge required">Requerido</span></td>
                                <td>Lista de documentos adjuntos</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="response-example">
                    <h4>Ejemplo de solicitud:</h4>
                    <pre>{
    "afiliacion_id": 1,
    "entidad_tipo": "eps",
    "empleado": {
        "nombres": "Juan Carlos",
        "apellidos": "Pérez Gómez",
        "cedula": "1234567890",
        "fecha_nacimiento": "1990-05-15"
    },
    "documentos": [
        "cedula.pdf",
        "carta_laboral.pdf"
    ]
}</pre>
                </div>

                <div class="response-example">
                    <h4>Ejemplo de respuesta exitosa (201):</h4>
                    <pre>{
    "success": true,
    "message": "Solicitud de afiliación recibida exitosamente",
    "data": {
        "numero_radicado": "EPS-20250910-7823",
        "estado": "recibida",
        "fecha_recepcion": "2025-09-10 14:30:00",
        "fecha_respuesta_estimada": "2025-09-20",
        "entidad": {
            "nombre": "Sura EPS",
            "codigo": "EPS2341",
            "contacto": {
                "telefono": "601-3456789",
                "email": "afiliaciones@eps.com.co"
            }
        }
    }
}</pre>
                </div>
            </div>

            <!-- Endpoint 1.2 -->
            <div class="endpoint">
                <h3>
                    <span class="method get">GET</span>
                    <span class="url">/api/entidades/afiliaciones/{numero_radicado}</span>
                </h3>
                <p><strong>Descripción:</strong> Consulta el estado actual de una solicitud de afiliación.</p>
                
                <div class="response-example">
                    <h4>Ejemplo de respuesta (200):</h4>
                    <pre>{
    "success": true,
    "data": {
        "numero_radicado": "EPS-20250910-7823",
        "estado": "en_revision",
        "estado_descripcion": "Documentos en revisión inicial",
        "progreso": 25,
        "siguiente_paso": "Verificación de documentos"
    }
}</pre>
                </div>
            </div>

            <!-- Endpoint 1.3 -->
            <div class="endpoint">
                <h3>
                    <span class="method post">POST</span>
                    <span class="url">/api/entidades/afiliaciones/{numero_radicado}/aprobar</span>
                </h3>
                <p><strong>Descripción:</strong> Aprueba una afiliación y genera el certificado.</p>
                
                <div class="response-example">
                    <h4>Ejemplo de respuesta (200):</h4>
                    <pre>{
    "success": true,
    "message": "Afiliación aprobada exitosamente",
    "data": {
        "numero_radicado": "EPS-20250910-7823",
        "numero_afiliado": "EP00019876543",
        "estado": "aprobada",
        "fecha_aprobacion": "2025-09-10 16:00:00",
        "fecha_afiliacion_efectiva": "2025-09-10",
        "certificado_url": "http://localhost:8000/afiliaciones/1/certificado"
    }
}</pre>
                </div>
            </div>
        </div>

        <!-- API #2: Banco -->
        <div id="api-banco" class="api-section">
            <h2>5. API Pagos y Nómina Electrónica</h2>
            <p>Esta API simula la dispersión de pagos de nómina a través de una entidad bancaria.</p>

            <!-- Endpoint 2.1 -->
            <div class="endpoint">
                <h3>
                    <span class="method post">POST</span>
                    <span class="url">/api/banco/nomina/dispersar</span>
                </h3>
                <p><strong>Descripción:</strong> Envía un lote de nómina para dispersión bancaria.</p>
                
                <div class="params">
                    <h4>Parámetros del body (JSON):</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>Parámetro</th>
                                <th>Tipo</th>
                                <th>Requerido</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>empresa_nit</td>
                                <td>string</td>
                                <td><span class="badge required">Requerido</span></td>
                                <td>NIT de la empresa</td>
                            </tr>
                            <tr>
                                <td>periodo</td>
                                <td>string</td>
                                <td><span class="badge required">Requerido</span></td>
                                <td>Periodo de nómina (YYYY-MM)</td>
                            </tr>
                            <tr>
                                <td>fecha_pago</td>
                                <td>date</td>
                                <td><span class="badge required">Requerido</span></td>
                                <td>Fecha de pago</td>
                            </tr>
                            <tr>
                                <td>cuenta_debito</td>
                                <td>string</td>
                                <td><span class="badge required">Requerido</span></td>
                                <td>Cuenta bancaria de la empresa</td>
                            </tr>
                            <tr>
                                <td>empleados</td>
                                <td>array</td>
                                <td><span class="badge required">Requerido</span></td>
                                <td>Lista de empleados con sus datos de pago</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="response-example">
                    <h4>Ejemplo de solicitud:</h4>
                    <pre>{
    "empresa_nit": "900123456-7",
    "periodo": "2025-09",
    "fecha_pago": "2025-09-30",
    "cuenta_debito": "1234567890",
    "empleados": [
        {
            "cedula": "1234567890",
            "nombres": "Juan",
            "apellidos": "Pérez",
            "cuenta_bancaria": "9876543210",
            "banco": "Bancolombia",
            "tipo_cuenta": "ahorros",
            "valor": 2500000
        }
    ]
}</pre>
                </div>

                <div class="response-example">
                    <h4>Ejemplo de respuesta exitosa (201):</h4>
                    <pre>{
    "success": true,
    "message": "Dispersión de nómina procesada",
    "data": {
        "lote_id": "LOTE-20250910-A7F3G9K2",
        "estado_lote": "procesado_exitosamente",
        "fecha_procesamiento": "2025-09-10 14:45:00",
        "resumen": {
            "total_empleados": 1,
            "exitosos": 1,
            "fallidos": 0,
            "monto_total": 2500000,
            "monto_procesado": 2500000
        }
    }
}</pre>
                </div>
            </div>

            <!-- Endpoint 2.2 -->
            <div class="endpoint">
                <h3>
                    <span class="method get">GET</span>
                    <span class="url">/api/banco/nomina/lote/{lote_id}</span>
                </h3>
                <p><strong>Descripción:</strong> Consulta el estado de un lote de nómina.</p>
            </div>

            <!-- Endpoint 2.3 -->
            <div class="endpoint">
                <h3>
                    <span class="method post">POST</span>
                    <span class="url">/api/banco/validar-cuenta</span>
                </h3>
                <p><strong>Descripción:</strong> Valida una cuenta bancaria antes de la dispersión.</p>
                
                <div class="response-example">
                    <h4>Ejemplo de solicitud:</h4>
                    <pre>{
    "numero_cuenta": "9876543210",
    "tipo_cuenta": "ahorros",
    "banco": "Bancolombia",
    "cedula_titular": "1234567890"
}</pre>
                </div>
            </div>

            <!-- Endpoint 2.4 -->
            <div class="endpoint">
                <h3>
                    <span class="method get">GET</span>
                    <span class="url">/api/banco/saldo</span>
                </h3>
                <p><strong>Descripción:</strong> Consulta el saldo disponible para dispersión.</p>
                
                <div class="params">
                    <h4>Parámetros query:</h4>
                    <ul style="margin: 1rem 0 1rem 2rem;">
                        <li><strong>cuenta:</strong> Número de cuenta</li>
                        <li><strong>empresa_nit:</strong> NIT de la empresa</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Códigos de error -->
        <div id="codigos-error" class="api-section">
            <h2>6. Códigos de Error Comunes</h2>
            <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
                <thead>
                    <tr style="background: #667eea; color: white;">
                        <th style="padding: 0.75rem; text-align: left;">Código HTTP</th>
                        <th style="padding: 0.75rem; text-align: left;">Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #ddd;">200</td>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #ddd;">Solicitud exitosa</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #ddd;">201</td>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #ddd;">Recurso creado exitosamente</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #ddd;">400</td>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #ddd;">Solicitud incorrecta</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #ddd;">404</td>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #ddd;">Recurso no encontrado</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #ddd;">422</td>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #ddd;">Error de validación</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #ddd;">500</td>
                        <td style="padding: 0.75rem; border-bottom: 1px solid #ddd;">Error interno del servidor</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div style="background: #2d3748; color: white; text-align: center; padding: 2rem; margin-top: 3rem;">
        <p>© 2025 GESTAL RRHH - Sistema de Gestión de Talento Humano</p>
        <p style="margin-top: 0.5rem; opacity: 0.8;">Desarrollado con Laravel 12 y PHP 8.4</p>
    </div>
</body>
</html>