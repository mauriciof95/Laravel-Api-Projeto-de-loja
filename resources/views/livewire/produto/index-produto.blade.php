<div class="px-3">
    <x-header class="flex justify-between">
        Produtos

        <x-slot name="subtitulo">
            <div>
                <x-primary-link href="{{ route('cadastrar_produto') }}">
                    Novo Produto
                </x-primary-link>
            </div>
        </x-slot>
    </x-header>

    <div class="bg-white mt-6">
        <div class="p-2 w-full sm:w-2/3 md:w-2/3 lg:w-2/4">
            <x-text-input-pesquisa />
        </div>

        <div class="relative overflow-x-auto">
            <table class=table>
                <thead class=thead>
                    <tr>
                        <th></th>
                        <th >
                            Nome da Produto
                        </th>
                        <th >
                            Categoria
                        </th>
                        <th >
                            Valor de Compra
                        </th>
                        <th >
                            Valor de Venda
                        </th>
                        <th >
                            Quantidade em Estoque
                        </th>
                        <th >
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody class="tbody">
                    @forelse($produtos as $item)
                        <tr>
                            <th class="px-6 py-4">
                                <div class="rounded-full bg-gray-200 max-w-14">
                                    <img src="{{ imagemProduto($item->imagem) }}" class="aspect-auto">
                                </div>
                            </th>
                            <th>
                                {{$item->nome}}
                            </th>
                            <th>
                                {{$item->categoria->nome}}
                            </th>
                            <th>
                                {{ dinheiroFormat($item->valor_compra) }}
                            </th>
                            <th>
                                {{ dinheiroFormat($item->valor_venda) }}
                            </th>
                            <th>
                                {{ $item->quantidade_estoque }}
                            </th>
                            <td>
                                <div class="inline-flex space-x-2">
                                    <x-secondary-link href="{{route('editar_produto', ['id' => $item->id])}}">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </x-secondary-link>

                                    <x-danger-button x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'confirmar_deletar_produto-{{$item->id}}')">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </x-danger-button>

                                    <x-modal name="confirmar_deletar_produto-{{$item->id}}" :show="$errors->isNotEmpty()" focusable>
                                        <form wire:submit="deletar({{$item->id}})" class="p-6">
                                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                Você tem certeza que deseja deletar a produto <b>{{$item->nome}}</b>?
                                            </h2>
                                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                                Uma vez deletado, o processo não pode ser desfeito.
                                            </p>
                                            <div class="mt-6 flex justify-end">
                                                <x-secondary-button x-on:click="$dispatch('close')">
                                                    Cancelar
                                                </x-secondary-button>
                                                <x-danger-button class="ms-3">
                                                    <span wire:loading wire:target="deletar" class="mr-2 size-4">
                                                        <span class="loader"></span>
                                                    </span>
                                                    Confirmar
                                                </x-danger-button>
                                            </div>
                                        </form>
                                    </x-modal>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center italic font-light">
                                Nenhum registro encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="my-2 p-2">
            {{ $produtos->onEachSide(1)->links() }}
        </div>
    </div>
</div>
