<?php

namespace App\Livewire\Categoria;

use App\Services\CategoriaServices;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class CadastrarCategoria extends Component
{
    protected CategoriaServices $categoria_services;

    public string $nome = '';

    public function boot(CategoriaServices $categoria_services)
    {
        $this->categoria_services = $categoria_services;
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
        $this->categoria_services->cadastrar($dados);
        Toaster::success('Registro cadastrado com sucesso!');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.categoria.cadastrar-categoria');
    }
}
