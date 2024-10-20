
<div>
    <x-header>
        Atualização de Produto
    </x-header>

    <form wire:submit="atualizar" class="mt-6 space-y-6">

        <x-card>

                <div class="mt-1 grid grid-cols-1 gap-5 gap-y-3 md:grid-cols-2">
                    <div>
                        <x-input-label for="nome" :value="'Nome do Produto'" />
                        <x-text-input wire:model="nome" id="nome" name="nome" type="text" class="mt-1 block w-full" />
                        <x-input-error class="mt-2" :messages="$errors->get('nome')" />
                    </div>

                    <div>
                        <x-input-label for="categoria_id" :value="'Categoria'" />
                        <x-select wire:model="categoria_id" id="categoria_id" name="categoria_id" class="mt-1 block w-full">
                            @forelse($categorias as $item)
                                @if($loop->first)
                                    <option disabled value="">Selecione uma opção</option>
                                @endif
                                <option value="{{ $item->id }}">{{ $item->nome }}</option>
                            @empty
                                <option>Sem categorias cadastradas.</option>
                            @endforelse
                        </x-select>
                        <x-input-error class="mt-2" :messages="$errors->get('categoria_id')" />
                    </div>
                </div>

                <div class="mt-1 grid grid-cols-1 gap-5 gap-y-3 md:grid-cols-3">
                    <div>
                        <x-input-label for="valor_compra" :value="'Valor de Compra'" />
                        <x-text-input wire:model="valor_compra" id="valor_compra" name="valor_compra" type="number" step="any" class="mt-1 block w-full" />
                        <x-input-error class="mt-2" :messages="$errors->get('valor_compra')" />
                    </div>

                    <div>
                        <x-input-label for="valor_venda" :value="'Valor de Venda'" />
                        <x-text-input wire:model="valor_venda" id="valor_venda" name="valor_venda" type="number" step="any" class="mt-1 block w-full" />
                        <x-input-error class="mt-2" :messages="$errors->get('valor_venda')" />
                    </div>

                    <div>
                        <x-input-label for="quantidade_estoque" :value="'Quantidade de Estoque'" />
                        <x-text-input wire:model="quantidade_estoque" id="quantidade_estoque" name="quantidade_estoque" type="number" step="1" class="mt-1 block w-full" />
                        <x-input-error class="mt-2" :messages="$errors->get('quantidade_estoque')" />
                    </div>
                </div>

                <div>
                    <x-input-label for="descricao" :value="'Descrição'" />
                    <x-text-area rows="3" wire:model="descricao" id="descricao" name="descricao" class="mt-1 block w-full" />
                    <x-input-error class="mt-2" :messages="$errors->get('descricao')" />
                </div>

                <div>
                    <x-input-label for="imagem" :value="'Imagem'" class="mb-1"/>
                    <x-input-file wire:model="imagem"/>
                    <x-input-error class="mt-2" :messages="$errors->get('imagem')" />
                </div>

        </x-card>

        <div class="flex items-center gap-4">
            <x-primary-button>
                <span wire:loading wire:target="atualizar" class="mr-2 size-4">
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

