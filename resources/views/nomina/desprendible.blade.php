<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desprendible de Pago - {{ $nomina->empleado->nombre_completo }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 15px;
        }
        
        .header h1 {
            font-size: 24px;
            color: #1e40af;
            margin-bottom: 5px;
        }
        
        .header h2 {
            font-size: 16px;
            color: #64748b;
            font-weight: normal;
        }
        
        .company-info {
            text-align: center;
            margin-bottom: 20px;
            font-size: 10px;
            color: #64748b;
        }
        
        .info-section {
            display: table;
            width: 100%;
            margin-bottom: 15px;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            overflow: hidden;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-label {
            display: table-cell;
            width: 35%;
            padding: 8px 12px;
            background-color: #f1f5f9;
            font-weight: bold;
            color: #475569;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .info-value {
            display: table-cell;
            width: 65%;
            padding: 8px 12px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .section-title {
            background-color: #2563eb;
            color: white;
            padding: 8px 12px;
            font-size: 13px;
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 10px;
            border-radius: 3px;
        }
        
        .section-title.green {
            background-color: #16a34a;
        }
        
        .section-title.red {
            background-color: #dc2626;
        }
        
        .section-title.purple {
            background-color: #9333ea;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        table th {
            background-color: #f8fafc;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #e2e8f0;
            font-size: 11px;
        }
        
        table td {
            padding: 6px 8px;
            border: 1px solid #e2e8f0;
        }
        
        table td.amount {
            text-align: right;
            font-family: 'Courier New', monospace;
        }
        
        .total-row {
            background-color: #f1f5f9;
            font-weight: bold;
        }
        
        .total-row td {
            border-top: 2px solid #2563eb;
        }
        
        .neto-pagar {
            background-color: #2563eb;
            color: white;
            padding: 15px;
            text-align: center;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .neto-pagar .label {
            font-size: 12px;
            margin-bottom: 5px;
        }
        
        .neto-pagar .amount {
            font-size: 28px;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e2e8f0;
            text-align: center;
            font-size: 9px;
            color: #64748b;
        }
        
        .signatures {
            margin-top: 40px;
            display: table;
            width: 100%;
        }
        
        .signature {
            display: table-cell;
            width: 50%;
            text-align: center;
            padding: 20px;
        }
        
        .signature-line {
            border-top: 1px solid #000;
            margin: 60px 20px 5px 20px;
        }
        
        .observaciones {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 10px;
            margin: 15px 0;
            font-size: 10px;
        }
        
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            color: rgba(0, 0, 0, 0.05);
            z-index: -1;
            font-weight: bold;
        }
    </style>
</head>
<body>
    @if($nomina->estado === 'aprobada')
        <div class="watermark">APROBADA</div>
    @elseif($nomina->estado === 'pagada')
        <div class="watermark">PAGADA</div>
    @endif

    <!-- Encabezado -->
    <div class="header">
        <h1>DESPRENDIBLE DE PAGO</h1>
        <h2>Comprobante de Nómina</h2>
    </div>

    <!-- Información de la Empresa -->
    <div class="company-info">
        <strong>LOCALIZAMOS TSA</strong><br>
        NIT: 900.123.456-7<br>
        Dirección: Calle 123 #45-67, Bogotá D.C.<br>
        Teléfono: (601) 234-5678 | Email: rrhh@localizamos.com.co
    </div>

    <!-- Información del Periodo -->
    <div class="section-title">INFORMACIÓN DEL PERIODO</div>
    <div class="info-section">
        <div class="info-row">
            <div class="info-label">Periodo de Pago:</div>
            <div class="info-value">{{ $nomina->periodo_formateado }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Fecha Inicio Periodo:</div>
            <div class="info-value">{{ $nomina->fecha_inicio_periodo->format('d/m/Y') }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Fecha Fin Periodo:</div>
            <div class="info-value">{{ $nomina->fecha_fin_periodo->format('d/m/Y') }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Fecha de Pago:</div>
            <div class="info-value" style="font-weight: bold; color: #16a34a;">{{ $nomina->fecha_pago->format('d/m/Y') }}</div>
        </div>
    </div>

    <!-- Información del Empleado -->
    <div class="section-title">INFORMACIÓN DEL EMPLEADO</div>
    <div class="info-section">
        <div class="info-row">
            <div class="info-label">Nombre Completo:</div>
            <div class="info-value" style="font-weight: bold;">{{ $nomina->empleado->nombre_completo }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Cédula:</div>
            <div class="info-value">{{ $nomina->empleado->cedula }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Cargo:</div>
            <div class="info-value">{{ $nomina->empleado->cargo }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Área:</div>
            <div class="info-value">{{ $nomina->empleado->area }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Tipo de Contrato:</div>
            <div class="info-value">{{ ucfirst($nomina->empleado->tipo_contrato) }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Salario Básico:</div>
            <div class="info-value" style="font-weight: bold; color: #2563eb;">${{ number_format($nomina->salario_basico, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Devengados -->
    <div class="section-title green">DEVENGADOS</div>
    <table>
        <thead>
            <tr>
                <th style="width: 70%;">Concepto</th>
                <th style="width: 30%; text-align: right;">Valor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Salario Básico</td>
                <td class="amount">${{ number_format($nomina->salario_basico, 0, ',', '.') }}</td>
            </tr>
            @if($nomina->auxilio_transporte > 0)
            <tr>
                <td>Auxilio de Transporte</td>
                <td class="amount">${{ number_format($nomina->auxilio_transporte, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($nomina->horas_extras > 0)
            <tr>
                <td>Horas Extras</td>
                <td class="amount">${{ number_format($nomina->horas_extras, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($nomina->recargos_nocturnos > 0)
            <tr>
                <td>Recargos Nocturnos</td>
                <td class="amount">${{ number_format($nomina->recargos_nocturnos, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($nomina->dominicales_festivos > 0)
            <tr>
                <td>Dominicales y Festivos</td>
                <td class="amount">${{ number_format($nomina->dominicales_festivos, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($nomina->comisiones > 0)
            <tr>
                <td>Comisiones</td>
                <td class="amount">${{ number_format($nomina->comisiones, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($nomina->bonificaciones > 0)
            <tr>
                <td>Bonificaciones</td>
                <td class="amount">${{ number_format($nomina->bonificaciones, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($nomina->otros_devengados > 0)
            <tr>
                <td>Otros Devengados</td>
                <td class="amount">${{ number_format($nomina->otros_devengados, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr class="total-row">
                <td><strong>TOTAL DEVENGADOS</strong></td>
                <td class="amount"><strong>${{ number_format($nomina->total_devengados, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- Deducciones -->
    <div class="section-title red">DEDUCCIONES</div>
    <table>
        <thead>
            <tr>
                <th style="width: 70%;">Concepto</th>
                <th style="width: 30%; text-align: right;">Valor</th>
            </tr>
        </thead>
        <tbody>
            @if($nomina->salud_empleado > 0)
            <tr>
                <td>Salud (4%)</td>
                <td class="amount">${{ number_format($nomina->salud_empleado, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($nomina->pension_empleado > 0)
            <tr>
                <td>Pensión (4%)</td>
                <td class="amount">${{ number_format($nomina->pension_empleado, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($nomina->solidaridad_pensional > 0)
            <tr>
                <td>Solidaridad Pensional (1%)</td>
                <td class="amount">${{ number_format($nomina->solidaridad_pensional, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($nomina->retencion_fuente > 0)
            <tr>
                <td>Retención en la Fuente</td>
                <td class="amount">${{ number_format($nomina->retencion_fuente, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($nomina->prestamos > 0)
            <tr>
                <td>Préstamos</td>
                <td class="amount">${{ number_format($nomina->prestamos, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($nomina->embargos > 0)
            <tr>
                <td>Embargos Judiciales</td>
                <td class="amount">${{ number_format($nomina->embargos, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($nomina->otros_descuentos > 0)
            <tr>
                <td>Otros Descuentos</td>
                <td class="amount">${{ number_format($nomina->otros_descuentos, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr class="total-row">
                <td><strong>TOTAL DEDUCCIONES</strong></td>
                <td class="amount"><strong>${{ number_format($nomina->total_deducciones, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- Neto a Pagar -->
    <div class="neto-pagar">
        <div class="label">NETO A PAGAR</div>
        <div class="amount">${{ number_format($nomina->neto_pagar, 0, ',', '.') }}</div>
    </div>

    <!-- Aportes y Provisiones (Informativo) -->
    <div class="section-title purple">APORTES PATRONALES Y PROVISIONES (Informativo - No afectan su pago)</div>
    <table style="font-size: 9px;">
        <tbody>
            <tr>
                <td style="width: 35%;"><strong>Aportes Patronales:</strong></td>
                <td class="amount" style="width: 15%;">${{ number_format($nomina->total_aportes_patronales, 0, ',', '.') }}</td>
                <td style="width: 35%;"><strong>Provisiones:</strong></td>
                <td class="amount" style="width: 15%;">${{ number_format($nomina->total_provisiones, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>• Salud Patronal (8.5%)</td>
                <td class="amount">${{ number_format($nomina->salud_patronal, 0, ',', '.') }}</td>
                <td>• Cesantías (8.33%)</td>
                <td class="amount">${{ number_format($nomina->cesantias, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>• Pensión Patronal (12%)</td>
                <td class="amount">${{ number_format($nomina->pension_patronal, 0, ',', '.') }}</td>
                <td>• Int. Cesantías (1%)</td>
                <td class="amount">${{ number_format($nomina->intereses_cesantias, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>• ARL</td>
                <td class="amount">${{ number_format($nomina->arl, 0, ',', '.') }}</td>
                <td>• Prima (8.33%)</td>
                <td class="amount">${{ number_format($nomina->prima_servicios, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>• Caja Compensación (4%)</td>
                <td class="amount">${{ number_format($nomina->caja_compensacion, 0, ',', '.') }}</td>
                <td>• Vacaciones (4.17%)</td>
                <td class="amount">${{ number_format($nomina->vacaciones, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>• ICBF (3%)</td>
                <td class="amount">${{ number_format($nomina->icbf, 0, ',', '.') }}</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>• SENA (2%)</td>
                <td class="amount">${{ number_format($nomina->sena, 0, ',', '.') }}</td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <!-- Observaciones -->
    @if($nomina->observaciones)
    <div class="observaciones">
        <strong>Observaciones:</strong><br>
        {{ $nomina->observaciones }}
    </div>
    @endif

    <!-- Firmas -->
    <div class="signatures">
        <div class="signature">
            <div class="signature-line"></div>
            <strong>{{ $nomina->empleado->nombre_completo }}</strong><br>
            C.C. {{ $nomina->empleado->cedula }}<br>
            <small>Firma del Empleado</small>
        </div>
        <div class="signature">
            <div class="signature-line"></div>
            <strong>RECURSOS HUMANOS</strong><br>
            LOCALIZAMOS TSA<br>
            <small>Firma Autorizada</small>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Este documento es un comprobante de pago de nómina.</strong></p>
        <p>Generado el {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>Documento generado electrónicamente por el Sistema GESTAL RRHH</p>
        @if($nomina->estado === 'aprobada')
            <p style="color: #f59e0b;"><strong>Estado: APROBADA - Pendiente de pago</strong></p>
        @elseif($nomina->estado === 'pagada')
            <p style="color: #16a34a;"><strong>Estado: PAGADA</strong></p>
        @endif
    </div>
</body>
</html>