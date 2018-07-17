@extends('layouts.default')

@section('main-content')

    <div class="box">
        <div class="box-header page-header">
            <h1><i class="glyphicon glyphicon-menu-right"></i>Pesquisa Transferência</h1>
            @include('layouts.partials.alert-notify')
        </div>
        <div class="box-body">
                {!! Form::open(['action' => ('TransferenciaEstoqueController@gerenciador'), 'id' => 'form', 'method' => 'GET']) !!}
                <div class="row">
                    <div class="col-md-4">
                        {!! Form::label('almoxarifado_origem', 'Almoxarifado Origem:') !!}
                        {!! Form::select('almoxarifado_origem', arrayToSelect($almoxarifados,'id','nome'), null, ['id' => 'almoxarifado_origem', 'class' => 'form-control']) !!}
                    </div>

                    <div class="col-md-4">
                        {!! Form::label('obra_origem', 'Obra Origem:') !!}
                        {!! Form::select('obra_origem', arrayToSelect($obras,'id','numero_obra'), null, ['id' => 'obra_origem', 'class' => 'form-control', 'id' => 'filter_obra_origem']) !!}
                    </div>

                    <div class="col-md-4">
                        {!! Form::label('usuario', 'Usuário:') !!}
                        {!! Form::select('usuario', arrayToSelect($usuarios,'id','name'), null, ['id' => 'usuario', 'class' => 'form-control']) !!}
                    </div>

                </div>
                <br/>
                <div class="row">

                    <div class="col-md-4">
                        {!! Form::label('almoxarifado_destino', 'Almoxarifado Destino:') !!}
                        {!! Form::select('almoxarifado_destino', arrayToSelect($almoxarifados,'id','nome'), null, ['id' => 'almoxarifado_destino', 'class' => 'form-control']) !!}
                    </div>

                    <div class="col-md-4">
                        {!! Form::label('obra_destino', 'Obra Destino:') !!}
                        {!! Form::select('obra_destino', arrayToSelect($obras,'id','numero_obra'), null, ['id' => 'obra_destino', 'class' => 'form-control', 'id' => 'filter_obra_destino']) !!}
                    </div>

                    <div class="col-md-2">
                        {!! Form::label('data_inicio', 'De:') !!}
                        {!! Form::date('data_inicio', null, ['id' => 'data_inicio', 'class' => 'form-control']) !!}
                    </div>

                    <div class="col-md-2">
                        {!! Form::label('data_final', 'Até:') !!}
                        {!! Form::date('data_final', null, ['id' => 'data_final', 'class' => 'form-control']) !!}
                    </div>

                </div>
                <br/>
                <div class="row">
                    <div class="col-md-offset-7 col-md-5 text-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-gray dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Exportar <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#" id="btn-excel"><i class="fa fa-file-excel-o"></i> Excel</a></li>
                                <li><a href="#" id="btn-pdf"><i class="fa fa-file-pdf-o"></i> Pdf</a></li>
                            </ul>
                        </div>
                        <button type="reset" class="btn btn-gray btn-flat" id="filter_clear"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;Limpar</button>
                        <button type="submit" class="btn btn-primary btn-flat btn_icon_filter"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;Filtrar</button>
                    </div>

                </div>
                {!! Form::close() !!}
            <hr/>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Obra Destino</th>
                        <th>Almox. Destino</th>
                        <th>Usuário</th>
                        <th>Data</th>
                        <th align="center" width="90px;">Visualizar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($result as $row)
                        <tr>
                            <td>{{ $row['numero_obra'] }}</td>
                            <td>{{ $row['almoxarifado_destino_nome']}}</td>
                            <td>{{ $row['name'] }}</td>
                            <td>{{ dateToView($row['data']) }}</td>
                            <td><center><i><button  type="button" class="btn btn-warning btn-xs" onclick="listaDetalhes({{ $row['id'] }})"> <i class="glyphicon glyphicon-search"></i></button></i></center></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-9">
                        {!! $result->render() !!}
                    </div>
                    <div class="col-md-3" style="text-align: right;">
                        <br/>
                        Mostrando {!! $result->firstItem() !!} a {!! $result->lastItem() !!}
                        de {!! $result->total() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
   
@stop

@section('scripts-footer')
    <script type="text/javascript" src="{{ url('js/transferencia-estoque.js') }}"></script>
@stop