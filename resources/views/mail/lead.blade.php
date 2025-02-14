@component('mail::message', ['promocao' => $promocao])
# Novo lead

@component('mail::table')
| Dados      |               |
| ------------- |--------------:|
| Nome:     | {{$lead->nome}}      |
| Telefone:      | {{$lead->telefone}} |
| Email:      | {{$lead->email}} |
| Origem:      | {{$lead->origem}} |
| Formulário:      | {{$lead->form}} |
| Path:      | {{url('')}} |
| Dispositivo:      | {{$lead->device . " / IP: " . $lead->ip}} |
| Data:      | {{date("d/m/Y H:i:s")}} |
@endcomponent

@endcomponent