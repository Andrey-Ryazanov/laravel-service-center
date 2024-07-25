@extends('layouts.admin_layout')
@section('content')
 <!-- Content Header (Page header) -->
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Создание роли</h1>
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
            <form method = "POST" action = "{{ route('roles.store') }}" enctype ="multipart/form-data">
            @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Название</label>
                    <input id = "title" name = "name" type="text" class="form-control">
                  </div>
                  <div class="form-group">
                    <div class = "ui-checkbox-block scroll-menu">
                        @foreach ($permissions as $permission)
                        <label class="ui-checkbox">
                            <span style = "font-weight:400;"> {{ $permission->name }}</span>
                            <input type="checkbox" class="ui-checkbox__input" id = "{{ $permission->id }}" value="{{ $permission->id }}" name="array_permissions[]">
                            <span class="ui-checkbox__box"></span>
                        </label>
                        @endforeach
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Создать</button>
            </div>
            </form>   
        </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    @endsection