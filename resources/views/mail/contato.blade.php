@component('mail::message')
    @component('mail::table')
    | Dados      |               |
    | :------------- |--------------:|
    @if(!empty($contato->empresa))
        | Empresa:     | {{$contato->empresa}}      |
    @endif
    | Nome:      | {{$contato->nome}}      |
    | Email:     | {{$contato->email}}     |
    | Telefone:  | {{$contato->telefone}}  |
    | Data:      | {{date("d/m/Y H:i:s")}} |
    | Mensagem:  |                         |
    @endcomponent
    {{$contato->mensagem}}
@endcomponent