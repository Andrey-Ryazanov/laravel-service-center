@extends('layouts.admin_layout')
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Редактирование пользователя: {{ $user->login }}</h1>
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

    <form method = "POST" action = "{{ route('usAbout.update',$user) }}" enctype ="multipart/form-data">
            @csrf
               @method('PUT')
                <div class="card-body">
                  <div class="form-group">
                    <label for="login">Логин</label>
                    <input id = "login" name = "login" type="text" class="form-control" value = "{{ $user->login  }}">
                  </div>

                  <div class="form-group">
                    <label for="email">Электронная почта</label>
                    <input id = "email" name = "email" type="text" class="form-control" value = "{{ $user->email }}">
                  </div>

                  <div class="form-group">
                    <label for="phone">Телефон</label>
                    <input id = "phone" name = "phone" type="text" class="form-control" value = "{{ $user->phone }}">
                  </div>
                
                  <div class="form-group">
                  <label for="roles">Роль</label>
                  <select class="form-control" name="roles">
                    @foreach ($roles as $role)
                        @if ($user->roles->pluck('name')->first() == $role)
                           <option selected> {{ $user->roles->pluck('name')->first() }} </option>
                        @else 
                            <option>{{ $role }}</option>
                        @endif
                    @endforeach
                    </select>
                    </div>

                  <button type="submit" class="btn btn-primary">Изменить</button>
              </form>   

    </section>

@endsection