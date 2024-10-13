<?php

namespace App\Livewire\Produto;

use App\Services\CategoriaServices;
use App\Services\ProdutoServices;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Masmerise\Toaster\Toaster;

class CadastrarProduto extends Component
{
    use WithFileUploads;

    protected ProdutoServices $produtoServices;
    protected CategoriaServices $categoriaServices;

    public string $nome = '';
    public string $descricao = '';
    public $imagem;
    public float $valor_compra = 0.0;
    public float $valor_venda = 0.0;
    public int $quantidade_estoque = 0;
    public $categoria_id = '';

    public Collection $categorias;

    public function boot(
        ProdutoServices $produtoServices,
        CategoriaServices $categoriaServices
    )
    {
        $this->produtoServices = $produtoServices;
        $this->categoriaServices = $categoriaServices;
    }

    public function mount()
    {
        $this->categorias = $this->categoriaServices->listar();
    }

    public function rules() : array
    {
        return [
            'nome' => ['required', 'string', 'min:3', 'unique:produtos,nome'],
            'imagem' => ['nullable', 'image', 'mimes:jpg,png,jpeg,svg', 'max:3048'],
            'descricao' => ['string', 'min:3'],
            'valor_compra' => ['required', 'numeric', 'min:0'],
            'valor_venda' => ['required', 'numeric', 'min:0'],
            'quantidade_estoque' => ['required', 'numeric', 'min:0'],
            'categoria_id' => ['required', 'int', 'exists:categorias,id'],
        ];
    }

    public function cadastrar()
    {
        $dados = $this->validate();
        $this->produtoServices->cadastrar($dados);
        Toaster::success('Registro cadastrado com sucesso!');
        $this->resetExcept(['categorias']);
        $this->dispatch('pond-reset');
    }


    public function render()
    {
        return view('livewire.produto.cadastrar-produto');
    }
}
