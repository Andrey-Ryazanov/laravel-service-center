@extends('layouts.admin_layout')
@section('content')
 <!-- Content Header (Page header) -->
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Добавление категории</h1>
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
            <form method = "POST" action = "{{ route('category.store') }}" enctype ="multipart/form-data">
            @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="title">Название</label>
                    <input id = "title" name = "title" type="text" class="form-control" placeholder="Введите название">
                  </div>
                  <div class="form-group">
                    <label for="category_image">Изображение</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="category_image" name="category_image">
                        <label class="custom-file-label" for="category_image">Добавить изображение</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="parent_id">Категория</label>
                    <select id = "parent_id" name = "parent_id" class="form-control custom-select">
                        <option selected disabled>Выберите категорию</option>
                        @foreach ($categories as $category) <!--Категория из категорий-->
                          <option value = "{{ $category->id_category }}">{{ $category->title }} </option>
                          @if (count($category->subcategory))   <!--Если категория имеет хотя бы одну подкатегорию-->                
                            @include('admin.service.sub', ['subcategories' => $category->subcategory ]) <!--Включаем эту категорию в список категорий, имеющий потомков-->   
                          @endif
                        @endforeach
                    </select>
                  </div>
                  <button type="submit" class="btn btn-primary">Добавить</button>
              </form>   
        </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    </div>
        <!-- /.card-body -->
      </div>
        </div>
        </div>
      </div><!-- /.container-fluid -->
    @endsection