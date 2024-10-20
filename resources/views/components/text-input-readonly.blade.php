<div {{ $attributes->merge(['class' => "py-2 px-3 border border-gray-300 rounded-md shadow-sm"]) }}>
    <div style="min-height: 24px">
        {{ $slot }}
    </div>
</div>
