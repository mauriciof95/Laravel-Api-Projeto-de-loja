<?php

namespace App\Mail;

use App\Models\Pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PedidoRecebidoMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(protected Pedido $pedido)
    {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')),
            subject: 'Pedido Realizado Com Sucesso',
            replyTo: [
                new Address($this->pedido->cliente->email, $this->pedido->cliente->nome),
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.pedido-recebido',
            with: [
                'id' => $this->pedido->id,
                'cliente_nome' => $this->pedido->cliente->nome,
                'data_compra' => $this->pedido->data_venda,
                'valor_total' => $this->pedido->valor_total,
                'url_pedido_detalhes' => env('FRONTEND_PEDIDO_DETALHES_URL').$this->pedido->id
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
