@if (!($services->isEmpty()))
        @foreach ($services as $service)
            <div class="catalog-services view-simple">
                <div class="catalog-service ui-button-widget">
                    <div class="catalog-service__image" >
                        <a class="catalog-service__image-link" href="" >
                            <img src = "{{ asset('uploads/services/'.$service['main_image'])}}" >
                        </a>
                    </div>
                    <a class="catalog-service__name ui-link ui-link_black" href="">
                        <span><b>{{ $service->name_service }}</b></span><br>
                        <span>{{ $service->description_service }}</span>
                    </a>
                    <div class="catalog-service__stat" >      
                        <span style = "font-size:20px;">{{ $service->cost_service }} ₽</span>
                    </div>   
                    <div>
                        <input type ="hidden" name ="quantity" value = "1" class ="quantity">
                        <input type ="hidden" name ="category_service_id" class = "category_service_id" value = "{{ $service->category_service_id }}"/>
                        <button class="button-ui buy-btn button-ui_blue button-ui_passive">В корзину</button>
                    </div>
                </div>
            </div>
        @endforeach
    @else
    <div class="empty-message">
        <div class="empty-message__service__filter-image"></div>
        <div class="empty-message__text-wrapper">
            <div class="empty-message__title-empty-cart">К сожалению, таких услуг нет</div>
            <p class="empty-message__text">В настоящее время мы не оказываем такие услуги</p>
            <button class="reset_filter base-ui-button-v2_medium base-ui-button-v2_brand base-ui-button-v2_ico-none base-ui-button-v2 empty-button">
                <span class="base-ui-button-v2__text">Сбросить фильтр</span><!--v-if-->
            </button>
        </div>
    </div>
    @endif