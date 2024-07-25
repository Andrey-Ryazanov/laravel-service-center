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