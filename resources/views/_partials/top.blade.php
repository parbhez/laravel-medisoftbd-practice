<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Advanced form elements</title>
  <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
    {{ Html::style('public/assets/bower_components/bootstrap/dist/css/bootstrap.min.css') }}
<!-- Font Awesome -->
    {{ Html::style('public/assets/bower_components/font-awesome/css/font-awesome.min.css') }}
  <!-- Ionicons -->
  {{ Html::style('public/assets/bower_components/Ionicons/css/ionicons.min.css') }}

  <!-- daterange picker -->
  {{ Html::style('public/assets/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}
  <!-- bootstrap datepicker -->
  {{ Html::style('public/assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}
  <!-- iCheck for checkboxes and radio inputs -->
  {{ Html::style('public/assets/plugins/iCheck/all.css') }}
  <!-- Bootstrap Color Picker -->
  {{ Html::style('public/assets/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}
  <!-- Bootstrap time Picker -->
  {{ Html::style('public/assets/plugins/timepicker/bootstrap-timepicker.min.css') }}
  <!-- Select2 -->
  {{ Html::style('public/assets/bower_components/select2/dist/css/select2.min.css') }}
  <!-- Theme style -->
  {{ Html::style('public/assets/dist/css/AdminLTE.css') }}
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  {{ Html::style('public/assets/dist/css/skins/skin-blue.min.css') }}
  
  {{ Html::style('public/assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}
  
  {{ Html::style('public/assets/bower_components/responsive-datatable/responsive.dataTables.min.css') }}

  {{ Html::style('public/css/style.css') }}
  
  <!-- Will include css files when needed only -->
  @yield('extra-css')

  <!-- jQuery 3 -->
  {{ Html::script('public/assets/bower_components/jquery/dist/jquery.min.js') }}
  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue layout-top-nav">
