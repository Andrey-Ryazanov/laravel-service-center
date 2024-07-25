@extends('layouts.admin_layout')
@section('content')
 <!-- Content Header (Page header) -->
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Импорт категорий</h1>
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
            <form method = "POST" action = "{{ route('category.smartimport') }}" enctype ="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="category_image">Импорт Excel</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="category_file" name="category_file">
                        <label class="custom-file-label" for="category_file">Добавить файл</label>
                      </div>
                    </div>
                 </div>
                 <button type="submit" class="btn btn-primary">Импортировать</button>
            </div>
          </form>
        </div>
        <div class="card card-primary">
            <form method = "POST" action = "{{ route('category.importImages') }}" enctype ="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="main_image">Импорт изображений</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="images[]" multiple>
                        <label class="custom-file-label" for="images[]">Добавить файл</label>
                      </div>
                    </div>
                 </div>
                 <button type="submit" class="btn btn-primary">Импортировать</button>
            </div>
          </form>
        </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    @endsection
