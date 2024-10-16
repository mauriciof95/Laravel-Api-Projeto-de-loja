<?php

namespace App\Mail;

use App\Models\Pedido;
use App\Services\PedidoServices;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PedidoRealizado extends Mailable
{
    use Queueable, SerializesModels;

    public $pedido;
    public $url;

    /**
     * Create a new message instance.
     */
    public function __construct(Pedido $pedido)
    {
        $this->pedido = $pedido;
        $this->url = '';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('notification.teste.noreply@gmail.com', 'VendaExpress'),
            subject: 'Pedido Realizado Com Sucesso',
            replyTo: [
                new Address('mauriciofurtado.95@gmail.com', 'Mauricio'),
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'pedido-realizado',
            with: [
                'id' => $this->pedido->id,
                'cliente_nome' => $this->pedido->cliente_nome,
                'data_compra' => $this->pedido->data_venda,
                'valor_total' => $this->pedido->valor_total,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
