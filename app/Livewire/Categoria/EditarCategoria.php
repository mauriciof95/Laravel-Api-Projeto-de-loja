<?php

namespace App\Livewire\Categoria;

use App\Services\CategoriaServices;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class EditarCategoria extends Component
{
    protected CategoriaServices $categoriaServices;

    public int $id = 0;
    public string $nome = '';

    public function boot(CategoriaServices $categoriaServices)
    {
        $this->categoriaServices = $categoriaServices;
    }

    public function mount($id)
    {
        $categoria = $this->categoriaServices->encontrarPorId($id);

        if(is_null($categoria))
        {
            Toaster::warning('Registro não encontrado');
            return redirect()->route('index_categoria');
        }

        $this->id = $categoria->id;
        $this->nome = $categoria->nome;
    }

    public function rules() : array
    {
        return [
            'nome' => ['required', 'string', 'min:3', 'unique:categorias,nome,'.$this->id],
        ];
    }

    public function atualizar()
    {
        $dados = $this->validate();
        $resultado = $this->categoriaServices->atualizar($dados, $this->id);

        if(!empty($resultado['error']))
        {
            return Toaster::warning($resultado['error']);
        }

        Toaster::success('Registro atualizado com sucesso!');
    }

    public function render()
    {
        return view('livewire.categoria.editar-categoria');
    }
}
