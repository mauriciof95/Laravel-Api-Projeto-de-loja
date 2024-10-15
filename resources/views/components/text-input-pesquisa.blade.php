<div class="relative">
    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
        <span wire:loading wire:target="pesquisa">
            <span class="loader mr-2 size-4" role="status" aria-hidden="true"></span>
        </span>
        <i class="fas fa-search" wire:loading.remove wire:target="pesquisa"></i>
    </div>
    <input wire:model.live.debounce.850ms="pesquisa" placeholder="Pesquisar..." class="block w-full py-2 px-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500"/>
</div>
