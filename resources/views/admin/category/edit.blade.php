@extends('layouts.admin_layout')
@section('content')
 <!-- Content Header (Page header) -->
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-9">
            <h1 class="m-0">Редактирование категории: {{ $category['title'] }}</h1>
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
        <form method = "POST" action = "{{ route('category.update',$category['id_category']) }}" enctype ="multipart/form-data">
            @csrf
            @method('PUT')
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Название</label>
                    <input id = "title" name = "title" type="text" class="form-control" value = "{{ $category['title'] }}">
                  </div>
                  <div class="form-group">
                    <label for="category_image">Изображение</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="category_image" name="category_image">
                        <label class="custom-file-label" for="category_image">@if ($category['category_image']) {{ $category['category_image'] }} @else Добавить изображение @endif</label>
                      </div>
                    </div>
                  </div>
                   <div class="form-group">
                    <label for="parent_id">Категория</label>
                    <select id = "parent_id" name = "parent_id" class="form-control custom-select">
                        <option selected disabled>Выберите категорию</option>
                        @foreach($categories as $cat)
                        @if ($cat->id_category != $category->id_category)
                            <option @if ($cat->id_category == $category->parent_id) selected @endif  value = "{{ $cat->id_category }}">{{ $cat->title }} </option>
                            @if(count($cat->subcategory))
                                @include('admin.category.sub', ['subcategories' => $cat->subcategory, 'current' => $category->id_category, 'parent'=>$category->parent_id])
                            @endif
                        @endif
                        @endforeach
                    </select>
                  </div>
                  <button type="submit" class="btn btn-primary">Обновить</button>
                </div>
              </form>   
        </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    @endsection