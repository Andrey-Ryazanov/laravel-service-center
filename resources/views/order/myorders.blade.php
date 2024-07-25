@extends('layouts.app')
@section('content')    
  <section class="content">
  <div class = "container2">
    <div class ="orders-page">      
    <h1 class="orders__page-title">Заказы</h1>
      @if(!$orders->isEmpty() || count(request()->query())>0)
      <div class = "orders-page__content" style = "postion:relative;">
        <div class="orders-page__left-block">
          <div class="inner-wrapper-sticky" style="position: relative; transform: translate3d(0px, 0px, 0px);">
            <div class="products-page__filters-left-top" data-filters-search="">
              <div class="left-filters" data-role="filters-container">
                <div class="left-filters__list" data-role="filter-list">
                  <div class="nav-sidebar flex-column ui-list-controls ui-collapse ui-collapse_list" data-widget="treeview" role="menu" data-accordion="false">
                    <div class="nav-item ui-collapse__content_default-in ui-collapse__content_list">
                      <a href="#" class="nav-link" style = "border-bottom: 1px solid #eaeaea; font-weight: 700; font-size:16px;">
                            Статус
                          <i class="right fas fa-angle-left"></i>
                      </a>
                      <div class="nav-treeview ui-collapse__content_default-in ui-collapse__content_list">
                        <div class="ui-list-controls__content ui-list-controls__content_custom left-filters__radio-list" style="">
                          <div class="ui-checkbox-group ui-checkbox-group_filter">
                              @foreach ($statuses as $status)
                                <label class="ui-checkbox ui-checkbox_filter">
                                  <span>{{ $status->name_status }}</span>
                                  <input type="checkbox" class="ui-checkbox__input" value="{{ $status->id_status }}" data-check ="{{ $status->id_status }}">
                                <span class="ui-checkbox__box"></span>
                                </label>
                              @endforeach
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="nav-item ui-collapse__content_default-in ui-collapse__content_list">
                      <a href="#" class="nav-link" style = "border-bottom: 1px solid #eaeaea; font-weight: 700; font-size:16px;">
                            Дата
                          <i class="right fas fa-angle-left"></i>
                      </a>
                      <div class="nav-treeview ui-collapse__content_default-in ui-collapse__content_list">
                        <div class="ui-list-controls__content ui-list-controls__content_custom left-filters__radio-list" style="">
                        <div class="form-group">
                          <label for="inputDate">Начало:</label>
                          <input type="date" class="form-control" data-interval = "start">
                        </div>
                        <div class="form-group">
                          <label for="inputDate">Конец:</label>
                          <input type="date" class="form-control" data-interval = "end">
                        </div>
                        </div>
                      </div>
                    </div>
                  </div> 
                </div>
                <div class="left-filters__buttons">
                  <div class="left-filters__buttons-main">
                      <a href="{{ route('myorders') }}" type="submit" class="set_filter button-ui button-ui_blue left-filters__button">Применить</a>
                      <button class="reset_filter button-ui button-ui_white left-filters__button">Сбросить</button>
                  </div>   
              </div>          
              </div>
            </div>
          </div>
        </div>

        <div class="orders-page__list">
              <div  class="orders__container" >
                  <section class="order__list" data-widget="orderList">
                    @include('ajax.sortmyorders')       
                  </section>
              </div>
            </div> 
          </div>
        </div>
        @else 
        <div class="empty-message">
            <div class="empty-message__cart-image"></div>
            <div class="empty-message__text-wrapper">
                <div class="empty-message__title-empty-cart">У вас пока нет заказов</div>
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
  </div>
</section>
@endsection
@push('scripts')
    <script src="/js/work_with_order.js"></script>
@endpush