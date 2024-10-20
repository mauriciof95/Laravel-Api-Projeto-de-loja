<?php

namespace App\Services;

use App\Models\Produto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class ProdutoServices extends BaseServices
{
    public function __construct(private Produto $produto) { }

    public function listar($pesquisa = '', $select = [], $relacionamentos = [], $ordenacao = [], $porPagina = null) : Collection | LengthAwarePaginator
    {
        $query = $this->produto->query();
        $query->where('nome', 'like', '%'.$pesquisa.'%');

        $this->aplicarSelect($query, $select);
        $this->aplicarRelacionamento($query, $relacionamentos);
        $this->aplicarOrdenacao($query, $ordenacao);

        if (!is_null($porPagina)) {
            return $query->paginate($porPagina);
        }

        return $query->get();
    }

    public function encontrarPorId($id, $select = [], $relacionamentos = []) : Produto | null
    {
        $query = $this->produto->query();

        $this->aplicarSelect($query, $select);
        $this->aplicarRelacionamento($query, $relacionamentos);

        return $query->find($id);
    }

    public function cadastrar($dados) : Produto
    {
        if(!empty($dados['imagem'])){
            $dados['imagem'] = $this->salvarImagem($dados['imagem'], $dados['nome']);
        }

        return $this->produto->create($dados);
    }

    private function salvarImagem($imagem, $nome) : string {
        $extensao = $imagem->getClientOriginalExtension();
        $nomeImagem = hash('sha256', "{$nome} ".date('d-m-Y Hi')).".".$extensao;
        Storage::disk('public')->putFileAs('produtos', $imagem, $nomeImagem);
        return $nomeImagem;
    }

    public function deletarImagem($imagem) : void {
        if($imagem != null && Storage::disk('public')->exists('produtos/'.$imagem))
            Storage::disk('public')->delete('produtos/'.$imagem);
    }

    private function atualizarImagem($imagem, $nomeImagem, $nomeImagemExistente) : string
    {
        $extensao = $imagem->getClientOriginalExtension();
        $nomeImagem = hash('sha256', $nomeImagem." ".date('d-m-Y Hi')).".".$extensao;

        $this->deletarImagem($nomeImagemExistente);

        Storage::disk('public')->putFileAs('produtos', $imagem, $nomeImagem);
        return $nomeImagem;
    }

    public function atualizar($dados, $id)
    {
        $produto = $this->encontrarPorId($id);
        if(empty($produto))
            return ['error' => 'Registro não encontrado'];


        if(isset($dados['imagem']) && !empty($dados['imagem']))
        {
            if($produto->imagem == null)
                $dados['imagem'] = $this->salvarImagem($dados['imagem'], $produto->nome);
            else
                $dados['imagem'] = $this->atualizarImagem($dados['imagem'], $produto->nome, $produto->imagem);
        }

        if(isset($dados['imagem']) && $dados['imagem'] == null)
            $dados['imagem'] = $produto->imagem;

        $produto->update($dados);

        return $produto;
    }

    public function deletar($id) : Array | bool
    {
        $produto = $this->encontrarPorId($id);
        if(empty($produto))
            return ['error' => 'Registro não encontrado'];

        $resultado = $this->transaction(
            function() use ($produto){
                $produto->delete();
            },
            function() use ($produto){
                $this->deletarImagem($produto->imagem);
            }
        );

        if(!$resultado)
            return ['error' => 'Não foi possivel deletar o registro, verifique se este não possui registros dependentes.'];

        return true;
    }


}
