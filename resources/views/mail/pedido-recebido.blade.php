<x-email-layout>
    <div class="">
        <span class="text-3xl font-semibold">Olá, {{ $cliente_nome }}!</span>

        <p class="mt-4 text-lg">Agradecemos pela sua compra! Seu pedido foi recebido com sucesso e estamos felizes em
            confirmá-lo.</p>

        <p class="mt-4 text-lg font-semibold">Resumo do Pedido:</p>

        <div class="mt-2 bg-gray-100 p-4 rounded-lg text-base">
            <p><span class="font-semibold">Número do Pedido:</span> #{{ $id }}</p>
            <p><span class="font-semibold">Data da Compra:</span> {{ dataFormat($data_compra) }}</p>
            <p><span class="font-semibold">Total da Compra:</span> {{ dinheiroFormat($valor_total) }}</p>
        </div>

        <p class="mt-4 text-lg">Para visualizar os detalhes completos do seu pedido, acesse o link abaixo:</p>

        <a href="{{ $url_pedido_detalhes }}"
            class="mt-2 inline-block text-blue-600 hover:text-blue-800 underline text-lg font-semibold">Visualizar
            Pedido</a>

        <p class="mt-4 text-lg">Se precisar de ajuda ou tiver alguma dúvida, estamos à disposição. Basta entrar em contato.</p>

        <p class="mt-6 text-lg">Atenciosamente,</p>

        <div class="mt-2 text-lg">
            <span class="block font-semibold">Equipe de Atendimento</span>
            <br>
            <span class="block text-gray-600">{{ config('app.name') }}</span>
        </div>
    </div>

</x-email-layout>
