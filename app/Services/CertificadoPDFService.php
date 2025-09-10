<?php

namespace App\Services;

use App\Models\Afiliacion;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class CertificadoPDFService
{
    /**
     * Generar certificado de afiliación
     */
    public function generarCertificado(Afiliacion $afiliacion): string
    {
        $datos = $this->prepararDatos($afiliacion);
        
        $pdf = Pdf::loadView('pdfs.certificado_afiliacion', $datos);
        $pdf->setPaper('A4', 'portrait');
        
        // Generar nombre único para el archivo
        $nombreArchivo = $this->generarNombreArchivo($afiliacion);
        
        // Guardar en storage
        $rutaArchivo = "certificados/{$nombreArchivo}";
        Storage::disk('public')->put($rutaArchivo, $pdf->output());
        
        // Actualizar la afiliación con la ruta del certificado
        $afiliacion->update(['certificado_afiliacion' => $rutaArchivo]);
        
        return $rutaArchivo;
    }

    /**
     * Preparar datos para el PDF
     */
    private function prepararDatos(Afiliacion $afiliacion): array
    {
        return [
            'afiliacion' => $afiliacion,
            'empleado' => $afiliacion->empleado,
            'fecha_generacion' => now(),
            'numero_certificado' => $this->generarNumeroCertificado($afiliacion),
            'qr_code' => $this->generarCodigoQR($afiliacion),
            'entidad_info' => $this->getInfoEntidad($afiliacion->entidad_tipo),
            'firma_digital' => $this->getFirmaDigital()
        ];
    }

    /**
     * Generar nombre único para el archivo
     */
    private function generarNombreArchivo(Afiliacion $afiliacion): string
    {
        $empleado = $afiliacion->empleado;
        $fecha = now()->format('Y-m-d');
        $tipo = $afiliacion->entidad_tipo;
        
        return "certificado_{$tipo}_{$empleado->numero_documento}_{$fecha}.pdf";
    }

    /**
     * Generar número de certificado único
     */
    private function generarNumeroCertificado(Afiliacion $afiliacion): string
    {
        $prefijo = strtoupper(substr($afiliacion->entidad_tipo, 0, 3));
        $fecha = now()->format('Ymd');
        $secuencial = str_pad($afiliacion->id, 4, '0', STR_PAD_LEFT);
        
        return "{$prefijo}-{$fecha}-{$secuencial}";
    }

    /**
     * Generar código QR simulado
     */
    private function generarCodigoQR(Afiliacion $afiliacion): string
    {
        // En una implementación real, aquí generarías un QR real
        // Por ahora retornamos un placeholder
        return "data:image/svg+xml;base64," . base64_encode('
            <svg width="100" height="100" xmlns="http://www.w3.org/2000/svg">
                <rect width="100" height="100" fill="white"/>
                <rect x="10" y="10" width="20" height="20" fill="black"/>
                <rect x="40" y="10" width="20" height="20" fill="black"/>
                <rect x="70" y="10" width="20" height="20" fill="black"/>
                <rect x="10" y="40" width="20" height="20" fill="black"/>
                <rect x="70" y="40" width="20" height="20" fill="black"/>
                <rect x="10" y="70" width="20" height="20" fill="black"/>
                <rect x="40" y="70" width="20" height="20" fill="black"/>
                <rect x="70" y="70" width="20" height="20" fill="black"/>
                <text x="50" y="55" text-anchor="middle" font-size="8" fill="black">QR</text>
            </svg>
        ');
    }

    /**
     * Obtener información de la entidad
     */
    private function getInfoEntidad(string $tipo): array
    {
        $entidades = [
            'eps' => [
                'nombre_completo' => 'Entidad Promotora de Salud',
                'codigo_habilitacion' => 'EPS-' . rand(10000, 99999),
                'nit' => '900.' . rand(100, 999) . '.' . rand(100, 999) . '-' . rand(1, 9),
                'direccion' => 'Calle 123 #45-67, Pereira, Risaralda',
                'telefono' => '(6) 123-4567',
                'email' => 'afiliaciones@eps-simulada.co'
            ],
            'arl' => [
                'nombre_completo' => 'Administradora de Riesgos Laborales',
                'codigo_habilitacion' => 'ARL-' . rand(10000, 99999),
                'nit' => '900.' . rand(100, 999) . '.' . rand(100, 999) . '-' . rand(1, 9),
                'direccion' => 'Carrera 456 #78-90, Pereira, Risaralda',
                'telefono' => '(6) 234-5678',
                'email' => 'afiliaciones@arl-simulada.co'
            ],
            'caja_compensacion' => [
                'nombre_completo' => 'Caja de Compensación Familiar',
                'codigo_habilitacion' => 'CCF-' . rand(10000, 99999),
                'nit' => '900.' . rand(100, 999) . '.' . rand(100, 999) . '-' . rand(1, 9),
                'direccion' => 'Avenida 789 #12-34, Pereira, Risaralda',
                'telefono' => '(6) 345-6789',
                'email' => 'afiliaciones@ccf-simulada.co'
            ],
            'fondo_pensiones' => [
                'nombre_completo' => 'Fondo de Pensiones y Cesantías',
                'codigo_habilitacion' => 'FPC-' . rand(10000, 99999),
                'nit' => '900.' . rand(100, 999) . '.' . rand(100, 999) . '-' . rand(1, 9),
                'direccion' => 'Diagonal 321 #56-78, Pereira, Risaralda',
                'telefono' => '(6) 456-7890',
                'email' => 'afiliaciones@fpc-simulada.co'
            ]
        ];

        return $entidades[$tipo] ?? $entidades['eps'];
    }

    /**
     * Obtener firma digital simulada
     */
    private function getFirmaDigital(): string
    {
        return "data:image/svg+xml;base64," . base64_encode('
            <svg width="200" height="60" xmlns="http://www.w3.org/2000/svg">
                <text x="10" y="20" font-family="cursive" font-size="16" fill="navy">Dr. Juan Carlos Pérez</text>
                <text x="10" y="35" font-size="10" fill="gray">Director de Afiliaciones</text>
                <text x="10" y="50" font-size="8" fill="gray">Firma Digital Autorizada</text>
                <path d="M10 25 Q50 15 90 25 Q130 35 170 25" stroke="navy" stroke-width="2" fill="none"/>
            </svg>
        ');
    }

    /**
     * Generar certificado cuando se completa una afiliación
     */
    public function generarCertificadoAutomatico(Afiliacion $afiliacion): bool
    {
        try {
            if ($afiliacion->estado === 'completada' && !$afiliacion->certificado_afiliacion) {
                $this->generarCertificado($afiliacion);
                return true;
            }
            return false;
        } catch (\Exception $e) {
            \Log::error('Error generando certificado: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtener la ruta completa del certificado
     */
    public function getRutaCertificado(Afiliacion $afiliacion): ?string
    {
        if ($afiliacion->certificado_afiliacion) {
            return Storage::disk('public')->url($afiliacion->certificado_afiliacion);
        }
        return null;
    }
}