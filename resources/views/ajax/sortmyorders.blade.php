@if (!($orders->isEmpty()))
    @foreach ($orders as $order)
    <div class="order__container">
        <div class="order-header__container">
            <div class="order-header">
                <div class="order-datenumber__container">
                    <div class="order-date__container">
                    <span class="order-date">Заказ от {{ $order->start }}</span>
                    </div>
                    <div class="order-number__container">
                        <a href="{{ url('my/orderdetails/'.$order->code) }}" class="order-number">№ {{ $order->code }}</a>
                    </div>
                </div>
                <div class="order-price__container">
                    <div class="order-price-header">
                    <span class="order-text-price">стоимость </span>
                    <span class="order-price">
                        {{ $order->total }} ₽
                    </span>
                    </div>
                </div>
                </div>
            </div> 
            <div class="order-info__container">
                <div class="status__container">
                    <div class="status-header">
                        <div class="status-value__container">
                        <span class="status-text">Статус заказа: </span> 
                        <div>
                            @if ($order->name_status == 'Оформлен'||$order->name_status == 'Принят'||$order->name_status == 'В работе')
                            <div class="status-value status-green">
                                <span id = "orders"  class="order-status">{{ $order->name_status }}</span>
                            </div> 
                            @elseif ($order->name_status == 'В обработке')
                            <div class="status-value status-orange">
                                <span id = "orders"  class="order-status">{{ $order->name_status }}</span>
                            </div>
                            @elseif ($order->name_status == 'Отклонён')
                            <div class="status-value status-red">
                                <span id = "orders"  class="order-status">{{ $order->name_status }}</span>
                            </div> 
                            @else
                            <div class="status-value status-grey" style ="background-color:#b1b3b1;">
                                <span id = "orders"  class="order-status">{{ $order->name_status }}</span>
                            </div> 
                            @endif
                        </div>
                        </div> 
                        <div class="g5f">
                            <div class="fg6">
                                @if ($order->name_status == 'Завершён')
                                    <p class="fg7" style="color:#B1B9C2;">Дата выполнения заказа: {{ $order->end }}</p> 
                                @else
                                <p class="fg7" style="color:#B1B9C2;">Дата изменения заказа: {{ $order->end }}</p> 
                                @endif
                            </div>
                        </div>
                    </div> 
                    <div class="fg8">
                    </div>
                </div>
            </div> 
        </div>
    @endforeach
@else
    <div class="empty-message">
    <div class="empty-message__cart-image"></div>
    <div class="empty-message__text-wrapper">
        <div class="empty-message__title-empty-cart">Заказов с выбранными фильтрами нет</div>
        <p class="empty-message__text">Добавьте услуги в корзину и возвращайтесь!</p>
        <a href = "/services">
        <button class="base-ui-button-v2_medium base-ui-button-v2_brand base-ui-button-v2_ico-none base-ui-button-v2 buy-button" loading="false" id="buy-btn-main">
            <span class="base-ui-button-v2__text">Перейти в каталог услуг</span>
        </button>
        </a>
    </div>
    </div>
@endif
<div class="container">
    <div class="d-flex justify-content-center mt-3">
    {{ $orders->links() }}
    </div>
</div>