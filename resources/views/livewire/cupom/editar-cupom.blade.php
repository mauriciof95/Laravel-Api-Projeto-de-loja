
<div>

    <x-header>
        Atualização de Cupom
    </x-header>

    <form wire:submit="atualizar" class="mt-6 space-y-6">

        <x-card>

            <div>
                <x-input-label for="identificacao" :value="'Identificação do Cupom'" />
                <x-text-input wire:model="identificacao" id="identificacao" name="identificacao" type="text" class="mt-1 block w-full" />
                <x-input-error class="mt-2" :messages="$errors->get('identificacao')" />
            </div>

            <div>
                <x-input-label for="data_validade" :value="'Data de Validade'" />
                <x-text-input wire:model="data_validade" id="data_validade" name="data_validade" type="text" class="mt-1 block w-full" />
                <x-input-error class="mt-2" :messages="$errors->get('data_validade')" />
            </div>

            <div>
                <x-input-label for="valor_desconto" :value="'Valor do Desconto'" />
                <x-text-input wire:model="valor_desconto" id="valor_desconto" name="valor_desconto" type="number" step="any" class="mt-1 block w-full" />
                <x-input-error class="mt-2" :messages="$errors->get('valor_desconto')" />
            </div>

            <div class="flex items-center space-x-2">
                <input id="aplicado" name="aplicado" wire:model="aplicado" type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <x-input-label for="aplicado" :value="'Cupom Aplicado?'" />
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

