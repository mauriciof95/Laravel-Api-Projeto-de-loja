<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function produto() : BelongsTo
    {
        return $this->belongsTo(Produto::class);
    }
}
