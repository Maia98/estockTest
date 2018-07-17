@extends('layouts.default')

@section('main-content')

    <div class="box">
        <div class="box-header page-header">
            <h1><i class="glyphicon glyphicon-menu-right"></i>Pesquisa Materiais Estoque</h1>
            @include('layouts.partials.alert-notify')
        </div>
        <div class="box-body">
            {!! Form::open(['action' => ('EstoqueController@index'), 'id' => 'form-filter', 'method' => 'GET']) !!}
            <div class="row">
                <div class="col-md-4">
                    {!! Form::label('materiais', 'Materiais:') !!}
                    {!! Form::select('materiais', arrayToSelect($tipoMaterial , 'id', 'descricao'), null, ['class' => 'form-control']) !!} 
                </div>
                <div class="col-md-2">
                    {!! Form::label('regional', 'Regional:') !!}
                    {!! Form::select('regional', arrayToSelect($regionais , 'id', 'descricao'), null, ['class' => 'form-control', 'id' => 'filter_regional']) !!}
                </div>
                <div class="col-md-3">
                    {!! Form::label('almoxarifado', 'Almoxarifado:') !!}
                    {!! Form::select('almoxarifado', arrayToSelect($almoxarifados , 'id', 'nome'), null, ['class' => 'form-control', 'id' => 'filter_almoxarifado']) !!}
                </div>
                <div class="col-md-3">
                    {!! Form::label('numero_obra', 'Número Obra:') !!}
                    {!! Form::text('numero_obra', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-md-3 pull-right" style="margin-top: 27px; margin-right: -5%;">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary btn-flat btn_icon_filter"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;Filtrar</button>
                        </span>
                        <div class="btn-group" style="margin-left:20px;">
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
                <div class="col-md-1">
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
                        <th>Material</th>
                        <th>Qtde.</th>
                        <th>Unidade</th>
                        <th width="90px">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($result as $row)
                        @if($row->qtde_critica >= $row->quantidade)
                        
                            <tr class="text-red">
                        @else
                            
                            @if($row->qtde_minima >= $row->quantidade)
                                
                                <tr class="text-yellow">
                            @else
                                
                                <tr>
                            @endif
                        @endif
                            <td>{{ $row->codigo}}</td>
                            <td>{{ $row->nomeMaterial }}</td>
                            <td>{{ $row->quantidade }}</td>
                            <td>{{ $row->codigo_unidade }}</td>
                            <td >
                                <button  type="button" class="btn btn-primary btn-xs" onclick="detalhes({{$row->id}})">Mais informações</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
           <div class="row">
                <div class="col-md-12">
                    <div class="col-md-9">
                    {!! $result->links() !!}
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

    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-materiais', 'idContent' => 'content-modal-materiais' ])
   
@stop

@section('scripts-footer')
    <script type="text/javascript" src="{{ url('js/estoque.js') }}"></script>
@stop