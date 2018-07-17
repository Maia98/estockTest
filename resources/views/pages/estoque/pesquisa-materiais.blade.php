@extends('layouts.default')

@section('main-content')

    <div class="box">
        <div class="box-header page-header">
            <h1><i class="glyphicon glyphicon-menu-right"></i>Pesquisa Materiais</h1>
            @include('layouts.partials.alert-notify')
        </div>
        <div class="box-body">
            {!! Form::open(['action' => ('PesquisaEstoqueController@index'), 'id' => 'form', 'method' => 'GET']) !!}
            <div class="row">
                <div class="col-md-2">
                    {!! Form::label('cod_inicio', 'Código Material:') !!}
                    {!! Form::text('cod_inicio', null, ['class' => 'form-control', 'placeholder' => 'Cod Início']) !!} 
                </div>
                <div class="col-md-2">
                    {!! Form::label('cod_fim', '.') !!}
                    {!! Form::text('cod_fim', null, ['class' => 'form-control', 'placeholder' => 'Cod Fim']) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::label('num_obra', 'Número Obra:') !!}
                    {!! Form::select('num_obra', arrayToSelect($obras , 'id', 'numero_obra'), null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::label('almoxarifado', 'Almoxarifado:') !!}
                    {!! Form::select('almoxarifado', arrayToSelect($almoxarifados , 'id', 'nome'), null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-md-4">
                    {!! Form::label('tipo_material', 'Tipo Material:') !!}
                    {!! Form::select('tipo_material', arrayToSelect($tipoMateriais , 'id', 'descricao'), null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2">
                    {!! Form::label('status_obra', 'Status Obra:') !!}
                    {!! Form::select('status_obra', arrayToSelect($statusObra , 'id', 'nome'), null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-md-2">
                    {{Form::label('data_inicio', 'Data Início:')}}
                    {{Form::date('data_cadastro', null, ['id' => 'data_inicio', 'class' => 'form-control'])}}
                </div>
                <div class="col-md-2">
                    {{Form::label('data_termino', 'Data Término:')}}
                    {{Form::date('data_medicao', null, ['id' => 'data_termino', 'class' => 'form-control'])}}
                </div>
                <div class="col-md-3" style="margin-top: 27px;">
                    <button type="submit" class="btn btn-primary btn-flat btn_icon_filter" id="filtrar"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span> Filtrar</button>
                    <div class="btn-group" style="margin-left: 20px;">
                        <button type="button" class="btn btn-gray dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Exportar <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" id="btn-excel"><i class="fa fa-file-excel-o"></i> Excel</a></li>
                            <li><a href="#" id='btn-pdf' ><i class="fa fa-file-pdf-o"></i> Pdf</a></li>
                        </ul>
                    </div> 
                </div>
            </div>

            <div class="row margin-top">
            {!! Form::close() !!}
            </div>
            <br/>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descrição</th>
                        <th>Tipo Material</th>
                        <th>Número Obra</th>
                        <th>Status Obra</th>
                        <th>Data Movimento</th>
                    </tr>
                </thead>
                <tbody>
                        <td>#</td>
                        <td>#</td>
                        <td>#</td>
                        <td>#</td>
                        <td>#</td>
                        <td>#</td>
                </tbody>
            </table>
        </div>
    </div>


   
@stop

@section('scripts-footer')
    <script type="text/javascript" src="{{ url('js/estoque.js') }}"></script>
@stop