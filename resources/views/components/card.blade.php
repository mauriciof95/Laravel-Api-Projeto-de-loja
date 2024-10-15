<div {{ $attributes->merge(['class' => 'p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg']) }}>
    <div class="space-y-6">
        {{ $slot }}
    </div>
</div>
