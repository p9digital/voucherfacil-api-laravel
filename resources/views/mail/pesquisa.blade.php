<x-mail::message>
# Agendamento de Pesquisa

<br/>
{{$unidade->cliente->razaoSocial ?? ''}} {{$unidade->nome ?? ''}} - {{$promocao->titulo ?? ''}}

<x-mail::table>
| Dados      |               |
| :------------- |--------------:|
| Agendamento:     | **{{$dia . " - " . ($promocao->id == 5 && $unidade->id == 2 ? "ordem de chegada" : $periodo)}}**      |
| Nome:     | {{$agendamento->nome}}      |
| Celular:      | {{$agendamento->telefone}} |
| Email:      | {{$agendamento->email}} |
| CPF:      | {{$agendamento->cpf}} |
@if($respostas)
  | ----- | ----- |
  | **Respostas**:      |  |
  @foreach($respostas as $resposta)
  | {{$resposta["id"] . "- " . $resposta["pergunta"]}} | {{$resposta["resposta"]}} |
  @endforeach
  | ----- | ----- |
@endif
| Origem:      | {{$agendamento->origem ? $agendamento->origem : "--"}} |
| Gerado em:      | {{date("d/m/Y H:i")}} |
</x-mail::table>

</x-mail::message>
