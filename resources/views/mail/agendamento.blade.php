<x-mail::message>
# Agendamento

<br>
{{$unidade->cliente->razaoSocial ?? ''}} {{$unidade->nome ?? ''}} - {{$promocao->titulo ?? ''}}


<x-mail::table>
|       |               |
| ------------- |--------------:|
| Agendamento:     | **{{$dia . " - " . ($promocao->id == 5 && $unidade->id == 2 ? "ordem de chegada" : $periodo)}}**      |
| Nome:     | {{$agendamento->nome}}      |
| Celular:      | {{$agendamento->telefone}} |
| Email:      | {{$agendamento->email}} |
| Pessoas:      | {{$agendamento->pessoas}} |
| Origem:      | {{$agendamento->origem ? $agendamento->origem : "--"}} |
| Gerado em:      | {{date("d/m/Y H:i")}} |
</x-mail::table>

</x-mail::message>
