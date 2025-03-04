@component('mail::message')
# Quero divulgar minha oferta

@component('mail::table')
| Dados      |               |
| :------------- |--------------:|
| Nome:     | {{$divulgue->nome_completo}}      |
| Empresa:      | {{$divulgue->nome_empresa}} |
| Email:      | {{$divulgue->email}} |
| Whatsapp:      | {{$divulgue->whatsapp}} |
| Ticket Médio:      | {{$divulgue->ticket_medio}} |
| Cidade:      | {{$divulgue->cidade}} |
| UF:      | {{$divulgue->uf}} |
| Atendimentos Dia:      | {{$divulgue->atendimentos}} |
| Segmento:      | {{$divulgue->segmento_empresa}} |
| Data:      | {{date("d/m/Y H:i:s")}} |
@endcomponent

@endcomponent
