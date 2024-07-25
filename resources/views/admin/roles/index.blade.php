@extends('layouts.admin_layout')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Информация о ролях</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
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
         <div class="card">
            <div class="card-body p-0">
              <table class="table table-striped projects" >
              <thead>
                  <tr>
                      <th style="width: 7%">
                          ID
                      </th>
                      <th style="width: 15%">
                          Роль
                      </th>
                      <th style="width: 60%">
                          Разрешения роли
                      </th>
                       <th style="width: 18%;">
                          Действия
                      </th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($roles as $role)
                  <tr>
                      <td style = "vertical-align:top;">
                        {{ $role['id'] }}
                      </td>
                      <td style = "vertical-align:top;">
                        {{ $role['name'] }}
                      </td>
                      <td style = "vertical-align:top;">
                        <div class="form-group">
                        <div class = "ui-checkbox-block scroll-menu">
                        @foreach ($role->permissions as $permission)
                        <label class="ui-checkbox ui-checkbox_filter">
                            <span>{{ $permission->name }}</span>
                            <input type="checkbox" class="ui-checkbox__input" value="{{ $permission->id }}" data-sdm ="{{ $permission->id }}" name = "check" checked disabled>
                            <span class="ui-checkbox__box"></span>
                        </label>
                        @endforeach
                        </div>
                        </div>
                      </td>
                      <td style = "vertical-align:top;">
                      <a class="btn btn-info btn-sm" href="{{ route('roles.edit',$role['id']) }}">
                          <i class="fas fa-pencil-alt">
                            </i> 
                      </a>
                      <form action = "{{ route('roles.destroy',$role) }}" method = "POST" style = "display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type = "sudmit" class="btn btn-danger btn-sm delete-btn">
                              <i class="fas fa-trash">
                              </i>
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