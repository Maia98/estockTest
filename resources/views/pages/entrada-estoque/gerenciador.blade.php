@extends('layouts.default')

@section('main-content')

    <div class="box">
        <div class="box-header page-header">
            <h1><i class="glyphicon glyphicon-menu-right"></i>Pequisa Entrada Estoque</h1>
            @include('layouts.partials.alert-notify')
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::open(['action' => ('EntradaEstoqueController@gerenciador'), 'id' => 'form', 'method' => 'GET']) !!}
                    <div class="row">
                        <div class="col-md-3">
                            {!! Form::label('numero_obra', 'Número Obra:') !!}
                            {!! Form::select('numero_obra', arrayToSelect($obra, 'id', 'numero_obra') ,null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Form::label('usuario', 'Usuário:') !!}
                            {!! Form::select('usuario', arrayToSelect($users, 'id', 'name') ,null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Form::label('conferente', 'Conferente:') !!}
                            {!! Form::select('conferente', arrayToSelect($funcionario, 'id', 'nome') ,null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Form::label('tipo_de_entrada', 'Tipo de entrada:') !!}
                            {!! Form::select('tipo_de_entrada', arrayToSelect($tipoEntrada, 'id', 'nome') ,null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <br/>

                    <div class="row">
                        <div class="col-md-3">
                            {!! Form::label('almoxarifado', 'Almoxarifado:') !!}
                            {!! Form::select('almoxarifado',arrayToSelect($almoxarifados, 'id', 'nome'), null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Form::label('data_inicio', 'De:') !!}
                            {!! Form::date('data_inicio', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Form::label('data_final', 'Até:') !!}
                            {!! Form::date('data_final', null, ['class' => 'form-control']) !!}
                        </div>
                        
                        <div class="col-md-3" style="margin-top: 5px;">
                            <br/>
                            <button type="submit" class="btn btn-primary btn-flat btn_icon_filter"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span> Filtrar</button>
                            {!! Form::close() !!}
                            <div class="btn-group" style="margin-left: 20px;">
                                <button type="button" class="btn btn-gray dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Exportar <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#" id="btn-excel"><i class="fa fa-file-excel-o"></i> Excel</a></li>
                                    <li><a href="#" id="btn-pdf"><i class="fa fa-file-pdf-o"></i> Pdf</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br/>
            <table class="table table-bordered table-nowrap">
                <thead>
                    <tr>
                        <th>Número Obra</th>
                        <th>Usuário</th>
                        <th>Almoxarifado</th>
                        <th>Conferente</th>
                        <th>Tipo Entrada</th>
                        <th>Data</th>
                        <th>Observação</th>
                        <th style="width: 100px;">Detalhes</th>
                    </tr>
                </thead>
                <tbody> 

                    @foreach ($entradaEstoque as $row)
                        <tr>
                            <td>{{ $row->obra->numero_obra }}</td>
                            <td>{{ $row->usuario->name }}</td>
                            <td>{{ $row->almoxarifado->nome }}</td>
                            <td>{{ $row->conferente->nome }} {{ $row->conferente->sobrenome }}</td>
                            <td>{{ $row->tipoEntrada->nome }}</td>
                            <td>{{ date_format($date = new DateTime($row->data),'d/m/Y') }}</td>
                            <td style="width: 250px;">{{ $row->obs }}</td>
                            <td>    
                                <center><button type="button" class="btn btn-warning btn-xs" onclick="listaDetalhes({{ $row->id }})"> <i class="fa fa-search"></i></button></center>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-9">
                        {!! $entradaEstoque->render() !!}  
                    </div>
                    <div class="col-md-3" style="text-align: right;">
                        <br/>
                        Mostrando {!! $entradaEstoque->firstItem() !!} a {!! $entradaEstoque->lastItem() !!}
                    de {!! $entradaEstoque->total() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-fab', 'idContent' => 'content-modal-fab' ])


   
@stop

@section('scripts-footer')

    <script type="text/javascript" src="{{ url('js/entrada-estoque.js') }}"></script>
 
@stop