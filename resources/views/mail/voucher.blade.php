@component('mail::message', ['promocao' => $promocao])
# Este é o número do seu Voucher Fácil!

@component('mail::voucher', ['voucher' => $voucher, 'promocao' => $promocao, 'unidade' => $unidade, 'dia' => $dia, 'periodo' => $periodo])
@endcomponent

@endcomponent
