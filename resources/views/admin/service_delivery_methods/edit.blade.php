@extends('layouts.admin_layout')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ isset($sdm) ? 'Редактировать способ оказания услуги' : 'Создать способ оказания услуги' }}</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="col-lg-12">
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

            <div class="card card-primary">
                <form method="POST" action="{{ isset($sdm) ? route('sdms.update', $sdm->id_sdm) : route('sdms.store') }}">
                    @csrf
                    @if(isset($sdm))
                        @method('PUT')
                    @endif
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name_sdm">Способ оказания услуги</label>
                            <input id="name_sdm" name="name_sdm" type="text" class="form-control" value="{{ old('name_sdm', $sdm->name_sdm ?? '') }}">
                        </div>
                        <button type="submit" class="btn btn-primary">{{ isset($sdm) ? 'Обновить' : 'Создать' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
