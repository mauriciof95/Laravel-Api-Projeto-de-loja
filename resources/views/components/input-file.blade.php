@props([
    'tipo' => null,
    'filename' => null,
])

<div
    wire:ignore
    x-data="{pond: null}"
    x-init="() => {
        pond = FilePond.create($refs.input);
        pond.setOptions({
            labelIdle: 'Arraste e solte seus arquivos ou <span class=filepond--label-action> Navegue </span>',
            labelFileProcessing: 'Carregando',
            labelFileProcessingComplete: 'Carregamento concluido',
            labelTapToCancel: 'Clique para cancelar',
            labelTapToUndo: 'Clique para desfazer',
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    @this.upload('{{ $attributes['wire:model'] }}', file, load, error, progress)
                },
                revert: (filename, load) => {
                    @this.removeUpload('{{ $attributes['wire:model'] }}', filename, load)
                },
            },
            files: [
                @if ($tipo && $filename)
                {
                    source: '{{ route('storage', ['tipo' => $tipo, 'filename' => $filename]) }}',
                    options: {
                        type: 'url',
                    },
                }
                @endif
            ],
        });

        $wire.on('pond-reset', () => {
            pond.removeFiles();
        });
    }"
>
    <input type="file" class="filepond" x-ref="input"/>
</div>
