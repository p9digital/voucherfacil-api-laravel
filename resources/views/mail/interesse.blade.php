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
    | Nome:     | {{$interesse->nome}}      |
    | Promoção:     | {{$promocao->titulo}}      |
    | Cliente:     | {{$promocao->cliente->nomeFantasia}}      |
    | Telefone:      | {{$interesse->celular}} |
    | Email:      | {{$interesse->email}} |
    | Cidade/UF:      | {{$interesse->cidade}}/{{$interesse->uf}} |
    | Origem:      | {{$interesse->origem}} |
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
            &copy; {{ date('Y') }} {{ config('app.name') }}.
        @endcomponent
    @endslot
@endcomponent
