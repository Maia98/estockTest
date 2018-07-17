@extends('layouts.default')

@section('main-content')

    <div class="box">
        <div class="box-header page-header">
            <h1><i class="glyphicon glyphicon-menu-right"></i>Pesquisa Movimentação Materiais</h1>
            @include('layouts.partials.alert-notify')
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::open(['action' => ('PesquisaEstoqueController@index'), 'id' => 'form', 'method' => 'GET']) !!}
                    <div class="row">

                        <div class="col-md-2">
                            {!! Form::label('cod_inicio', 'Código Início:') !!}
                            {!! Form::text('cod_inicio', null, ['class' => 'form-control']) !!}
                        </div>
                        
                        <div class="col-md-2">
                            {!! Form::label('cod_final', 'Código Fim:') !!}
                            {!! Form::text('cod_final', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-2">
                            {!! Form::label('numero_obra', 'Número Obra:') !!}
                            {!! Form::text('numero_obra', null, ['class' => 'form-control']) !!}
                        </div>
                        
                        <div class="col-md-3">
                            {!! Form::label('status_obra', 'Status Obra:') !!}
                            {!! Form::select('status_obra', arrayToSelect($status_obras, 'id', 'nome'),null, ['class' => 'form-control']) !!}
                        </div>
                        
                        <div class="col-md-3">
                            {!! Form::label('almoxarifado', 'Almoxarifado:') !!}
                            {!! Form::select('almoxarifado', arrayToSelect($almoxarifados, 'id', 'nome'),null, ['class' => 'form-control']) !!}
                        </div>

                    </div>

                    <br/>

                    <div class="row">

                        <div class="col-md-2">
                            {!! Form::label('tipo_movimento', 'Tipo Movimento:') !!}
                            {!! Form::select('tipo_movimento', ['0' => 'Selecione', '1' => 'Entrada', '2' => 'Saída', '3' => 'Transferência'], null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-2">
                            {!! Form::label('data_inicio', 'Data Início:') !!}
                            {!! Form::date('data_inicio', null, ['class' => 'form-control', 'id' => 'data_inicial']) !!}
                        </div>
                        
                        <div class="col-md-2">
                            {!! Form::label('data_final', 'Data Término:') !!}
                            {!! Form::date('data_final', null, ['class' => 'form-control', 'id' => 'data_final']) !!}
                        </div>

                        <div class="col-md-4" style="margin-top: 5px;">
                            <br/>
                            <button type="submit" id="filtrar" class="btn btn-primary btn-flat btn_icon_filter"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span> Filtrar</button>
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
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 50px">Código</th>
                        <th>Descrição</th>
                        <th>Número Obra</th>
                        <th>Status Obra</th>
                        <th>Tipo Movimento</th>
                        <th>Data Movimento</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($result as $row)
                    <tr>
                        <td>{{ $row['codigo'] }}</td>
                        <td>{{ $row['descricao'] }}</td>
                        <td>{{ $row['numero_obra'] }}</td>
                        <td>{{ $row['status_obra'] }}</td>
                        <td>{{ $row['tipo_movimento'] }}</td>
                        <td>{{ date('d/m/Y', strtotime($row['data'])) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-9">
                        {{ $result->render() }}
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

    <script type="text/javascript" src="{{ url('js/tabelas-tipos/pesquisa-materiais.js') }}"></script>
 
@stop