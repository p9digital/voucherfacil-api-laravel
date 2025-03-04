@component('mail::message')
# Interesse na oferta

@component('mail::table')
| Dados      |               |
| :------------- |--------------:|
| Nome:     | {{$interesse->nome}}      |
| Promoção:     | {{$promocao->titulo}}      |
| Cliente:     | {{$promocao->cliente->nomeFantasia}}      |
| Telefone:      | {{$interesse->celular}} |
| Email:      | {{$interesse->email}} |
| Cidade/UF:      | {{$interesse->cidade}}/{{$interesse->uf}} |
| Origem:      | {{$interesse->origem}} |
| Data:      | {{date("d/m/Y H:i:s")}} |
@endcomponent

@endcomponent
