<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> {{ env('APP_NAME') }} </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ asset('/bootstrap/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/css/skins/skin-blue.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/css/all.css') }}">
  <!-- jQuery Confirm Style-->
  <link rel="stylesheet" href="{{ asset('/plugins/jQueryConfirm/jquery-confirm.min.css') }}">
  <!-- jQuery 2.2.3 -->
  <script src="{{ asset('/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="{{ asset('/bootstrap/js/bootstrap.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('/js/app.min.js') }}"></script>
  <script src="{{ asset('/js/funcoesJavaScript.js') }}"></script>
  <!-- jQuery Confirm -->
  <script src="{{ asset('/plugins/jQueryConfirm/jquery-confirm.min.js') }}"></script>
  <!-- Select2 -->
  <script src="{{ asset('/plugins/select2/select2.min.js') }}"></script>
  <script src="{{ asset('/plugins/select2/i18n/pt-BR.js') }}"></script>
  <link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('/plugins/jQueryUI/jquery-ui.css') }}">
  <!-- Load c3.css -->
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/plugins/c3/c3.css"/>

  <!-- PhotoSwipe -->
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/css/photoswipe/photoswipe.css">
  <link rel="stylesheet" href="{{ url('/') }}/css/photoswipe/default-skin/default-skin.css">
</head>


