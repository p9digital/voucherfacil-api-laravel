<x-mail::message>
# Hoje é dia de sua reserva no {{$unidade->cliente->razaoSocial}}!

@component('mail::voucher', ['voucher' => $voucher, 'promocao' => $promocao, 'unidade' => $unidade, 'dia' => $dia, 'periodo' => $periodo])
@endcomponent

</x-mail::message>
