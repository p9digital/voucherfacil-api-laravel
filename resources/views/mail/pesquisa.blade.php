<x-mail::message>
# Agendamento

<br/>
## {{$unidade->cliente->razaoSocial ?? ''}} {{$unidade->nome ?? ''}} - {{$promocao->titulo ?? ''}}

<x-mail::table>
|       |               |
| ------------- |--------------:|
| Agendamento:     | **{{$dia . " - " . ($promocao->id == 5 && $unidade->id == 2 ? "ordem de chegada" : $periodo)}}**      |
| Nome:     | {{$agendamento->nome}}      |
| Celular:      | {{$agendamento->telefone}} |
| Email:      | {{$agendamento->email}} |
| CPF:      | {{$agendamento->cpf}} |
@if($respostas)
| ----- | ----- |
| Respostas:      |  |
@foreach($respostas as $resposta)
| {{$resposta["id"] . "- " . $resposta["pergunta"]}} | {{$resposta["resposta"]}} |
@endforeach
| ----- | ----- |
@endif
| Origem:      | {{$agendamento->origem}} |
| Dispositivo:      | {{$agendamento->device . " / IP: " . $agendamento->ip}} |
| Gerado em:      | {{date("d/m/Y H:i")}} |
</x-mail::table>

</x-mail::message>
