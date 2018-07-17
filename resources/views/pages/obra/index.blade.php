@extends('layouts.default')

@section('main-content')

    <div class="box">
        <div class="box-header page-header">
        <h1><i class="glyphicon glyphicon-menu-right"></i>Pesquisa Obra</h1>
            @include('layouts.partials.alert-notify')
    </div>
    <div class="box-body">
        <div class="row">
             {!! Form::open(['action' => ('ObraController@index'), 'id' => 'form-filter', 'method' => 'GET']) !!}
            <div class="col-md-2">
                {!! Form::label('filter_numero_obra', 'Número Obra:') !!}
                {!! Form::text('filter_numero_obra', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-2">
                {!! Form::label('filter_status_obra', 'Status:') !!}
                {!! Form::select('filter_status_obra', arrayToSelect($statusObra , 'id', 'nome') ,null, ['class' => 'form-control', 'id' => 'filter_status_obra']) !!}
            </div>
            
            <div class="col-md-2">
                {!! Form::label('filter_regional', 'Regional:') !!}
                {!! Form::select('filter_regional', arrayToSelect($regionais , 'id', 'descricao') ,null, ['class' => 'form-control', 'id' => 'filter_regional']) !!}
            </div>
            
            <div class="col-md-2">
                {!! Form::label('filter_cidade', 'Cidade:') !!}
                {!! Form::select('filter_cidade', arrayToSelect($cidades , 'id', 'nome') ,null, ['class' => 'form-control', 'id' => 'filter_cidade']) !!}
            </div>
            <div class="col-md-4">
                {!! Form::label('filter_encarregado', 'Encarregado:') !!}
                {!! Form::select('filter_encarregado', arrayToSelect($encarregados , 'id', 'nome') ,null, ['class' => 'form-control', 'id' => 'filter_encarregado']) !!}
            </div>
        </div>
        <br />
        <div class="row">
            <div id="group_datas" class="form-group">
                <div class="col-md-2">
                    {!! Form::label('filter_tipo_data', 'Tipo Data:') !!}
                    {!! Form::select('filter_tipo_data', [ '0' => 'Selecione', '1' => 'Recebimento', '2' => 'Abertura', '3' => 'Início Execução', '4' => 'Fim Execução', '5' => 'Previsão Ret. Material'] ,null, ['class' => 'form-control', 'id' => 'filter_tipo_data']) !!}
                </div>
                <div class="col-md-2" id="filter_data_de">
                    {!! Form::label('filter_data_inicial', 'De:') !!}
                    {!! Form::date('filter_data_inicial', null, ['class' => 'form-control', 'id' => 'filter_data_init']) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::label('filter_data_final', 'Até:') !!}
                    {!! Form::date('filter_data_final', null, ['class' => 'form-control', 'id' => 'filter_data_final']) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::label('filtro_saldo', 'Saldo Balanço:') !!}
                    {!! Form::select('filtro_saldo', [ '0' => 'Selecione', '1' => 'Positivo', '2' => 'Negativo'] ,null, ['class' => 'form-control', 'id' => 'filtro_saldo']) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::label('filter_medidor', 'Medidor:') !!}
                    {!! Form::text('filter_medidor', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::label('filter_instalacao', 'Instalação:') !!}
                    {!! Form::text('filter_instalacao', null, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-2">
                {!! Form::label('filter_setor', 'Setor:') !!}
                {!! Form::select('filter_setor', arrayToSelect($setores , 'id', 'descricao') ,null, ['class' => 'form-control', 'id' => 'filter_setor']) !!}
            </div>
            <div class="col-md-10" style="text-align: right; margin-top: 27px;">
                <button type="submit" class="btn btn-primary btn-flat btn_icon_filter" id="filtrar" title="Filtrar Registro"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span> Filtrar</button>
                <button type="button" class="btn btn-default btn-flat" id="filter_clear"  title="Limpar Filtro"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span> Limpar</button>

                <div class="btn-group">
                    <button type="button" id="btn-exportar" class="btn btn-gray dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Exportar <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#" id="btn-excel"><i class="fa fa-file-excel-o"></i> Excel Sintético</a></li>
                        <li><a href="#" id="btn-excel-geral"><i class="fa fa-file-excel-o"></i> Excel Geral</a></li>
                        <li><a href="#" id='btn-pdf' ><i class="fa fa-file-pdf-o"></i> Pdf</a></li>
                    </ul>
                </div>
                <a href="{{url('/obra/gerenciador/exportar-listao-excel')}}" id="listao-excel" class="btn btn-warning btn-flat"><span class="fa fa-search" aria-hidden="true"></span> Material</a>
            </div>
        </div>
        {!! Form::close() !!}
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Número Obra</th>
                    <th>Status</th>
                    <th style="text-align: center;">Data Recebimento</th>
                    <th style="text-align: center;">Encarregado(s)</th>
                    <th>Regional</th>
                    <th>Cidade</th>
                    <th style="width: 150px; text-align: center;">Histórico</th>
                    <th style="width: 75px">Balanço</th>
                    <th style="width: 150px; text-align: center;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($result as $row)
                
                <tr>
                    <td>{{ $row->numero_obra }}</td>
                    <td>{{ $row->statusObra->nome or $row->status_obra }}</td>
                    <td><center>{{ dateToView($row->data_recebimento) }}</center></td>

                    <td>{{ $row->encarregados or ''}}</td>
                    <td>{{ $row->cidade->regional->descricao or $row->cidade}}</td>
                    <td>{{ $row->cidade->nome or $row->regional}}</td>
                    <td style="text-align: center;">
                        <button  type="button" class="btn btn-primary btn-xs" onclick="createHistorico({{ $row->id }})" title="Adicionar Histórico"> <i class="glyphicon glyphicon-plus"></i></button>
                        <button class="btn btn-warning btn-xs" onclick="showHistorico({{ $row->id }})" title="Detalhe Histórico">
                        <i class="fa fa-search"></i></button>
                    </td>
                    <td style="text-align: center;">
                        <button type="button" class="btn btn-warning btn-xs" onclick="showBalanco({{ $row->id }})" title="Detalhe Balanço"> <i class="fa fa-search"></i></button>
                    </td>
                    <td style="text-align: center;">
                        <button type="button" class="btn btn-warning btn-xs" onclick="detalhes({{ $row->id }})" title="Detalhe Obra"> <i class="fa fa-search"></i></button>
                        <button  type="button" class="btn btn-primary btn-xs" onclick="editar({{ $row->id }})" title="Editar Obra"> <i class="glyphicon glyphicon-pencil"></i></button>
                        <button  type="button" class="btn btn-gray  btn-xs" onclick="docmuentsExport({{ $row->id }})" title="Documentos Anexados"> <i class="fa fa-download"></i></button>
                    </td>
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
@includeIf('layouts.partials.modal', ['idModal' => 'modal-obra', 'idContent' => 'content-modal-obra' ])
@includeIf('layouts.partials.modal', ['idModal' => 'modal-historico', 'idContent' => 'content-modal-historico' ])

   
@stop

@section('scripts-footer')

    <script type="text/javascript" src="{{ url('js/obra.js') }}"></script>
 
@stop