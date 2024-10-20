<div class="px-3">

    <x-header>
        Pedidos
    </x-header>

    <div class="bg-white mt-6">
        <div class="p-2 w-full sm:w-2/3 md:w-2/3 lg:w-2/4">
            <x-text-input-pesquisa />
        </div>

        <div class="relative overflow-x-auto">
            <table class=table>
                <thead class=thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Cliente
                        </th>
                        <th>
                            Data da Venda
                        </th>
                        <th>
                            Valor do Pedido
                        </th>
                        <th>
                            Valor do Desconto
                        </th>
                        <th>
                            Status
                        </th>
                        <th >
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody class="tbody">
                    @forelse($pedidos as $item)
                        <tr>
                            <th>
                                {{$item->id}}
                            </th>
                            <th>
                                {{$item->cliente->nome}}
                            </th>
                            <th>
                                {{$item->data_venda}}
                            </th>
                            <th>
                                {{ dinheiroFormat($item->valor_total) }}
                            </th>
                            <th>
                                {{ $item->cupom ? $item->cupom->valor_desconto.'%' : '' }}
                            </th>
                            <th>
                                @switch($item->status)
                                @case(App\Enums\PedidoEnum::RECEBIDO)
                                    <span class="badge bg-indigo-100 text-indigo-800">Recebido</span>
                                    @break
                                @case(App\Enums\PedidoEnum::ENVIADO)
                                    <span class="badge bg-blue-100 text-blue-800">Enviado</span>
                                    @break
                                @case(App\Enums\PedidoEnum::FINALIZADO)
                                    <span class="badge bg-green-100 text-green-800">Finalizado</span>
                                    @break
                                @case(App\Enums\PedidoEnum::CANCELADO)
                                    <span class="badge bg-red-100 text-red-800">Cancelado</span>
                                    @break
                            @endswitch
                            </th>
                            <td>
                                <div class="inline-flex space-x-2">
                                    <x-secondary-link href="{{route('detalhes_pedido', ['id' => $item->id])}}">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </x-secondary-link>
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
            {{ $pedidos->onEachSide(1)->links() }}
        </div>
    </div>
</div>
