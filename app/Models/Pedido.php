<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedido extends Model
{
    /** @use HasFactory<\Database\Factories\PedidoFactory> */
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'cliente_id',
        'status',
        'valor_total',
        'data_venda',
        'cupom_id',
    ];

    public function pedido_itens(): HasMany
    {
        return $this->hasMany(PedidoItem::class);
    }

    public function cliente() : BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function cupom() : BelongsTo
    {
        return $this->belongsTo(Cupom::class);
    }
}
