@extends('layouts.admin_layout')
@section('content') 
<div class="content-header">
  <div class="container-fluid d-flex align-items-center justify-content-between">
    <div class="ml-4">
      <h1 class="m-0">Детали заказа № {{ $order->id_order }} (код заказа: {{ $order->code }})</h1>
    </div><!-- /.col -->
    <div class="mr-4 text-right">
      <a href = "{{ route('orders.edit', $order->id_order) }}"class="btn btn-success">Добавить позицию</a>
    </div><!-- /.col -->
  </div><!-- /.row -->
</div><!-- /.container-fluid -->



    <div class="order-tab-content">
        <div class = "order-left-block">
        @if (empty($order->comment) === false)
            <div class="order-tab-comment">
            <div class="total-amount__content">
              <div class="total-amount__title total-amount__title_bottom-border">
                <span class="">Комментарий</span>
              </div>
                <div class="total-amount__profit-wrapper"><!--v-if--><!--v-if-->
                    <div class="total-amount__logistic-section total-amount__row">
                        <div class="total-amount-toggler discount-logistic-toggler">
                            <div class="status-value__container">
                                <span class="status-date">{{ $order->comment }} </span> 
                             </div>
                        </div>
                    </div>
                </div>
                <div class="total-amount__summary-section">
                </div>
            </div>
        <div class="total-amount__notifications"></div>
        </div>
        @endif
        <div class="order-tab-services-list">
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
                                                <div class="menu-service cart-items__menu-service menu-service_enabled-service">
                                                    <div class="menu-service-standard-view">
                                                      <div class="menu-service-dots"></div>
                                                      <div class="menu-service-wrapper" style="">
                                                        <button class="menu-control-button remove-button">
                                                          <p class="remove-button__title">Удалить</p>
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
                                        <input name = "count-buttons__input" class="count-buttons__input" value = "{{  $item->quantity }}"> 
                                        <input name = "service_id" type = "hidden" class="service_id" value = "{{ $service->id_category_service }}">
                                        <input name = "cost" type = "hidden" class="cost_service" value = "{{ $service->cost_service }}">
                                        <input name = "order_id" type = "hidden" class="order_id" value = "{{ $item->order_id }}">
                                         <button class="count-buttons__button count-buttons__button_plus">
                                           <i class="count-buttons__icon fa fa-plus-square"></i>
                                         </button>
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
        </div>
                <div class ="order-information__container">
            <div class="order-tab-total-amount">
            <div class="total-amount__content">
              <div class="total-amount__title total-amount__title_bottom-border">
                <span class="">О заказе</span>
              </div>
                <div class="total-amount__profit-wrapper"><!--v-if--><!--v-if-->
                    <div class="total-amount__logistic-section total-amount__row">
                        <div class="total-amount-toggler discount-logistic-toggler">
                            <div class="status-value__container">
                                <span class="status-date">Заказ создан: {{ $order->created }} </span> 
                             </div>
                        </div>
                        <div class="total-amount-toggler discount-logistic-toggler">
                            <div class="status-value__container">
                                <span class="status-date">Заказ изменён: {{ $order->updated }} </span> 
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
        <div class="total-amount__notifications"></div>
        </div>
                <div class="order-tab-total-amount">
            <div class="total-amount__content">
              <div class="total-amount__title total-amount__title_bottom-border">
                <span class="">О сроке выполнения</span>
              </div>
                <div class="total-amount__profit-wrapper"><!--v-if--><!--v-if-->
                    <div class="total-amount__logistic-section total-amount__row">
                        <div class="total-amount-toggler discount-logistic-toggler">
                            <div class ="form-column deadline__container">
                                <div class="status-value__container ">
                                    <input name = "order_id" type = "hidden" class="order_id" value = "{{ $order->id_order }}">
                                   <span class="status-date">Начало: </span> 
                                  <input type="datetime-local" class="form-control deadline" id = "start" @if (isset($order->start_date)) value = "{{ $order->start_date  }}" readonly @endif>
                                </div>
                                <div class="status-value__container ">
                                  <span class="status-date">Конец: </span> 
                                  <input type="datetime-local" class="form-control deadline" id = "end" @if (isset($order->end_date_plan)) value = "{{ $order->end_date_plan  }}" readonly @endif>
                                </div>
                                @if (empty($order->start_date) && empty($order->end_date))
                                <a class ="mr-4 mt-3 btn btn-primary deadline_install"> Сохранить </a>
                                <a class ="ml-4 mt-3 btn btn-primary deadline_calculate"> Рассчитать </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="total-amount__summary-section">
                </div>
            </div>
        </div>
            <div class="order-tab-total-amount">
            <div class="total-amount__content">
              <div class="total-amount__title total-amount__title_bottom-border">
                <span class="">О способе оказания</span>
              </div>
                <div class="total-amount__profit-wrapper"><!--v-if--><!--v-if-->
                    <div class="total-amount__logistic-section" style = "padding:13px;">
                  <div class="total-amount-toggler discount-logistic-toggler">
                    <div class="status-value__container ">
                        <span class="status-date">Способ оказания:  </span> 
                        <div class="status-value status-blue">
                            <span  class="order-status">{{ $order->name_sdm }}</span>
                        </div> 
                     </div>
                    </div>
                        <div class="total-amount-toggler discount-logistic-toggler">
                            <div class="status-value__container">
                                <span class="status-date">Адрес: @if (isset($order->address)) {{ $order->address }} @else г.Воронеж, Димитрова, 64А @endif </span> 
                             </div>
                        </div>
                    </div>
                </div>
                <div class="total-amount__summary-section">
                </div>
            </div>
        <div class="total-amount__notifications"></div>
        </div>
        <div class="order-tab-total-amount">
            <div class="total-amount__content">
              <div class="total-amount__title total-amount__title_bottom-border">
                <span class="">О статусе</span>
              </div>
                <div class="total-amount__profit-wrapper"><!--v-if--><!--v-if-->
                    <div class="total-amount__logistic-section total-amount__row">
                      <div class="total-amount-toggler discount-logistic-toggler">
                            <div class="status-value__container">
                                <span class="status-date">Статус: </span> 
                                <input name = "order_id" type = "hidden" class="order_id" value = "{{ $order->id_order }}">
                                <select name="status_id" class="form-control order-select-status">
                                    @foreach ($statuses as $status)
                                        <option @if ($status->id_status == $order->id_status) selected @endif value="{{ $status->id_status }}" label="{{ $status->name_status }}"></option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="total-amount-toggler discount-logistic-toggler">
                            <div class="status-value__container">
                                <span class="status-date">Статус изменён: {{ $order->status_created }} </span> 
                             </div>
                        </div>
                    </div>
                </div>
                <div class="total-amount__summary-section">
                </div>
            </div>
        <div class="total-amount__notifications"></div>
        </div>
        <div class="order-tab-total-amount">
            <div class="total-amount__content">
              <div class="total-amount__title total-amount__title_bottom-border">
                <span class="">О заказчике</span>
              </div>
                <div class="total-amount__profit-wrapper"><!--v-if--><!--v-if-->
                    <div class="total-amount__logistic-section total-amount__row">
                        <div class="total-amount-toggler discount-logistic-toggler">
                            <div class="status-value__container">
                                <span class="status-date">Логин: {{ $order->login }} </span> 
                             </div>
                        </div>
                        <div class="total-amount-toggler discount-logistic-toggler">
                            <div class="status-value__container">
                                <span class="status-date">ФИО: @if ((isset($order->surname)) || (isset($order->name)) || (isset($order->patronymic))) {{ $order->surname.' '.$order->name.' '.$order->patronymic  }} @else не указано @endif </span> 
                             </div>
                        </div>
                        <div class="total-amount-toggler discount-logistic-toggler">
                            <div class="status-value__container">
                                <span class="status-date">Эл.почта: {{ $order->email }} </span> 
                             </div>
                        </div>
                        <div class="total-amount-toggler discount-logistic-toggler">
                            <div class="status-value__container">
                                <span class="status-date">Телефон: {{ $order->phone }} </span> 
                             </div>
                        </div>
                    </div>
                </div>
                <div class="total-amount__summary-section">
                  <div class="price-summary summary">
 
                  </div>
                </div>
            </div>
        <div class="total-amount__notifications"></div>
        </div>
        </div>
    </div>


@endsection

@push('a-scripts')
    <script src="/js/admin/work_with_order.js"></script>
@endpush