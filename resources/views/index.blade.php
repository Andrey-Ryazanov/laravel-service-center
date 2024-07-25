@extends('layouts.admin_layout')
@section('content')
 <!-- Content Header (Page header) -->
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Все категории</h1>
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
        <div class="card">
        <div class="card-body p-0">
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th style="width: 10%">
                          ID
                      </th>
                      <th style="width: 20%">
                          Название
                      </th>
                      <th style="width: 30%; text-align:center">
                          Изображение
                      </th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($parentCategories as $category)
                  <tr>
                      <td>
                        {{ $category['id_category'] }}
                      </td>
                      <td style = "text-align:left">
                        {{ $category['title'] }}
                      </td>
                      <td style = "text-align:center">
                      @if ($category['category_image'])
                        <img class ="service_image" src="{{ asset('uploads/categories/'.$category['category_image']) }}"/>
                        @else Отсутствует
                      @endif
                      </td>
                      <td class="project-actions text-right">
                          <a class="btn btn-info btn-sm" href="{{ route('category.edit',$category['id_category']) }}">
                              <i class="fas fa-pencil-alt">
                              </i> 
                              Редактировать
                          </a>
                        <form action = "{{ route('category.destroy',$category['id_category']) }}" method = "POST" style = "display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type = "sudmit" class="btn btn-danger btn-sm delete-btn">
                              <i class="fas fa-trash">
                              </i> Удалить
                           </button>
                        </form>
                      </td>

                      @if ($category->subcategory)
                      <tr>
                           @foreach ($category->subcategory as $child)
                           <td style = "text-align:left">
                           
                           {{ $child['parent_id'] }}—{{ $child['id_category'] }}
                           </td>
                           <td style = "text-align:left">
                              {{ $child['title'] }}
                           </td>
                           <td style = "text-align:center">
                              @if ($child['category_image'])
                              <img class ="service_image" src="{{ asset('uploads/categories/'.$child['category_image']) }}"/>
                              @else Отсутствует
                              @endif
                           </td>
                           <td class="project-actions text-right">
                          <a class="btn btn-info btn-sm" href="{{ route('category.edit',$category['id_category']) }}">
                              <i class="fas fa-pencil-alt">
                              </i> 
                              Редактировать
                          </a>
                        <form action = "{{ route('category.destroy',$category['id_category']) }}" method = "POST" style = "display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type = "sudmit" class="btn btn-danger btn-sm delete-btn">
                              <i class="fas fa-trash">
                              </i> Удалить
                           </button>
                        </form>
                      </td>                          
                      </tr>
                      @endforeach
                      @endif
                  </tr>


                      
                  @endforeach
              </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
        </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    @endsection



