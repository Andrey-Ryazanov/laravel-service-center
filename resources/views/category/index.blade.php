<?php 
/*use App\Http\Controllers\ServicesController;
$total = ServicesController::cartItem() */?>
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">     
        <div class="container2">
            <ol class="breadcrumb-list" itemscope="http://schema.org/BreadcrumbList">
                <li class="breadcrumb-list__item">																	
                    <a class="ui-link ui-link_black" href="/catalog/" >
                        <span>Каталог</span>
                    </a>
                </li>
                @if(count($category->parents))
                    @foreach ($category->parents as $item)
                    <li class="breadcrumb-list__item">																	
                        <a class="ui-link ui-link_black" href="{{ url('/catalog/'.$item->title) }}" >
                            <span>{{ $item->title }} </span>
                        </a>
                    </li>
                    @endforeach
                @endif
                <li class="breadcrumb-list__item">
                        <a class="ui-link ui-link_black" href="{{ url('/catalog/'.$category->title) }}">
                            <span>{{ $category->title }}</span>
                        </a>
                </li>
	        </ol>

            @if (count($category->subcategory)==0 && !($services->isEmpty()) || request()->query() && !request()->query('page'))
            <div class ="services-page">
                <h1 class="subcategory__page-title">{{ $category->title }}</h1>           
                <div class = "services-page__content" style = "postion:relative;">  
                    <div class="products-page__left-block">
                        <div class="inner-wrapper-sticky" style="position: relative; transform: translate3d(0px, 0px, 0px);">
                            <div class="products-page__filters-left-top">
                                <div data-id="q">
                                    <div class="ui-input-search left-top-filters-search-input ui-input-search_catalog-filter">
                                        <input class="ui-input-search__input ui-input-search__input_catalog-filter" placeholder="Поиск по категории">
                                        <div class="ui-input-search__buttons">
                                            <span class="ui-input-search__icon ui-input-search__icon_clear ui-input-search__icon_catalog-filter"></span>
                                            <span class="ui-input-search__icon ui-input-search__icon_search ui-input-search__icon_catalog-filter"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="left-filters" data-role="filters-container">
                                <div class="left-filters__list" data-role="filter-list">
                                    <div class="nav-sidebar flex-column ui-list-controls ui-collapse ui-collapse_list" data-widget="treeview" role="menu" data-accordion="false">
                                        <div class="nav-item ui-collapse__content_default-in ui-collapse__content_list">
                                        <a href="#" class="nav-link" style = "border-bottom: 1px solid #eaeaea; font-weight: 700; font-size:16px;">
                                                Способ оказания услуги
                                            <i class="right fas fa-angle-left"></i>
                                        </a>
                                        <div class="nav-treeview ui-collapse__content_default-in ui-collapse__content_list">
                                            <div class="ui-list-controls__content ui-list-controls__content_custom left-filters__radio-list" style="">
                                                <div class="ui-checkbox-group ui-checkbox-group_filter">
                                                @foreach ($sdms as $sdm)
                                                <label class="ui-checkbox ui-checkbox_filter">
                                                    <span>{{ $sdm->name_sdm }}</span>
                                                    <input type="checkbox" class="ui-checkbox__input" value="{{ $sdm->id_sdm }}" data-sdm ="{{ $sdm->id_sdm }}">
                                                    <span class="ui-checkbox__box"></span>
                                                </label>
                                                @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="left-filters__buttons">
                                    <div class="left-filters__buttons-main">
                                        <button class="set_filter button-ui button-ui_blue left-filters__button">Применить</button>
                                        <button class="reset_filter button-ui button-ui_white left-filters__button">Сбросить</button>
                                    </div>   
                                </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="services-page__list">  
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    @elseif (count($category->subcategory)==0 && !request()->query())
    <div class="empty-message">
        <div class="empty-message__service-image"></div>
        <div class="empty-message__text-wrapper">
            <div class="empty-message__title-empty-cart">Страница редактируется</div>
            <p class="empty-message__text">В данный момент услуг нет, зайдите чуть позже</p>
            <a href = "/catalog">
                <button class="base-ui-button-v2_medium base-ui-button-v2_brand base-ui-button-v2_ico-none base-ui-button-v2 buy-button" loading="false" id="buy-btn-main">
                    <span class="base-ui-button-v2__text">Перейти в каталог услуг</span><!--v-if-->
                </button>
            </a>
        </div>
    </div>
    @endif

    @if (count($category->subcategory)>0)      
        <div class="subcategory">
            <h1 class="subcategory__page-title">{{ $category->title }}</h1>
            <div class="subcategory__item-container ">                            
            @foreach ($subcategories as $sub) 
                <a class="subcategory__item ui-link ui-link_blue" href="{{ url('/catalog/'.$sub->title) }}">					
                    <div class="subcategory__content">
                        <div class="subcategory__image">
                            <picture>
                                <source type="image/webp" media="(max-width: 767px)" >
                                <source media="(max-width: 767px)">
                                <img class="subcategory__image-content" alt="" src ="/uploads/categories/{{ $sub->category_image }}">
                            </picture>
                        </div>
                        <span class="subcategory__title">{{ $sub->title }}</span>
                    </div>
                    <input type="checkbox"  class="subcategory__mobile-checkbox"/>
                </a>
            @endforeach
            </div>
        </div>
         <div class="container">
            <div class="d-flex justify-content-center mt-3">
            {{ $subcategories->links() }}
            </div>
        </div>
        @endif
        </div>
    </div>
</div>

@endsection


@push('scripts')
     <script src="/js/work_with_category.js"></script>
@endpush

