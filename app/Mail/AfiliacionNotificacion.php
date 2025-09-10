<?php

namespace App\Mail;

use App\Models\Afiliacion;
use App\Models\Empleado;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AfiliacionNotificacion extends Mailable
{
    use Queueable, SerializesModels;

    public $empleado;
    public $tipo;
    public $afiliaciones;
    public $afiliacion;

    /**
     * Create a new message instance.
     */
    public function __construct(Empleado $empleado, string $tipo, $afiliaciones = null, Afiliacion $afiliacion = null)
    {
        $this->empleado = $empleado;
        $this->tipo = $tipo;
        $this->afiliaciones = $afiliaciones;
        $this->afiliacion = $afiliacion;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = match($this->tipo) {
            'inicio' => 'Inicio del proceso de afiliaciones',
            'actualizacion' => 'Actualización de tu afiliación',
            'completada' => 'Afiliación completada exitosamente',
            default => 'Notificación de afiliación'
        };

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $view = match($this->tipo) {
            'inicio' => 'emails.afiliacion.inicio',
            'actualizacion' => 'emails.afiliacion.actualizacion',
            'completada' => 'emails.afiliacion.completada',
            default => 'emails.afiliacion.actualizacion'
        };

        return new Content(
            view: $view,
            with: [
                'empleado' => $this->empleado,
                'afiliaciones' => $this->afiliaciones,
                'afiliacion' => $this->afiliacion
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        $attachments = [];
        
        if ($this->tipo === 'completada' && $this->afiliacion && $this->afiliacion->certificado_afiliacion) {
            $rutaArchivo = storage_path('app/public/' . $this->afiliacion->certificado_afiliacion);
            if (file_exists($rutaArchivo)) {
                $attachments[] = \Illuminate\Mail\Mailables\Attachment::fromPath($rutaArchivo)
                    ->as('Certificado_Afiliacion_' . $this->afiliacion->entidad_tipo . '.pdf')
                    ->withMime('application/pdf');
            }
        }
        
        return $attachments;
    }
}