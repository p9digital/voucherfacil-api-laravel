@component('mail::layout')
    {{-- Brand --}}
    @slot('brand')
        @component('mail::brand')
        @endcomponent
    @endslot

    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }}
        @endcomponent
    @endslot

    {{-- Body --}}
    @component('mail::table')
    | Dados      |               |
    | ------------- |--------------:|
    | Nome:     | {{$divulgue->nome_completo}}      |
    | Empresa:      | {{$divulgue->nome_empresa}} |
    | Email:      | {{$divulgue->email}} |
    | Whatsapp:      | {{$divulgue->whatsapp}} |
    | Ticket Médio:      | {{$divulgue->ticket_medio}} |
    | Cidade:      | {{$divulgue->cidade}} |
    | Uf:      | {{$divulgue->uf}} |
    | Atendimentos Dia:      | {{$divulgue->atendimentos}} |
    | Segmento:      | {{$divulgue->segmento_empresa}} |
    | Data:      | {{date("d/m/Y H:i:s")}} |
    @endcomponent

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
