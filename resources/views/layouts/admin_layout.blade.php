
<!DOCTYPE html>
<html lang="ru">
<head>
  <link rel="shortcut icon" type="image/png" href="{{ asset('img/logo_withouttext.png') }}">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Административная панель</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="/admin/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/admin/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="/admin/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="/admin/plugins/summernote/summernote-bs4.min.css">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
 
</head>
<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="/img/logo_withouttext.png" alt="AdminLogo" height="60" width="60">
  </div>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('adminHome') }}" class="brand-link">
      <img src="/img/logo_withouttext.png" alt="AdminLogo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Администрация</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        @if (Auth::user()->hasRole(['admin','moderator']))
        <div class="image">
          <img src="/img/admin.png" class="img-circle elevation-2" alt="User Image">
        </div>
        @else
        <div class="image">
          <img src="/img/user.png" class="img-circle elevation-2" alt="User Image">
        </div>
        @endif
        <div class="info">
          <a href="{{ route('profile-account') }}" class="d-block">{{  Auth::user()->login  }}</a>
        </div>
      </div>



      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

        <li class="nav-item">
            <a href="{{ route('adminHome') }}" class="nav-link active">
              <i class="nav-icon fa fa-home" aria-hidden="true"></i>
              <p>
                Главная
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-folder"></i>
              <p>
                 Категории
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('category.index') }}" class="nav-link">
                  <p>Все категории</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('category.create') }}" class="nav-link">
                  <p>Добавить категорию</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="{{ route('category.export') }}" class="nav-link">
                  <p>Экспортировать категорию</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="{{ route('category.import') }}" class="nav-link">
                  <p>Импортировать категорию</p>
                </a>
              </li>
            </ul>
          </li>
          
        <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon  fa fa-list" aria-hidden="true"></i>
              <p>
                 Услуги в категориях
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
             <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="{{ route('c-service.index') }}" class="nav-link">
                  <p>Все услуги</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="{{ route('c-service.create') }}" class="nav-link">
                  <p>Добавить в категорию</p>
                </a>
              </li>
            </ul>
        </li>


          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-cogs"></i>
              <p>
                 Услуги
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('service.index') }}" class="nav-link">
                  <p>Все услуги</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('service.create') }}" class="nav-link">
                  <p>Добавить услугу</p>
                </a>
              </li>
                  <li class="nav-item">
                <a href="{{ route('service.import') }}" class="nav-link">
                  <p>Импортировать услугу</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="{{ route('service.export') }}" class="nav-link">
                  <p>Экспортировать услугу</p>
                </a>
              </li>
            </ul>
          </li>

   @if (Auth::user()->hasPermissionTo('смотреть информацию о ролях'))
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa fa-users"></i>
              <p>
                 Роли
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('roles.index') }}" class="nav-link">
                  <p>Все роли</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('roles.create') }}" class="nav-link">
                  <p>Добавить роль</p>
                </a>
              </li>
            </ul>
          </li>
        @endif
        
                 <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-ellipsis-h"></i>
              <p>
                 Прочее
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('contact.edit') }}" class="nav-link">
                  <p>Контакты</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('sdms.index') }}" class="nav-link">
                  <p>Способы оказания услуг</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>         
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class = "content-wrapper">
      @yield('content')
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="/admin/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="/admin/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="/admin/plugins/sparklines/sparkline.js"></script>

<!-- jQuery Knob Chart -->
<script src="/admin/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="/admin/plugins/moment/moment.min.js"></script>
<script src="/admin/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="/admin/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/adminlte.js"></script>
<!-- bs-custom-file-input -->
<script src="/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="/admin/js/admin.js"></script>
<script src = "/js/edit_service.js"></script>



<script>
$(function () {
  bsCustomFileInput.init();
});
</script>

@stack('a-scripts')

</body>
</html>
