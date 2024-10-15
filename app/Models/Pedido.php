<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    /** @use HasFactory<\Database\Factories\PedidoFactory> */
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'cliente_nome',
        'cliente_cpf',
        'cliente_telefone',
        'cliente_email',
        'valor_total',
        'data_venda',
        'cupom_id',
    ]
}
