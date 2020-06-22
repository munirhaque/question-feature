<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  {!! Html::style('plugins/fontawesome-free/css/all.min.css') !!}
  <!-- Ionicons -->
  {!! Html::style('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') !!}
  <!-- Tempusdominus Bbootstrap 4 -->
  {!! Html::style('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') !!}
  <!-- iCheck -->
  {!! Html::style('plugins/icheck-bootstrap/icheck-bootstrap.min.css') !!}
  <!-- JQVMap -->
  {!! Html::style('plugins/jqvmap/jqvmap.min.css') !!}
  <!-- Theme style -->
  {!! Html::style('dist/css/adminlte.min.css') !!}
  <!-- overlayScrollbars -->
  {!! Html::style('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') !!}
  <!-- Daterange picker -->
  {!! Html::style('plugins/daterangepicker/daterangepicker.css') !!}
  <!-- summernote -->
  {!! Html::style('plugins/summernote/summernote-bs4.css') !!}

  {!! Html::style('dist/css/style.css') !!}

  <!-- Google Font: Source Sans Pro -->
  {!! Html::style('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700') !!}
  {!! Html::style('http://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css') !!}
  {!! Html::script('https://kit.fontawesome.com/3058e525f8.js') !!}
  @yield('extra-css')
  @yield('custom-css')



