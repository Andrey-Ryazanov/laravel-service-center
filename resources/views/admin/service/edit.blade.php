@extends('layouts.admin_layout')
@section('content')
 <!-- Content Header (Page header) -->
 <meta name="csrf-token" content="{{ csrf_token() }}">
 <div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-9">
        <h1 class="m-0">Редактирование услуги: {{ $service['name_service'] }} </h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
    <!-- /.content-header -->

    <!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class = "col-lg-12">
      <div class="card card-primary">
      @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
      @elseif (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
      @endif
        <form method = "POST" action = "{{ route('service.update',$service['id_service']) }}" enctype ="multipart/form-data">
        @csrf
        @method('PUT')
          <div class="card-body">
            <div class="form-group">
              <label for="name_service">Название</label>
              <input id = "name_service" name = "name_service" type="text" class="form-control" value = "{{ $service['name_service'] }}">
            </div>

            <div class="form-group">
              <label for="description_service">Описание</label>
                <textarea id = "description_service" name = "description_service" type="text" class="form-control" value = "{{ $service['description_service'] }}">{{ $service['description_service'] }}</textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Обновить</button>
        </form>   
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
   
 

/*$(document).ready(function (){  
      var blocks = $('[data-rubric]');
      $('.ui-checkbox-container :checkbox').click(function() {
      var value = $(this).attr('id');
      var checkbox = $('.ui-checkbox-container :checkbox:checked').length;
      
        if (checkbox >= 1){
          if($(this).prop('checked')) {
            block = $('[data-rubric='+ value +']');
            block.show();

            check = $(this).find('.ui-checkbox__input').attr("id", value);
            input = block.find('.form-control-deadline').attr("id", value);
            if (input.attr('id',check.attr('id')))
            {
              if (check.checked){
                input.attr("required", "true");
              }
              if (check.unchecked){
                input.attr("required","false");
              }

              if (input.val() != ""){
                check.prop('checked', true);
              }
            } 

          }
          else {
            block = $('[data-rubric='+ value +']');
            input = block.find('.form-control-deadline').attr("id", value);
            input.val('');
            block.hide();
          }
        }
        if (checkbox == 0) {
          block = $('[data-rubric='+ value +']');
          block.hide();
        }
      });
}); */
</script>

    @endsection
