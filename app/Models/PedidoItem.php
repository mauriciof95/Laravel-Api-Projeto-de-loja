<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoItem extends Model
{
    /** @use HasFactory<\Database\Factories\PedidoItemFactory> */
    use HasFactory;

    protected $table = 'pedido_itens';

    protected $fillable = [
        'quantidade',
        'valor_unitario',
        'produto_id',
        'pedido_id',
    ];
}
