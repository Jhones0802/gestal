<?php

namespace App\Mail;

use App\Models\Capacitacion;
use App\Models\Empleado;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CapacitacionNotificacion extends Mailable
{
    use Queueable, SerializesModels;

    public $capacitacion;
    public $empleado;
    public $tipo;

    /**
     * Create a new message instance.
     */
    public function __construct(Capacitacion $capacitacion, Empleado $empleado, string $tipo)
    {
        $this->capacitacion = $capacitacion;
        $this->empleado = $empleado;
        $this->tipo = $tipo;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = match($this->tipo) {
            'invitacion' => 'Invitación a Capacitación: ' . $this->capacitacion->titulo,
            'recordatorio' => 'Recordatorio de Capacitación: ' . $this->capacitacion->titulo,
            'cancelacion' => 'Cancelación de Capacitación: ' . $this->capacitacion->titulo,
            'actualizacion' => 'Actualización de Capacitación: ' . $this->capacitacion->titulo,
            default => 'Notificación de Capacitación'
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
            'invitacion' => 'emails.capacitacion.invitacion',
            'recordatorio' => 'emails.capacitacion.recordatorio',
            'cancelacion' => 'emails.capacitacion.cancelacion',
            'actualizacion' => 'emails.capacitacion.actualizacion',
            default => 'emails.capacitacion.invitacion'
        };

        return new Content(
            view: $view,
            with: [
                'capacitacion' => $this->capacitacion,
                'empleado' => $this->empleado
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
