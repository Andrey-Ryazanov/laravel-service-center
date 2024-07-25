@extends('layouts.admin_layout')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Информация о способах оказания услуг</h1>
            </div><!-- /.col -->
                 <a href = "{{ route('sdms.create') }}" style = "float:right" class ="btn btn-success">Создать</a>
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
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th style="width: 20%">ID</th>
                                <th style="width: 60%">Способ оказания услуги</th>
                                <th style="width: 30%">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sdms as $sdm)
                                <tr>
                                    <td style="vertical-align:top;">{{ $sdm->id_sdm }}</td>
                                    <td style="vertical-align:top;">{{ $sdm->name_sdm }}</td>
                                    <td style="vertical-align:top;">
                                        <a class="btn btn-info btn-sm" href="{{ route('sdms.edit', $sdm->id_sdm) }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('sdms.destroy', $sdm->id_sdm) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>     
                            @endforeach
                        </tbody>
                    </table> 
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
