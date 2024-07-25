@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
        <img src="https://thumb.cloud.mail.ru/weblink/thumb/xw1/TVX6/w4zEgZEzT" style = "height:50px;"/>
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

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
        © {{ date('Y') }} {{ ('Gadget Genius') }}. @lang('Все права защищены.')
        @endcomponent
    @endslot
@endcomponent
