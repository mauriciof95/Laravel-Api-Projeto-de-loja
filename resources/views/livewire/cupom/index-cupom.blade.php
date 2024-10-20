<div class="px-3">
    <header class="flex justify-between">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Cupons
        </h2>

        <div>
            <x-primary-link href="{{ route('cadastrar_cupom') }}">
                Novo Cupom
            </x-primary-link>
        </div>
    </header>

    <div class="bg-white mt-6">
        <div class="p-2 w-full sm:w-2/3 md:w-2/3 lg:w-2/4">
            <x-text-input-pesquisa />
        </div>

        <div class="relative overflow-x-auto">
            <table class=table>
                <thead class=thead>
                    <tr>
                        <th >
                            Identificacao do Cupom
                        </th>
                        <th >
                            Data de Validade
                        </th>
                        <th >
                            Valor do Cupom
                        </th>
                        <th >
                            Aplicado?
                        </th>
                        <th >
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody class="tbody">
                    @forelse($cupons as $item)
                        <tr>
                            <th>
                                {{$item->identificacao}}
                            </th>
                            <td>
                                {{ dataFormat($item->data_validade) }}
                            </td>
                            <td>
                                {{$item->valor_desconto}}%
                            </td>
                            <td>
                                {{$item->aplicado ? 'SIM' : 'NÃO'}}
                            </td>
                            <td>
                                <div class="inline-flex space-x-2">
                                    <x-secondary-link href="{{route('editar_cupom', ['id' => $item->id])}}">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </x-secondary-link>

                                    <x-danger-button x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'confirmar_deletar_cupom-{{$item->id}}')">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </x-danger-button>

                                    <x-modal name="confirmar_deletar_cupom-{{$item->id}}" :show="$errors->isNotEmpty()" focusable>
                                        <form wire:submit="deletar({{$item->id}})" class="p-6">
                                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                Você tem certeza que deseja deletar o cupom <b>{{$item->identificacao}}</b>?
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
                            <td colspan="5" class="px-6 py-4 text-center italic font-light">
                                Nenhum registro encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="my-2 p-2">
            {{ $cupons->onEachSide(1)->links() }}
        </div>
    </div>
</div>
