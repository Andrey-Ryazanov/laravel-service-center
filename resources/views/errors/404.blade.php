@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
        <div class="empty-message">
            <div class="empty-message__404-image"></div>
            <div class="empty-message__text-wrapper">
                <div class="empty-message__title-empty-cart">Упс...</div>
                <p class="empty-message__text">Страница не найдена!</p>
                <a href = "/">
                <button class="base-ui-button-v2_medium base-ui-button-v2_brand base-ui-button-v2_ico-none base-ui-button-v2 buy-button" loading="false" id="buy-btn-main">
                    <span class="base-ui-button-v2__text">На главную</span>
                </button>
                </a>
            </div>
        </div>
            </div>
        </div>
    </div>
@endsection