<?php 
/*use App\Http\Controllers\ServicesController;
$total = ServicesController::cartItem() */?>
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="container2">               
            <div class="subcategory">
                <h1 class="subcategory__page-title">Каталог</h1>
                <div class="subcategory__item-container ">
                    @foreach ($parentCategories as $category)    
                    <a class="subcategory__item ui-link ui-link_blue" href="{{ url('/catalog/'.$category->title) }}">					
                        <div class="subcategory__content">
						    <div class="subcategory__image"><picture><source type="image/webp" media="(max-width: 767px)" >
                                <picture>
                                    <source type="image/webp" media="(max-width: 767px)" >
                                    <source media="(max-width: 767px)">
                                    <img class="subcategory__image-content" alt="" src ="/uploads/categories/{{ $category->category_image }}">
                                </picture>
                            </div>
						    <span class="subcategory__title">{{ $category->title }}</span>
					    </div>
					    <input type="checkbox" id="{{ $category->title }}" class="subcategory__mobile-checkbox"/>
					    <label class="subcategory__mobile-title" for="Смартфоны">Ремонт компьютерных мышей</label>
					    <div class="subcategory__childs"></div>
					</a>
                    @endforeach
			    </div>
            </div>
        </div>
    </div>
</div>


@endsection
