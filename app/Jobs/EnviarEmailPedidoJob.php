<?php

namespace App\Jobs;

use App\Enums\PedidoEnum;
use App\Mail\PedidoCanceladoMail;
use App\Mail\PedidoEnviadoMail;
use App\Mail\PedidoFinalizadoMail;
use App\Mail\PedidoRealizado;
use App\Mail\PedidoRecebidoMail;
use App\Models\Pedido;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class EnviarEmailPedidoJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected Pedido $pedido)
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $mail = null;

        switch($this->pedido->status){
            case PedidoEnum::RECEBIDO:
                $mail = new PedidoRecebidoMail($this->pedido);
                break;
            case PedidoEnum::ENVIADO:
                $mail = new PedidoEnviadoMail($this->pedido);
                break;
            case PedidoEnum::FINALIZADO:
                $mail = new PedidoFinalizadoMail($this->pedido);
                break;
            case PedidoEnum::CANCELADO:
                $mail = new PedidoCanceladoMail($this->pedido);
                break;
        }

        Mail::to($this->pedido->cliente->email)->send($mail);
    }
}
