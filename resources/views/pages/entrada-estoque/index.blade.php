@extends('layouts.default')

@section('main-content')

    <div class="box">
        <div class="box-header page-header">
            <h1><i class="glyphicon glyphicon-menu-right"></i>Gerenciar Entrada Estoque</h1>
            @include('layouts.partials.alert-notify')
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::open(['action' => ('EntradaEstoqueController@index'), 'id' => 'form', 'method' => 'GET']) !!}
                    <div class="row">
                        <div class="col-md-3">
                            {!! Form::label('numero_obra', 'Número Obra:') !!}
                            {!! Form::text('numero_obra', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Form::label('usuario', 'Usuário:') !!}
                            {!! Form::select('usuario',['0' => 'Selecione', '1' => 'Sr Tadeu', '2' => 'Augustinho Carrara'] ,null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Form::label('conferente', 'Conferente:') !!}
                            {!! Form::select('conferente',['0' => 'Selecione', '1' => 'Sr Tadeu', '2' => 'Augustinho Carrara'] ,null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Form::label('tipo_de_entrada', 'Tipo de entrada:') !!}
                            {!! Form::select('tipo_de_entrada',['0' => 'Selecione', '1' => 'Sr Tadeu', '2' => 'Augustinho Carrara'] ,null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <br/>

                    <div class="row">

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
                                    <li><a href="{{ url('/sistema/entrada-estoque/exportar-excel') }}"><i class="fa fa-file-excel-o"></i> Excel</a></li>
                                    <li><a href="{{ url('/sistema/entrada-estoque/exportar-pdf') }}"><i class="fa fa-file-pdf-o"></i> Pdf</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br/>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 50px">#</th>
                        <th>Número obra</th>
                        <th>Usuário</th>
                        <th>Almoxarifado</th>
                        <th>Conferente</th>
                        <th>Tipo entrada</th>
                        <th>Data</th>
                        <th>Observação</th>
                        <th style="width: 150px">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>1212</td>
                        <td>Vinicius</td>
                        <td>João Pessoa</td>
                        <td>Vinicius</td>
                        <td>GHFfgydf</td>
                        <td>21/01/2017</td>
                        <td>João Gay</td>
                        <td>    
                            <button class="btn btn-warning btn-xs" onclick=""><i class="glyphicon glyphicon-search"></i>&nbsp;</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-9">

                    </div>
                    <div class="col-md-3" style="text-align: right;">
                        <br/>
                        Mostrando 0 a 0
                        de 10
                    </div>
                </div>
            </div>
        </div>
    </div>

    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-fab', 'idContent' => 'content-modal-fab' ])


   
@stop

@section('scripts-footer')

    <script type="text/javascript" src="{{ url('js/tabelas-tipos/entrada-estoque.js') }}"></script>
 
@stop