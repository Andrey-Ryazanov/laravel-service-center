@extends('layouts.admin_layout')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0">Контактные данные</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="col-lg-12">
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

                <!-- Вывод ошибок валидации -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $contact->email ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="phone">Телефон</label>
                            <input id="phone" name="phone" type="text" class="form-control" value="{{ old('phone', $contact->phone ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="address">Адрес</label>
                            <input id="address" name="address" type="text" class="form-control" value="{{ old('address', $contact->address ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="start_working_hours">Начало рабочего дня</label>
                            <input id="start_working_hours" name="start_working_hours" type="time" class="form-control" value="{{ old('start_working_hours', $contact->start_working_hours ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="end_working_hours">Конец рабочего дня</label>
                            <input id="end_working_hours" name="end_working_hours" type="time" class="form-control" value="{{ old('end_working_hours', $contact->end_working_hours ?? '') }}">
                        </div>
                        <button type="submit" class="btn btn-primary">{{ $contact ? 'Обновить' : 'Создать' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection
