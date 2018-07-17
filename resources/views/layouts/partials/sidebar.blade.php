<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 720px;">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
          <li class="header">MENU</li>
          <!-- Optionally, you can add icons to the links -->
        <li class="treeview {!! Request::is('obra/*') ? 'active' : '' !!}">
          <li class="treeview {!! Request::is('obra/*') ? 'active' : '' !!}">
            <a href="#">
              <i class="fa fa-gavel"></i> <span>Obras</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="{!! Request::is('obra/create') ? 'active' : '' !!}"><a href="{{url('/obra/create')}}"><i class="fa fa-table"></i> <span>Cadastrar</span></a></li>
              <li class="obras_gerenciador {!! Request::is('obra/gerenciador') ? 'active' : '' !!}"><a href="{{url('/obra/gerenciador')}}"><i class="glyphicon glyphicon-search"></i> <span>Pesquisar</span></a></li>
            </ul>
          </li>
          <li class="treeview {!! Request::is('entrada-estoque/*') || Request::is('saida-estoque/*')? 'active' : '' !!}">
            <a href="#">
              <i class="fa fa-exchange"></i> <span>Movimentação Estoque </span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="treeview {!! Request::is('entrada-estoque/*') ? 'active' : '' !!}">
                <a style="position:relative;z-index:1000" href="#">
                  <i class="glyphicon glyphicon-save"></i> <span>Entrada</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li class="{!! Request::is('entrada-estoque/create') ? 'active' : '' !!}"><a href="{{url('/entrada-estoque/create')}}"><i class="fa fa-table"></i> <span>Nova</span></a></li>
                  <li class="{!! Request::is('entrada-estoque/gerenciador') ? 'active' : '' !!}"><a href="{{url('/entrada-estoque/gerenciador')}}"><i class="glyphicon glyphicon-search"></i> <span>Pesquisa</span></a></li>
                </ul>
              </li>
              <li class="treeview {!! Request::is('transferencia-estoque/*') ? 'active' : '' !!}">
                <a href="#">
                  <i class="glyphicon glyphicon-transfer"></i> <span>Transferência</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li class="{!! Request::is('transferencia-estoque/create') ? 'active' : '' !!}"><a href="{{url('/transferencia-estoque/create')}}"><i class="fa fa-table"></i> <span>Nova</span></a></li>
                  <li class="{!! Request::is('transferencia-estoque/gerenciador') ? 'active' : '' !!}"><a href="{{url('/transferencia-estoque/gerenciador')}}"><i class="glyphicon glyphicon-search"></i> <span>Pesquisa</span></a></li>
                </ul>
              </li>
              <li class="treeview {!! Request::is('saida-estoque/*') ? 'active' : '' !!}">
                <a href="#">
                  <i class="glyphicon glyphicon-open"></i> <span>Saída</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li class="{!! Request::is('saida-estoque/create') ? 'active' : '' !!}"><a href="{{url('/saida-estoque/create')}}"><i class="fa fa-table"></i> <span>Nova</span></a></li>
                  <li class="{!! Request::is('saida-estoque/gerenciador') ? 'active' : '' !!}"><a href="{{url('/saida-estoque/gerenciador')}}"><i class="glyphicon glyphicon-search"></i> <span>Pesquisa</span></a></li>
                </ul>
              </li>
            </ul>
          </li>
          <li class="treeview {!! Request::is('medicao/*') ? 'active' : '' !!}">
            <a href="#">
              <i class="fa fa-pencil-square-o"></i> <span>Medições</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="{!! Request::is('medicao/create') ? 'active' : '' !!}"><a href="{{url('/medicao/create')}}"><i class="fa fa-table"></i> <span>Cadastrar</span></a></li>
              <li class="{!! Request::is('create/gerenciador') ? 'active' : '' !!}"><a href="{{url('/medicao/gerenciador')}}"><i class="glyphicon glyphicon-search"></i> <span>Pesquisar</span></a></li>
            </ul>
          </li>
          <li class="treeview {!! Request::is('estoque') ? 'active' : '' !!}">
            <a href="#">
              <i class="fa fa-cubes"></i> <span>Estoque</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="{!! Request::is('estoque') ? 'active' : '' !!}"><a href="{{url('/estoque/')}}"><i class="glyphicon glyphicon-search"></i> <span>Pesquisa</span></a></li>
              <li class="{!! Request::is('estoque/pesquisa') ? 'active' : '' !!}"><a href="{{url('/estoque/pesquisa')}}"><i class="glyphicon glyphicon-search"></i> <span>Pesquisa Movimentação</span></a></li>
            </ul>
          </li>
          <li class="{!! Request::is('gerencial') ? 'active' : '' !!}"><a href="{{url('/gerencial')}}"><i class="fa fa-pie-chart"></i> <span>Gerencial</span></a></li>
          <li class="treeview {!! Request::is('sistema/*') ? 'active' : '' !!}">
            <a href="#">
              <i class="glyphicon glyphicon-cog"></i> <span>Configurações</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="{!! Request::is('/usuarios') ? 'active' : '' !!}"><a href="{{url('/usuarios')}}"><i class="glyphicon glyphicon-user"></i> Usuários</a></li>
              <li class="{!! Request::is('sistema/*') ? 'active' : '' !!}"><a href="{{url('/sistema/tabelas')}}"><i class="fa fa-table"></i> <span>Tabelas do Sistema</span></a></li>
              <li class="{!! Request::is('/empresa') ? 'active' : '' !!}"><a href="{{url('/empresa')}}"><i class="fa fa-building-o"></i> <span>Empresa</span></a></li>
              <li class="{!! Request::is('/empresa') ? 'active' : '' !!}"><a href="{{ route('list') }}"><i class="glyphicon glyphicon-th-list"></i>
                <span>Listas</span></a></li>
              <li class="{!! Request::is('/empresa') ? 'active' : '' !!}">
              <a href="#"><i class="glyphicon glyphicon-copy"></i>
                <span>Formulários</span></a></li>
            </ul>
          </li>

        </ul>
        <!-- /.sidebar-menu -->
      </section>
      <!-- /.sidebar -->
      {{--<div class="slimScrollBar" style="background: rgba(0, 0, 0, 0.2); width: 3px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 525.761px;"></div>--}}
      {{--<div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div>--}}
    </div>
  </aside>
<div class="control-sidebar-bg"></div>