# 📡 APIs GESTAL RRHH

Sistema de APIs REST simuladas para integración con servicios externos del sistema de gestión de talento humano GESTAL.

## 🚀 APIs Implementadas

### 1. API de Entidades de Seguridad Social

Gestión de afiliaciones a EPS, ARL, Cajas de Compensación y Fondos de Pensiones.

**Base URL:** `/api/entidades`

**Endpoints:**

-   `POST /afiliaciones` - Enviar solicitud de afiliación
-   `GET /afiliaciones/{numero_radicado}` - Consultar estado
-   `POST /afiliaciones/{numero_radicado}/aprobar` - Aprobar afiliación
-   `POST /webhook/estado` - Webhook para notificaciones

### 2. API de Pagos y Nómina Electrónica

Dispersión de pagos de nómina a través de entidades bancarias.

**Base URL:** `/api/banco`

**Endpoints:**

-   `POST /nomina/dispersar` - Dispersar lote de nómina
-   `GET /nomina/lote/{lote_id}` - Consultar estado del lote
-   `GET /nomina/transaccion/{numero_transaccion}` - Consultar transacción
-   `POST /validar-cuenta` - Validar cuenta bancaria
-   `GET /saldo` - Consultar saldo disponible
-   `POST /nomina/revertir` - Revertir dispersión
-   `POST /webhook/transaccion` - Webhook para notificaciones

## 📖 Documentación

### Ver documentación web

Accede a: `http://localhost:8000/api/documentacion`

### Importar en Postman

1. Abre Postman
2. Click en "Import"
3. Selecciona el archivo `postman/GESTAL_APIs.postman_collection.json`
4. Las APIs estarán listas para probar

## 🧪 Probar las APIs

### Usando cURL

**Ejemplo 1: Enviar solicitud de afiliación**

```bash
curl -X POST http://localhost:8000/api/entidades/afiliaciones \
  -H "Content-Type: application/json" \
  -d '{
    "afiliacion_id": 1,
    "entidad_tipo": "eps",
    "empleado": {
      "nombres": "Juan",
      "apellidos": "Pérez",
      "cedula": "1234567890",
      "fecha_nacimiento": "1990-05-15"
    },
    "documentos": ["cedula.pdf", "carta_laboral.pdf"]
  }'
```

**Ejemplo 2: Dispersar nómina**

```bash
curl -X POST http://localhost:8000/api/banco/nomina/dispersar \
  -H "Content-Type: application/json" \
  -d '{
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
  }'
```

### Usando Postman

1. Importa la colección `GESTAL_APIs.postman_collection.json`
2. Selecciona cualquier endpoint
3. Click en "Send"
4. Observa la respuesta JSON simulada

## 🔧 Características de las APIs

### ✅ Características Implementadas

-   Respuestas JSON estructuradas
-   Validación de datos de entrada
-   Códigos HTTP estándar (200, 201, 400, 404, 422, 500)
-   Simulación de latencia de red
-   Generación automática de IDs y números de referencia
-   Logging de todas las peticiones
-   Webhooks para notificaciones
-   Simulación de errores aleatorios (5-10%)

### 🎯 Casos de Uso

**API de Entidades:**

-   Automatizar solicitudes de afiliación
-   Consultar estado en tiempo real
-   Recibir notificaciones de aprobación
-   Generar certificados automáticamente

**API de Nómina:**

-   Dispersar pagos masivos
-   Validar cuentas antes de pago
-   Consultar saldo disponible
-   Revertir transacciones erróneas
-   Rastrear estado de cada transacción

## 📊 Estructura de Respuestas

### Respuesta Exitosa

```json
{
    "success": true,
    "message": "Operación exitosa",
    "data": {
        // datos específicos
    }
}
```

### Respuesta con Error

```json
{
    "success": false,
    "message": "Descripción del error",
    "errors": {
        // detalles de validación
    }
}
```

## 🔐 Seguridad

Las APIs están configuradas para uso local sin autenticación. Para producción se recomienda:

-   Implementar Laravel Sanctum
-   Usar tokens Bearer
-   Configurar rate limiting
-   Habilitar HTTPS
-   Validar origen de requests

## 📝 Logs

Todas las peticiones se registran en `storage/logs/laravel.log`

Ver logs en tiempo real:

```bash
tail -f storage/logs/laravel.log
```

## 🎓 Propósito Académico

Estas APIs son **simulaciones locales** diseñadas para:

-   Demostrar integración con servicios externos
-   Practicar consumo de APIs REST
-   Entender patrones de comunicación
-   Simular flujos de trabajo reales

**Nota:** No se conectan a servicios reales. Todas las respuestas son generadas localmente.

## 🛠️ Tecnologías

-   Laravel 12
-   PHP 8.4
-   JSON REST API
-   Logging integrado
-   Validación robusta

## 📞 Soporte

Para más información, consulta la documentación web en `/api/documentacion`

---

**Desarrollado por:** GESTAL RRHH Team  
**Versión:** 1.0.0  
**Fecha:** Septiembre 2025
