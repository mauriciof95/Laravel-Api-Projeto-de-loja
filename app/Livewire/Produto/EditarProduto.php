<?php

namespace App\Livewire\Produto;

use App\Services\CategoriaServices;
use App\Services\ProdutoServices;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Masmerise\Toaster\Toaster;

class EditarProduto extends Component
{
    use WithFileUploads;

    protected ProdutoServices $produtoServices;
    protected CategoriaServices $categoriaServices;

    public int $id = 0;
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

    public function mount($id)
    {
        $produto = $this->produtoServices->encontrarPorId($id);

        if(is_null($produto))
        {
            Toaster::warning('Registro não encontrado');
            return redirect()->route('index_produto');
        }

        $this->categorias = $this->categoriaServices->listar();

        $this->id = $produto->id;
        $this->nome = $produto->nome;
        $this->descricao = $produto->descricao;
        $this->valor_compra = $produto->valor_compra;
        $this->valor_venda = $produto->valor_venda;
        $this->quantidade_estoque = $produto->quantidade_estoque;
        $this->categoria_id = $produto->categoria_id;
    }

    public function rules() : array
    {
        return [
            'nome' => ['required', 'string', 'min:3', 'unique:produtos,nome,'.$this->id],
            'imagem' => ['nullable', 'image', 'mimes:jpg,png,jpeg,svg', 'max:3048'],
            'descricao' => ['string', 'min:3'],
            'valor_compra' => ['required', 'numeric', 'min:0'],
            'valor_venda' => ['required', 'numeric', 'min:0'],
            'quantidade_estoque' => ['required', 'numeric', 'min:0'],
            'categoria_id' => ['required', 'int', 'exists:categorias,id'],
        ];
    }

    public function atualizar()
    {
        $dados = $this->validate();
        $resultado = $this->produtoServices->atualizar($dados, $this->id);

        if(!empty($resultado['error']))
        {
            return Toaster::warning($resultado['error']);
        }

        Toaster::success('Registro atualizado com sucesso!');
    }

    public function render()
    {
        return view('livewire.produto.editar-produto');
    }
}
