
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> {{ env('APP_NAME') }} </title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('/css/AdminLTE.min.css') }}">
    <script src="{{ asset('/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('/bootstrap/js/bootstrap.min.js') }}"></script>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            overflow-x: hidden;
        }
        body{
            position: relative;
            background-image: url({{ URL::asset('img/logo-lg.png') }});
            background-color: #f7f7f7;
            background-repeat: no-repeat;
            background-position: right;
            background-size: 73vh 61vh;
            background-position-y: bottom;
        }
        .content{
            min-height: 100%;
            margin: 0 auto;
        }
        .login-box{
            border: 5px solid rgba(202,224,252,0.5);
            border-radius:  8px;
            box-shadow: 0 5px 6px -2px #3c8dbc;
            margin-top: 20%;
        }
        .thumbnail{
            background-color: #fff;
            border-radius: 0px;
            margin-bottom: 0;
        }
        footer {
            height: auto;
            background: #fff;
            border: 2px solid #e8e8e8;
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            overflow: auto;
        }
    </style>
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top" style="background-color: #3c8dbc;">
        <div class="container-fluid">
            <div class="navbar-header">
                <!-- Branding Image -->
                <a href="{{ url('/') }}">
                    <h4 style="color: white; margin-left: 3%; font-size: 3.5vh"><strong>{{ config('app.name', 'eStrock') }}</strong></h4>
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <div class="content">
        @yield('content')
        <div class="push"></div>
    </div>
    <footer>
        <div class="container-fluid">
            <div class="pull-right hidden-xs">
                <b>Versão {{versao()}}</b></a>
            </div>
            <strong><i>Copyright &copy; 2017 - </i><a href="http://engeselt.com.br/">Engeselt Soluções</a>. <i>Todos os Direitos Reservados</i></strong>
        </div>
        <script>

            $(window).resize(function () {
                if($(window).width() < 600)
                {
                    $('input').focusin(function(){
                        $('footer').css({
                            'position' : 'relative'
                        });
                    });

                    $('input').focusout(function(){
                        $('footer').css({
                            'position' : 'fixed'
                        });
                    });
                }
            });





        </script>
    </footer>
</div>
</body>
</html>
