<header {{ $attributes->merge(['class' => '']) }}>
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        {!! $titulo ?? $slot !!}
    </h2>

    {!! $subtitulo ?? '' !!}

</header>
