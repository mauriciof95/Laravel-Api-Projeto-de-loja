<?php

namespace App\Livewire\Categoria;

use App\Services\CategoriaServices;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class CadastrarCategoria extends Component
{
    protected CategoriaServices $categoriaServices;

    public string $nome = '';

    public function boot(CategoriaServices $categoriaServices)
    {
        $this->categoriaServices = $categoriaServices;
    }

    public function rules() : array
    {
        return [
            'nome' => ['required', 'string', 'min:3', 'unique:categorias,nome'],
        ];
    }

    public function cadastrar()
    {
        $dados = $this->validate();
        //$this->categoriaServices->cadastrar($dados);
        Session::flash('success', 'Registro cadastrado com sucesso!');
    }

    public function render()
    {
        return view('livewire.categoria.cadastrar-categoria');
    }
}
