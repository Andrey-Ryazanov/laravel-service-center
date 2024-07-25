@extends('layouts.admin_layout')
@section('content')
<!-- Content Header (Page header) -->
 
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Добавление услуги в категорию</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class = "col-lg-12">
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
            <form method = "POST" action = "{{ route('c-service.store') }}" enctype ="multipart/form-data">
            @csrf
                <div class="card-body">
                    
                  <div class="form-group">
                    <label for="category_id">Категория</label>
                    <select id = "category_id" name = "category_id">
                        <option placeholder = "Выберите категорию"></option>
                        @foreach ($categories as $category) <!--Категория из категорий-->
                          <option value = "{{ $category->id_category  }}">{{ $category->title }} </option>
                          @if (count($category->subcategory))   <!--Если категория имеет хотя бы одну подкатегорию-->                
                            @include('admin.service.sub', ['subcategories' => $category->subcategory ]) <!--Включаем эту категорию в список категорий, имеющий потомков-->   
                          @endif
                        @endforeach
                  </select>
                  </div>
                    
                <div class="form-group">
                    <label for="service_id">Услуга</label>
                    <select id="service_id" name="service_id">
                        <option placeholder = "Выберите услугу"></option>
                        @foreach ($services as $service)
                            <option value="{{ $service->id_service }}" >{{ $service->name_service }}</option>
                        @endforeach
                    </select>
                </div>


                  <div class="form-group">
                    <label for="cost_service">Стоимость</label>
                    <input id = "cost_service" name = "cost_service" type="text" class="form-control" placeholder="Введите стоимость">
                  </div>
                  
                  <div data-filter-avails="" class="ui-list-controls ui-collapse ui-collapse_list">
                      <span class="ui-collapse__link-text ui-link ui-collapse__link_left ui-collapse__link ui-collapse__link_in" >Способ оказания услуги</span>
                      <div class="ui-collapse__content_default-in ui-collapse__content_list">
                        <div class="ui-list-controls__content ui-list-controls__content_custom left-filters__radio-list" style="">                    
                          <div id="stock" class="ui-checkbox-container">
                            @foreach ($sdms as $sdm)
                            <div class = "ui-checkbox-block">
                            <label class="ui-checkbox">
                              <span style = "font-weight:400;"> {{ $sdm->name_sdm }}</span>
                              <input  type="checkbox" class="ui-checkbox__input" id = "{{ $sdm->id_sdm }}" value="{{ $sdm->id_sdm }}" name="sdms[]">
                              <span class="ui-checkbox__box"></span>
                            </label>
                            <div data-rubric = "{{ $sdm->id_sdm }}" class = "during_container">
                            <label class = "during-label" for="durings">Срок выполнения</label>
                            <input name = "durings[]" class = "form-control-deadline" type="text">
                            <select name = "during_periods[]" class = "form-control-select">
                            @foreach ($periods as $period)
                                <option>{{ $period }}</option>
                            @endforeach
                            </select>
                            </div>
                            </div>
                            @endforeach
                          </div>
                        </div>
                      </div>
                  </div>

                  <div class="form-group">
                    <label for="main_image">Изображение</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="main_image" name="main_image">
                        <label class="custom-file-label" for="main_image">Добавить изображение</label>
                      </div>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary">Добавить</button>
              </form>   
        </div>
        </div>
                    </div>
      </div><!-- /.container-fluid -->


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
    
      @push('a-scripts')
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
    <script>
    $(document).ready(function () {
        $('#category_id').selectize({
            placeholder: 'Выберите категорию',
        });
        $('#service_id').selectize({
            placeholder: 'Выберите услугу',
        });
    });
    </script>
    @endpush