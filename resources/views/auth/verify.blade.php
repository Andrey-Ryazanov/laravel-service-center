@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="empty-message">
               <div class="empty-message__vefiry-image"></div>
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('На ваш адрес электронной почты отправлена новая ссылка для подтверждения.') }}
                    </div>
                @endif
                
                <div class="empty-message__text-wrapper">
                    <div class="empty-message__title-empty-cart"> Проверьте свою электронную почту</div>
                    <p class="empty-message__text">Если вы не получили письмо</p>
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('нажмите здесь, чтобы запросить ещё раз') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

