<?php

function imagemProduto($imagem){
    $imagem = $imagem ?? 'produto_default.jpg';

    return Illuminate\Support\Facades\Storage::url('produtos/'.$imagem);
}
