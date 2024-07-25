@extends('layouts.app')
@section('content') 
<div class = "cart-page-new">
    <h1 class="cart__page-title">Детали заказа № {{ $order->code }}</h1>
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
                                    @foreach ($orderItems as $item)
                                    @if ($item->category_service_id == $service->id_category_service)
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
                                                            <a class="base-ui-link base-ui-link_gray_dark" href="" target="_self">
                                                                {{ $service->name_service }}
                                                            </a>
                                                        </div>
                                                        <div class="cart-items__service-actions-wrapper">
                                                            <div class="cart-items__service-actions"><!--v-if--></div><!--v-if-->
                                                        </div><!--v-if-->
                                                    </div><!--v-if-->
                                                </div>
                                            </div>
                                        
                                            <div class="cart-items__service-count">
                                                <div class="count-buttons">
                                                    <input name = "count-buttons__input" class="count-buttons__input" value = "{{  $item->quantity }}" disabled> 
                                                </div>
                                            </div>
                                            <div class="cart-items__service-block-amount">
                                                <div class="cart-items__service-price">
                                                    <div class="price">
                                                        <div class="price__block price__block_main"><!--v-if-->
                                                            <span class="price__current">{{  $item->price * $item->quantity }} ₽</span>
                                                        </div><!--v-if-->
                                                    </div><!--v-if-->
                                                </div><!--v-if-->
                                            </div><!--v-if-->
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
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
                <span class="">Информация о заказе</span>
              </div>
              <div class="total-amount__profit-wrapper"><!--v-if--><!--v-if-->
                <div class="total-amount__logistic-section total-amount__row">
                    <div class="total-amount-toggler discount-logistic-toggler">
                        <div class="status-value__container">
                        <span class="status-date">Статус: </span> 
                          <div>
                            @if ($status->name_status == 'Оформлен'||$status->name_status == 'Принят'||$status->name_statuss == 'В работе')
                            <div class="status-value status-green">
                                <span id = "orders"  class="order-status">{{ $status->name_status }}</span>
                            </div> 
                            @elseif ($order->name_status == 'В обработке')
                            <div class="status-value status-orange">
                                <span id = "orders"  class="order-status">{{ $status->name_status }}</span>
                            </div>
                            @elseif ($order->name_status == 'Отклонён')
                            <div class="status-value status-red">
                                <span id = "orders"  class="order-status">{{ $status->name_status }}</span>
                            </div> 
                            @else
                            <div class="status-value status-grey" style ="background-color:#b1b3b1;">
                                <span id = "orders"  class="order-status">{{ $status->name_status }}</span>
                            </div> 
                            @endif
                        </div>
                      </div>
                      </div>
                      
                    <div class="total-amount-toggler discount-logistic-toggler">
                    <div class="status-value__container ">
                        <span class="status-date">Место выполнения: </span> 
                        <div>
                            <div class="status-value status-blue">
                                <span  class="order-status">{{ $sdm->name_sdm }}</span>
                            </div> 
                        </div>
                     </div>
                    </div>
                  <div class="total-amount-toggler discount-logistic-toggler">
                    <div class="status-value__container">
                        <span class="status-date">Дата создания: {{ $order->created_at }} </span> 
                     </div>
                    </div>
                <div class="total-amount-toggler discount-logistic-toggler">
                    <div class="status-value__container">
                        <span class="status-date">Дата изменения: {{ $order->updated_at }} </span> 
                     </div>
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
            </div>
            <div class="total-amount__notifications">
          </div>
        </div>
      </div>
    </div>
            </div>
        </div>
    </div>
</div>

@endsection