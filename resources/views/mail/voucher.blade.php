<x-mail::message>
# Este é o número do seu Voucher Fácil!

@component('mail::voucher', ['voucher' => $voucher, 'promocao' => $promocao, 'unidade' => $unidade, 'dia' => $dia, 'periodo' => $periodo])
@endcomponent
</x-mail::message>
