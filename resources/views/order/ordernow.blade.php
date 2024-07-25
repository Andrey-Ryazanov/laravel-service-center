@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Оформление заказа</div>
                        <form method="POST" action="/orderplace">
                        @csrf
                        <div class="card-body">

                        <div class="row mb-3">
                            <label  class="col-md-4 col-form-label text-md-end">Стоимость:</label>
                            <div class="col-md-6">
                            <input value="{{ $total }} ₽"  class="form-control" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">Комментарий к заказу:</label>
                            <div class="col-md-6">
                                <textarea name = "comment" class ="form-control" placeholder ="Здесь Вы можете описать вашу проблему" ></textarea><br>
                            </div>
                        </div>

                        @if (isset($sdm) && $sdm == 2)
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">Адрес:</label>
                            <div class="col-md-6">
                                <textarea name = "address" class ="form-control" placeholder ="Введите адрес" ></textarea><br>
                            </div>
                        </div>
                        @endif

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type = "submit" class = "btn btn-primary">Заказать</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    /*$(document).ready(function(){
    sdm = parseInt(localStorage.getItem("sdm"));

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    data = {
        sdm : sdm
    }

    $.ajax({
        url:"ordernow",
        method: "GET",
        data: data,
        success:function(data){
          $("body").html(data);
        }
    });
});*/
        </script>
@endsection