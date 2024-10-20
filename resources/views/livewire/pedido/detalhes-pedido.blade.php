
<div>

    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Detalhes do Pedido
        </h2>
    </header>

    <form wire:submit="atualizarStatus" class="mt-6 space-y-6">
        <x-card>

            <header>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Dados do Cliente
                </h2>
            </header>

            <div class="mt-1 grid grid-cols-1 gap-5 gap-y-3 md:grid-cols-2">
                <div>
                    <x-input-label :value="'Nome do Cliente'" />
                    <x-text-input-readonly  class="mt-1 block w-full">
                        {{ $pedido->cliente->nome }}
                    </x-text-input-readonly>
                </div>

                <div>
                    <x-input-label :value="'CPF do Cliente'" />
                    <x-text-input-readonly class="mt-1 block w-full">
                        {{ $pedido->cliente->c_cpf}}
                    </x-text-input-readonly>
                </div>
            </div>

            <div class="mt-1 grid grid-cols-1 gap-5 gap-y-3 md:grid-cols-2">
                <div>
                    <x-input-label :value="'Email do Cliente'" />
                    <x-text-input-readonly  class="mt-1 block w-full">
                        {{ $pedido->cliente->email }}
                    </x-text-input-readonly>
                </div>

                <div>
                    <x-input-label :value="'Telefone do Cliente'" />
                    <x-text-input-readonly class="mt-1 block w-full">
                        {{ $pedido->cliente->telefone}}
                    </x-text-input-readonly>
                </div>
            </div>

        </x-card>

        <x-card>

            <header>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Produtos
                </h2>
            </header>

            <table class="table">
                <thead class="thead">
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço Unitário</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody class="tbody">
                    @foreach($pedido->pedido_itens as $item)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar">
                                        <div class="rounded-full bg-gray-200 max-w-14">
                                            <img src="{{ imagemProduto($item->produto->imagem) }}" class="aspect-auto">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold">{{ $item->produto->nome }}</div>
                                        <div class="text-sm opacity-50">
                                            {{ $item->produto->categoria->nome }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $item->quantidade }}</td>
                            <td>{{ dinheiroFormat($item->valor_unitario) }}</td>
                            <td>{{ dinheiroFormat($item->valor_unitario * $item->quantidade) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="tfoot">
                    @if($pedido->cupom)
                        <tr>
                            <th colspan="3">Cupom ( {{ $pedido->cupom->identificacao }} )</th>
                            <th> {{ $pedido->cupom->valor_desconto }}% </th>
                        </tr>
                    @endif
                    <tr>
                        <th colspan="3">Subtotal</th>
                        <th>
                            {{
                                dinheiroFormat(
                                    $pedido->pedido_itens->sum(function($item){
                                        return $item->quantidade * $item->valor_unitario;
                                    })
                                )
                            }}
                        </th>
                    </tr>
                    <tr>
                        <th colspan="3">Total</th>
                        <th> {{ dinheiroFormat($pedido->valor_total) }} </th>
                    </tr>
                </tfoot>
            </table>

        </x-card>

        <x-card>
            <header>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Status do Pedido
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Certifique-se de que o status está correto antes de alterar.
                </p>
            </header>

            <div class="mt-1 grid grid-cols-1 gap-5 gap-y-3 md:grid-cols-2">
                <div>
                    <x-input-label for="status" :value="'Status'" />
                    <x-select wire:model="status" id="status" name="status" class="mt-1 block w-full">
                        <option value="{{App\Enums\PedidoEnum::RECEBIDO}}"> Recebido </option>
                        <option value="{{App\Enums\PedidoEnum::ENVIADO}}"> Enviado </option>
                        <option value="{{App\Enums\PedidoEnum::FINALIZADO}}"> Finalizado </option>
                        <option value="{{App\Enums\PedidoEnum::CANCELADO}}"> Cancelado </option>
                    </x-select>
                    <x-input-error class="mt-2" :messages="$errors->get('status')" />
                </div>
            </div>
        </x-card>

        <div class="flex items-center gap-4">
            <x-primary-button>
                <span wire:loading wire:target="atualizarStatus" class="mr-2 size-4">
                    <span class="loader"></span>
                </span>
                Salvar
            </x-primary-button>
            <x-secondary-button onclick="window.history.back()">
                Voltar
            </x-secondary-button>
        </div>

    </form>

</div>

