@extends('layouts.admin_layout')
@section('content')
 <!-- Content Header (Page header) -->
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Экспорт категорий</h1>
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
            <form method = "GET" action = "{{ route('category.smartexport') }}" enctype ="multipart/form-data">
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label for="parent_id">Категория</label>
                <select id = "parent_id" name = "parent_id">
                    <option selected>Все</option>
                    @foreach ($categories as $category)
                      <option value = "{{ $category->id_category }}">{{ $category->title }} </option>
                    @endforeach
                </select>
              </div>
              <button type="submit" class="btn btn-primary">Экспортировать</button>
             </div>
            </form>   
        </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    @endsection
     @push('a-scripts')
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
    <script>
        $(document).ready(function () {
      $('select').selectize({
          sortField: 'text'
      });
  });
    </script>
    @endpush