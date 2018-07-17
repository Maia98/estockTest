<!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="/" class="logo" style="background-color: #3c8dbc; height: 53px;">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">
          <img src="{{ url('/img/logo-small.png') }}" style="padding: 5px; width: 50px;" />
      </span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">
          <img src="{{ url('/img/logo-white.png') }}" style="margin-top: -5px; width: 80%;" />
      </span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><i class="glyphicon glyphicon-user"></i> {{ \Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <p>
                  <h1 style="color: #FFF"><i class="fa fa-user"></i></h1>
                  <h3 style="color: #FFF">{{ \Auth::user()->name }}</h3>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a  href="{{url('/usuarios/change/password')}}" class="btn btn-warning"><i class="fa fa-key"></i> Alterar Senha</a>
                </div>
                <div class="pull-right">
                @if(Auth::check())
                    <form action="{{ route('logout') }}" method="POST">{{ csrf_field() }}
                    <button type="submit" class="btn btn-default">Sair <i class="glyphicon glyphicon-log-out"></i></button> 
                  </form>
                  @else
                  <a href="{{ url('/login') }}" class="btn btn-default btn-flat">Entrar <i class="glyphicon glyphicon-log-in"></i></a>
                  @endif
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>