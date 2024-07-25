@extends('layouts.admin_layout')
@section('content')
<!-- Content Header (Page header) -->
 
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Добавление услуги в заказ № {{ $order->id_order }}</h1>
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
            <form method = "POST" action = "{{ route('addOrderItem') }}" enctype ="multipart/form-data">
            @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="category_id">Категория</label>
                    <select id = "category_id" name = "category_id" class="form-control custom-select" data-tags="true" required>
                        <option selected disabled>Выберите категорию</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id_category }}">{{ $category->title }}</option>
                        @endforeach
                  </select>
                  </div>
                    
                <div class="form-group">
                    <label for="name_service">Услуга</label>
                    <select id="service_id" name="service_id" class="form-control custom-select" required>
                        <option selected disabled>Выберите услугу</option>
                        @foreach ($services as $service)
                            <option value="{{ $service->id_service }}">{{ $service->name_service }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="d-flex">
                    <div class="form-group mr-4">
                        <label for="cost1">Стоимость</label>
                        
                        <div data-id="q">
                            <div class="ui-input-cost left-top-filters-search-input ui-input-search_catalog-filter" style="width: 100px;">
                                <input id = "cost" name = "cost" class="ui-input-cost__input ui-input-search__input_catalog-filter" required>
                                <div class="ui-input-search__buttons">
                                    <span class="ui-input-cost__icon ui-input-search__icon_cost ui-input-search__icon_catalog-filter"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mr-4">
                        <label for="name_service">Количество</label>
                        <div class="cart-items__service-count">
                            <div class="count-buttons">
                            <button type = "button" class="count-buttons__button count-buttons__button_minus" >
                                <i class="count-buttons__icon fa fa-minus-square"></i>
                            </button>
                                <input name = "quantity" class="count-buttons__input" value = "1" required> 
                                <input name = "order_id" type = "hidden" class="order_id" value = "{{ $order->id_order }}">
                                <button  type = "button"  class="count-buttons__button count-buttons__button_plus">
                                    <i class="count-buttons__icon fa fa-plus-square"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price">Итого</label>
                        <div data-id="q">
                            <div class="ui-input-cost left-top-filters-search-input ui-input-search_catalog-filter" style="width: 100px;">
                                <input id = "price" name ="price" class="ui-input-cost__input ui-input-search__input_catalog-filter" required>
                                <div class="ui-input-search__buttons">
                                    <span class="ui-input-cost__icon ui-input-search__icon_cost ui-input-search__icon_catalog-filter"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                  <button type="submit" class="btn btn-primary">Добавить</button>
              </form>   
        </div>
        </div>
                    </div>
      </div><!-- /.container-fluid -->
    @endsection
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#category_id').change(function() {
            var category_id = $(this).val();
            if(category_id) {
                $.ajax({
                    url: '{{ url('/administration/get-services-by-category') }}/'+category_id,
                    type: 'GET',
                    dataType: 'json',
                    success:function(data) {
                        $('#service_id').empty();
                        $('#service_id').append('<option selected disabled>Выберите услугу</option>');
                        $.each(data, function(key, value) {
                            $('#service_id').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('#service_id').empty();
                $('#service_id').append('<option selected disabled>Выберите услугу</option>');
            }
        });
    });
    $(document).ready(function(){
    // функция для отправки ajax запроса
    function calculateCost() {
        var category_id = $('#category_id').val();
        var service_id = $('#service_id').val();
        if (category_id && service_id){
            $.ajax({
            url: '{{ url('/administration/calculate-cost') }}',
            type: 'GET',
            data: {
                category_id: category_id,
                service_id: service_id
            },
            success: function (response) {
                $('#cost').val(parseInt(response.cost))
                $('#price').val($('.count-buttons__input').val() * $('#cost').val());
            }
            });
        }
    }

    // обработчик изменения значений select'ов
    $('#category_id, #service_id').change(function () {
        calculateCost();
    });
});
    
     $(document).ready(function() {
    $('#category_id').select2();
  });
</script>

@push('a-scripts')
    <script src="/js/admin/work_with_edit_order.js"></script>
@endpush