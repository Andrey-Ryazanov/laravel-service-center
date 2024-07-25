@extends('layouts.admin_layout')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Все заказы</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
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
<form data-filter = "filter" action = "{{ route('orders.index') }}" method = "GET">
  <div class ="card card-primary">
    <div class="card-body">
        <div class="col-12">
            <div class="form-inline mb-3">
                <div class="form-column mr-3">
                    <label  style = "justify-content: flex-start;" for="id">Номер заказа:</label>
                    <input type="text" name="id" class="form-control" placeholder="Номер заказа" @if(isset($_GET['id'])) value="{{$_GET['id']}}" @endif>
                </div>
                <div class="form-column mr-3">
                    <label  style = "justify-content: flex-start;" for="code">Код заказа:</label>
                    <input type="text" name="code"  class="form-control" placeholder="Код заказа" @if(isset($_GET['code'])) value="{{$_GET['code']}}" @endif>
                </div>
                <div class="form-column mr-3">
                    <label style = "justify-content: flex-start;" for="user">Заказчик:</label>
                    <input type="text" name="user"   class="form-control" placeholder="Заказчик" @if(isset($_GET['user'])) value="{{$_GET['user']}}" @endif>
                </div>
                <div class="form-column mr-3">
                    <label style = "justify-content: flex-start;"  for="total">Стоимость заказа:</label>
                    <input type="text" name="total"  class="form-control " placeholder="Стоимость" @if(isset($_GET['total'])) value="{{$_GET['total']}}" @endif>
                </div>
                <div class="form-column">
                    <label  style = "justify-content: flex-start;" for="status">Статус заказа: </label>
                    <select type="text" name="status"  class="form-control">
                        <option selected>Все</option>
                        @foreach ($statuses as $status)
                        <option value = "{{ $status->id_status }}" @if(isset($_GET['status'])) @if($_GET['status'] == $status->id_status) selected @endif @endif>{{ $status->name_status }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-inline mb-3">
                  <div class="form-column mr-3">
                    <label  style = "justify-content: flex-start;" for="status">Место выполнения: </label>
                    <select type="text" name="sdm"  class="form-control">
                        <option selected>Все</option>
                        @foreach ($sdms as $sdm)
                        <option value = "{{ $sdm->id_sdm }}" @if(isset($_GET['sdm'])) @if($_GET['sdm'] == $sdm->id_sdm) selected @endif @endif>{{ $sdm->name_sdm }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-column mr-3">
                    <label style = "justify-content: flex-start;" for="inputDate">Дата создания:</label>
                    <input name = "created_at" type="date" class="form-control  " data-interval = "c-start" @if(isset($_GET['created_at'])) value="{{$_GET['created_at']}}" @endif>
                </div>
                <div class="form-column mr-3">
                    <label style = "justify-content: flex-start;" for="inputDate">Дата обновления:</label>
                    <input name = "updated_at" type="date" class="form-control " data-interval = "c-end" @if(isset($_GET['updated_at'])) value="{{$_GET['updated_at']}}" @endif>
                </div>
                <div class="form-column mr-3">
                    <label style = "justify-content: flex-start;" for="inputDate">Дата создания c:</label>
                    <input name = "start" type="date" class="form-control  " data-interval = "start" @if(isset($_GET['start'])) value="{{$_GET['start']}}" @endif>
                </div>
                <div class="form-column mr-3">
                    <label style = "justify-content: flex-start;" for="inputDate">Дата создания по:</label>
                    <input name = "end" type="date" class="form-control " data-interval = "end" @if(isset($_GET['end'])) value="{{$_GET['end']}}" @endif>
                </div>
            </div>
        </div>
        <div style = "float:right">
            <button class="btn btn-primary mr-3 clear" type="button">Очистить</button>
            <button class="btn btn-primary">Применить</button> 
        </div>
    </div>
</div>  
</form>      
    <div class = "table_orders">
        @include('ajax.admin.orders.index')
    </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
@endsection

@push('a-scripts')
<script>
    $(document).ready(function() {
        $("form[data-filter]").submit(function(event) {
          event.preventDefault(); // отменяем стандартное действие формы - отправку данных на сервер
        
          const formData = new FormData(this); // получаем данные формы
        
          const searchParams = new URLSearchParams(); // создаем объект для параметров запроса
        
          for (const [name, value] of formData.entries()) {
            if (value.trim() !== '') { // проверяем значение поля на пустоту (удаляем пробелы)
              searchParams.append(name, value); // добавляем параметр в объект для запроса
            }
          }

          const url = `${this.action}?${searchParams.toString()}`; // создаем URL с параметрами запроса
          window.location = url; // переходим по URL
        });
        
        $(document).ready(function() {
          $('.clear').click(function() {
            window.location.href = 'orders';
          });
        });
    });
</script>
@endpush
