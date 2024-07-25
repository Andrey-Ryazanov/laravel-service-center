@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <div class = "cart-page-new">
    <h1 class="cart__page-title">Корзина</h1>
    @if ($total > 0)
    <div class="cart-tabs">
      <div class="cart-tab">
        <div class="cart-tab-content">
          <div class="cart-tab-services-list ">
          @foreach ($categories as $category)
            <div class="cart-items"><!--v-if-->
            <div class="cart-items__services"><!--v-if--><!--v-if-->
            
            <div class="cart-items__service">
            <div class="bh6">
              <div class="hb7">
                  <span>{{ $category->title }}</span>         
                </div>
              </div>
              <div class = "cart-items__main_part">
              @foreach ($services as $service)
                @if ($category->id_category == $service->category_id)
                <div class="cart-items__content-container">
                  <div class="cart-items__wrapper">
                    <div class="cart-items__service-thumbnail">
                      <div class="cart-items__select-wrapper cart-items__select-wrapper-product"><!--v-if--></div>
                      <div class="cart-items__service-image-block">
                        <div class="cart-items__service-image-wrap">
                          <a class="cart-items__service-image-link" href="">
                            <img class="cart-items__service-image-img" src="{{ asset('uploads/services/'.$service->main_image) }}">
                          </a>
                        </div>
                      </div>
                      <div class="cart-items__service-info">
                        <div class="cart-items__service-caption">
                          <div class="cart-items__service-name">
                            <a class="base-ui-link base-ui-link_gray_dark" href="/product/2d8420720d5fed20/processor-amd-ryzen-5-3600-box/" target="_self">
                              {{ $service->name_service }}
                            </a>
                          </div>
                          <div class="cart-items__service-actions-wrapper">
                            <div class="cart-items__service-actions"><!--v-if--></div><!--v-if-->
                          </div><!--v-if-->
                          <div class="menu-service cart-items__menu-service menu-service_enabled-service">
                            <div class="menu-service-standard-view">
                              <div class="menu-service-dots"></div>
                              <div class="menu-service-wrapper" style="">
                                <button class="menu-control-button remove-button">
                                  <p class="remove-button__title">Удалить</p>
                                  <i class="remove-button__icon"></i>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div><!--v-if-->
                      </div>
                    </div>
                    <div class="cart-items__service-count">
                      <div class="count-buttons">
                        <button class="count-buttons__button count-buttons__button_minus" >
                          <i class="count-buttons__icon fa fa-minus-square"></i>
                        </button>
                        <input name = "count-buttons__input" class="count-buttons__input" value = "{{ $service->quantity }}"> 
                        <input name = "service_id" type = "hidden" class="service_id" value = "{{ $service->id_category_service }}">
                        <button class="count-buttons__button count-buttons__button_plus">
                          <i class="count-buttons__icon fa fa-plus-square"></i>
                        </button>
                      </div>
                    </div>
                      <div class="cart-items__service-block-amount">
                        <div class="cart-items__service-price">
                          <div class="price">
                            <div class="price__block price__block_main"><!--v-if-->
                            <span class="price__current">{{ $service->price * $service->quantity }} ₽</span>
                          </div><!--v-if-->
                        </div><!--v-if-->
                      </div><!--v-if-->
                    </div><!--v-if-->
                  </div>
              </div>
              @endif
              @endforeach
            </div>
          </div><!--v-if-->
          <div class="total-amount__notifications"><!--v-if--></div>
        </div><!--v-if--><!--v-if-->
      </div>
      @endforeach
  </div>
      <div class="cart-tab-total-amount">
        <div class="cart-tab-total-amount__inner">
          <div id="total-amount" class="total-amount">
            <div class="total-amount__content">
              <div class="total-amount__title total-amount__title_bottom-border">
                <span class="">Условия заказа</span>
              </div>
              <div class="total-amount__profit-wrapper"><!--v-if--><!--v-if-->
                <div class="total-amount__logistic-section total-amount__row">
                  <div class="total-amount-toggler discount-logistic-toggler">
                    <div class="total-amount-toggler__text">
                      <span class="total-amount-toggler__value">Вызвать мастера по адресу</span>
                        <div class="total-amount-toggler__description">услуги, необслуживаемые по адресу будут скрыты</div>
                      </div>
                      <label class="base-ui-toggle">
                        <span class="base-ui-toggle__title"></span>
                        <span class="base-ui-toggle__icon"></span>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="total-amount__summary-section">
                  <div class="price-summary summary">
                    <div class="summary-header" style="cursor: default;">
                      <div class="summary-header__text">
                        <span class="summary-header__total">Итого:</span>
                        <div class="summary-header__total-items">{{ $count }}</div>
                      </div>
                      <div class="summary-header__sum">
                        <div class="price summary__price">
                          <div class="price__block price__block_main">
                            <span class="price__current">{{ $total }} ₽</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <div class="total-amount__buttons-section">
                <div class="total-amount__tooltip-wrapper">
                  <div class="base-ui-tooltip base-ui-tooltip_center-bottom">
                    <p>Обязательна 100% предоплата товара: </p>
                  </div>
                </div>
                <div class="">
                  <a href = "/ordernow">
                  <button class="base-ui-button-v2_medium base-ui-button-v2_brand base-ui-button-v2_ico-none base-ui-button-v2 buy-button" loading="false" id="buy-btn-main">
                    <div class="base-ui-button-v2__ico">
                      <i class="buy-button__icon"></i>
                    </div>
                    <span class="base-ui-button-v2__text">Оформить</span>
                  </button>
                  </a>
                </div>
              </div>
            </div>
            <div class="total-amount__notifications">
          </div>
        </div>
      </div>
    </div>
</div>
@else 

<div class="empty-message">
  <div class="empty-message__cart-image"></div>
  <div class="empty-message__text-wrapper">
    <div class="empty-message__title-empty-cart">Корзина пуста</div>
    <p class="empty-message__text">Добавьте услуги в корзину и возвращайтесь!</p>
    <a href = "/">
      <button class="base-ui-button-v2_medium base-ui-button-v2_brand base-ui-button-v2_ico-none base-ui-button-v2 buy-button" loading="false" id="buy-btn-main">
        <span class="base-ui-button-v2__text">Перейти в каталог услуг</span>
      </button>
      </a>
  </div>
</div>
@endif
</div>
@endsection
@push('scripts')
    <script src="/js/work_with_cart.js"></script>
@endpush