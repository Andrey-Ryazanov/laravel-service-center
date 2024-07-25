@extends('layouts.admin_layout')
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Создание пользователя</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>  <!-- /.content-header -->

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

        </div>
    </div>

    <form method = "POST" action = "{{ route('usAbout.store') }}" enctype ="multipart/form-data">
            @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="login">Логин</label>
                    <input id = "login" name = "login" type="text" class="form-control" placeholder = "Введите логин">
                  </div>

                  <div class="form-group">
                    <label for="email">Электронная почта</label>
                    <input id = "email" name = "email" type="text" class="form-control" placeholder = "Введите эл.почту">
                  </div>

                  <div class="form-group">
                    <label for="password">Пароль</label>
                    <input id = "password" name = "password"  type="password" class="form-control" placeholder = "Введите пароль">
                  </div>

                  <div class="form-group">
                    <label for="phone">Телефон</label>
                    <input id = "phone" name = "phone" type="text" class="form-control" placeholder = "Введите номер телефона">
                  </div>
                
                  <div class="form-group">
                  <label for="roles">Роль</label>
                  <select class="form-control" name="roles">
                    @foreach ($roles as $role)
                        <option>{{ $role }}</option>
                    @endforeach
                    </select>
                    </div>

                  <button type="submit" class="btn btn-primary">Создать</button>
              </form>   

    </section>

@endsection