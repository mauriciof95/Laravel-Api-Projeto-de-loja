<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    ];

    public function pedido_itens(): HasMany
    {
        return $this->hasMany(PedidoItem::class);
    }
}
