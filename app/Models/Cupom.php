<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cupom extends Model
{
    /** @use HasFactory<\Database\Factories\CupomFactory> */
    use HasFactory;

    protected $table = 'cupons';

    protected $fillable = [
        'identificacao',
        'data_validade',
        'valor_desconto',
        'aplicado'
    ];

    public function scopeValido(Builder $query)
    {
        return $query->where('aplicado', false)->where('data_validade', '>=', date("Y-m-d"));
    }
}
