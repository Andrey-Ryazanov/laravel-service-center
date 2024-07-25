@extends('layouts.admin_layout')
@section('content')
<!-- Content Header (Page header) -->
 
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Добавление услуги</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

<div class = "col-lg-12">
            <!-- Main content -->
    <section class="content">
             <div class="container-fluid">
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
            <form method = "POST" action = "{{ route('service.store') }}" enctype ="multipart/form-data">
            @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="name_service">Название</label>
                    <input id = "name_service" name = "name_service" type="text" class="form-control" placeholder="Введите название">
                  </div>

                  <div class="form-group">
                    <label for="description_service">Описание</label>
                    <input id = "description_service" name = "description_service" type="text" class="form-control" placeholder="Введите описание">
                  </div>

                  <button type="submit" class="btn btn-primary">Добавить</button>
              </form>   
        </div>
        </div>
        </div>
        </section>
    </div>

      </div><!-- /.container-fluid -->
    </section>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    $(document).ready(function (){  
      var blocks = $('[data-rubric]');
      blocks.hide();
      $('.ui-checkbox-container :checkbox').click(function() {
      var value = $(this).attr('id');
      var checkbox = $('.ui-checkbox-container :checkbox:checked').length;
      console.log(value);
        if (checkbox >= 1){
          if($(this).prop('checked')) {
            block = $('[data-rubric='+ value +']');
            block.show()
          }
          else {
            block = $('[data-rubric='+ value +']');
            block.hide()
          }
        }
        if (checkbox == 0) {
          block = $('[data-rubric='+ value +']');
          block.hide();
        }
      });
    });
</script>
    @endsection