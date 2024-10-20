
<div>
    <x-header class="flex justify-between">
        Atualização de Categoria
    </x-header>

    <form wire:submit="atualizar" class="mt-6 space-y-6">
        <x-card>

            <div>
                <x-input-label for="nome" :value="'Nome da Categoria'" />
                <x-text-input wire:model="nome" id="nome" name="nome" type="text" class="mt-1 block w-full" required autofocus autocomplete="nome" />
                <x-input-error class="mt-2" :messages="$errors->get('nome')" />
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

