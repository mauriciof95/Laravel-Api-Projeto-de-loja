
<div>
    <x-header>
        Cadastro de Categoria
    </x-header>

    <form wire:submit="cadastrar" class="mt-6 space-y-6">
        <x-card>

            <div>
                <x-input-label for="nome" :value="'Nome da Categoria'" />
                <x-text-input wire:model="nome" id="nome" name="nome" type="text" class="mt-1 block w-full"/>
                <x-input-error class="mt-2" :messages="$errors->get('nome')" />
            </div>

        </x-card>

        <div class="flex items-center gap-4">
            <x-primary-button>
                <span wire:loading wire:target="cadastrar" class="mr-2 size-4">
                    <span class="loader"></span>
                </span>
                Cadastrar
            </x-primary-button>
            <x-secondary-button onclick="window.history.back()">
                Voltar
            </x-secondary-button>
        </div>
    </form>
</div>

