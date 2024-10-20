<x-email-layout>
    <div class="">
        <span class="text-3xl font-semibold">Olá, {{ $cliente_nome }}!</span>

        <p class="mt-4 text-lg">Agradecemos pela sua compra! Seu pedido foi enviado com sucesso, em breve chegará até você.</p>

        <p class="mt-4 text-lg">Se precisar de ajuda ou tiver alguma dúvida, estamos à disposição. Basta entrar em contato.</p>

        <p class="mt-6 text-lg">Atenciosamente,</p>

        <div class="mt-2 text-lg">
            <span class="block font-semibold">Equipe de Atendimento</span>
            <br>
            <span class="block text-gray-600">{{ config('app.name') }}</span>
        </div>
    </div>

</x-email-layout>
