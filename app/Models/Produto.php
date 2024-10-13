<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';

    protected $fillable = [
        'nome',
        'descricao',
        'imagem',
        'valor_compra',
        'valor_venda',
        'quantidade_estoque',
        'categoria_id',
    ];

    public function categoria() : BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }
}
