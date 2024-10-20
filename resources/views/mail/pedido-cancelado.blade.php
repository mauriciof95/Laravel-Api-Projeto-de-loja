<x-email-layout>
    <div class="">
        <span class="text-3xl font-semibold">Olá, {{ $cliente_nome }}!</span>

        <p class="mt-4 text-lg">Seu pedido foi cancelado, caso isso seja um erro, entre em contato com nossa central para podermos-lhe ajudar.</p>

        <p class="mt-6 text-lg">Atenciosamente,</p>

        <div class="mt-2 text-lg">
            <span class="block font-semibold">Equipe de Atendimento</span>
            <br>
            <span class="block text-gray-600">{{ config('app.name') }}</span>
        </div>
    </div>

</x-email-layout>
