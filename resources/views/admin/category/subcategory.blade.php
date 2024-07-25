@extends('layouts.admin_layout')
@section('content')
 <!-- Content Header (Page header) -->
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">{{ $category->title }}</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          <div class = "col-lg-12">
          @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
          @elseif (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
          @endif
            <div class="row">
            <div class="col-12">
                <form method = "GET" action = "{{ route('category.smartexport') }}" enctype ="multipart/form-data">
                @csrf
                <button style = "float:right" class ="btn btn-success" name = "parent_id" value ="{{ $category->id_category }}">Экспорт</button>
                </form>
                <div class="form-inline mb-3">
                    <input type="text" name="search" class="form-control mr-sm-2 search" placeholder="Поиск">
                    <a href='{{ route('subcategory.index',$category->title) }}' type="submit" class="btn btn-primary btn-search">Искать</a>
                </div>
            </div>
        </div>
        @if (count($category->subcategory)>0)  
        <div class ="table_categories">
            @include('ajax.admin.categories.subcategory')
        </div>
          @else
          <div class ="table_category_services">
            @include('ajax.admin.category_services.index')
        </div>
        @endif
</div>
        </div>
      </div>
    </section>
    @endsection

    
@push('a-scripts')
@if (count($category->subcategory)>0)
    <script>
      $(document).on('click', '.pagination a, .btn-search', function() {
    //get url and make final url for ajax 
    let url = $(this).attr("href");
    let searchValue = $('.search').val();// добавляем эту строку
    let search;
    let append = "";
    if (searchValue == null || searchValue == undefined || searchValue == "") {
      search = "";
    } 
    else {
        search = "search=" + searchValue;
        append = url.indexOf("?") == -1 ? "?" : "&";
    }
    
    let newURL = url + append + search; // изменяем эту строку
        
    //set to current url
   window.history.pushState({ url: newURL }, null, newURL);
    
    $.get(newURL, function(data) {
      $(".table_categories").html(data);
    });

    return false;
  });
  
  $('.search').keyup(function(e) {
  if (e.keyCode == 13) { // если нажата клавиша enter
    search();
  }
});
  
  function search() {
  //get url and make final url for ajax 
  let url = $('.pagination .active').attr('href') || $('.btn-search').attr('href'); // изменяем эту строку, чтобы получить url из активной кнопки .pagination или .btn-search
  let searchValue = $('.search').val();
  let search;
  let append = "";
  if (searchValue == null || searchValue == undefined || searchValue == "") {
    search = "";
  } else {
      search = "search=" + searchValue;
      append = url.indexOf("?") == -1 ? "?" : "&";
  }
  
  let newURL = url + append + search;

  //set to current url
  window.history.pushState({ url: newURL }, null, newURL);
  
  $.get(newURL, function(data) {
    $(".table_categories").html(data);
  });

  return false;
}
  
$(window).on('popstate', function() {
  $('.search').val('');
  let url = window.location.href;
  let urlParams = new URLSearchParams(window.location.search);
  let searchValue = urlParams.get('search');
  let newURL = url;
  
  if (searchValue) {
    $('.search').val(searchValue);
  }
  
  $.get(newURL, function(data) {
    $('.table_categories').html(data);
  });
});
  
</script>
@else
    <script>
      $(document).on('click', '.pagination a, .btn-search', function() {
    //get url and make final url for ajax 
    let url = $(this).attr("href");
    let searchValue = $('.search').val();// добавляем эту строку
    let search;
    let append = "";
    if (searchValue == null || searchValue == undefined || searchValue == "") {
      search = "";
    } 
    else {
        search = "search=" + searchValue;
        append = url.indexOf("?") == -1 ? "?" : "&";
    }
    
    let newURL = url + append + search; // изменяем эту строку
        
    //set to current url
   window.history.pushState({ url: newURL }, null, newURL);
    
    $.get(newURL, function(data) {
      $(".table_category_services").html(data);
    });

    return false;
  });
  
  $('.search').keyup(function(e) {
  if (e.keyCode == 13) { // если нажата клавиша enter
    search();
  }
});
  
  function search() {
  //get url and make final url for ajax 
  let url = $('.pagination .active').attr('href') || $('.btn-search').attr('href'); // изменяем эту строку, чтобы получить url из активной кнопки .pagination или .btn-search
  let searchValue = $('.search').val();
  let search;
  let append = "";
  if (searchValue == null || searchValue == undefined || searchValue == "") {
    search = "";
  } else {
      search = "search=" + searchValue;
      append = url.indexOf("?") == -1 ? "?" : "&";
  }
  
  let newURL = url + append + search;

  //set to current url
  window.history.pushState({ url: newURL }, null, newURL);
  
  $.get(newURL, function(data) {
    $(".table_category_services").html(data);
  });

  return false;
}
  
$(window).on('popstate', function() {
  $('.search').val('');
  let url = window.location.href;
  let urlParams = new URLSearchParams(window.location.search);
  let searchValue = urlParams.get('search');
  let newURL = url;
  
  if (searchValue) {
    $('.search').val(searchValue);
  }
  
  $.get(newURL, function(data) {
    $('.table_category_services').html(data);
  });
});
  
</script>
@endif
@endpush