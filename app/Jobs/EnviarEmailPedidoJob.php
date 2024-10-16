<?php

namespace App\Jobs;

use App\Mail\PedidoRealizado;
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
        Mail::to($this->pedido->cliente_email)
            ->send(new PedidoRealizado($this->pedido));
    }
}
