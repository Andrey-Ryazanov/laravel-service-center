@extends('layouts.admin_layout')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Информация о пользователях</h1>
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
                <a href = "{{ route('usAbout.create') }}" style = "float:right;" class="btn btn-success">Создать</a>
                <div class="form-inline mb-3">
                    <input type="text" name="search" class="form-control mr-sm-2 search" placeholder="Поиск">
                    <a href='{{ route('usAbout.index') }}' type="submit" class="btn btn-primary btn-search">Искать</a>
                </div>
            </div>
        </div>
        <div class = "table_users">
            @include('ajax.admin.users.index')
        </div>
        </div>
    </div>
</section>
    @endsection
    
    @push('a-scripts')
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
    
    let finalURL = url + append + search; // изменяем эту строку
        
    //set to current url
   window.history.pushState({ url: finalURL }, null, finalURL);
    
    $.get(finalURL, function(data) {
      $(".table_users").html(data);
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
  
  let finalURL = url + append + search;

  //set to current url
  window.history.pushState({ url: finalURL }, null, finalURL);
  
  $.get(finalURL, function(data) {
    $(".table_users").html(data);
  });

  return false;
}
  
$(window).on('popstate', function() {
  $('.search').val('');
  let url = window.location.href;
  let urlParams = new URLSearchParams(window.location.search);
  let searchValue = urlParams.get('search');
  let finalURL = url;
  
  if (searchValue) {
    $('.search').val(searchValue);
  }
  
  $.get(finalURL, function(data) {
    $('.table_users').html(data);
  });
});
  
    </script>
    @endpush