@extends('layouts.default')

@section('main-content')
<div class="box">
    <div class="box-header page-header">
        <h1><i class="glyphicon glyphicon-menu-right"></i>Pesquisa Medição</h1>
        @include('layouts.partials.alert-notify')
    </div>
    <div class="box-body">
        <div class="row">
            {!! Form::open(['action' => ('MedicaoController@index'), 'id' => 'form_filter', 'method' => 'GET']) !!}
            <div class="col-md-4">
                {{Form::label('numeroObra', 'Número Obra:')}}
                {{Form::text('filter_obra_id', null, ['id' => 'numeroObra', 'class' => 'form-control'])}}
            </div>

            <div class="col-md-3">
                {{Form::label('statusMedicao', 'Status:')}}
                {{Form::select('filter_status_medicao', arrayToSelect($statusMedicao,'id','nome'), null, ['id' => 'statusMedicao', 'class' => 'form-control'])}}
            </div>

            <div class="col-md-5">
                {{Form::label('filter_funcionario_fiscal_id', 'Fiscal:')}}
                {{Form::select('filter_funcionario_fiscal_id', arrayToSelect($funcionarios,'id','nome'), null, ['id' => 'filter_funcionario_fiscal_id', 'class' => 'form-control'])}}
            </div>
        </div>

        <br/>
        
        <div class="row">

            <div class="col-md-2">
                {{Form::label('filter_data_inicial', 'Data Início:')}}
                {{Form::date('filter_data_inicial', null, ['id' => 'filter_data_inicial', 'class' => 'form-control'])}}
            </div>

            <div class="col-md-2">
                {{Form::label('filter_data_final', 'Data Término:')}}
                {{Form::date('filter_data_final', null, ['id' => 'filter_data_final', 'class' => 'form-control'])}}
            </div>
            <div class="col-md-3">
                {{Form::label('filter_apontamentos', 'Apontamentos:')}}
                {{Form::select('filter_apontamentos', arrayToSelect($apontamentos,'id','nome'), null, ['id' => 'filter_apontamentos', 'class' => 'form-control'])}}
            </div>
            <br/>
            <div class="col-md-3" style="margin-top:5px;">
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
            {!! Form::close() !!}
        </div>
        <br />
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Número Obra</th>
                    <th>Data Execução</th>
                    <th>Status</th>
                    <th>Fiscal</th>
                    <th>Valor Recebido</th>
                    <th>Valor Medido</th>
                    <th>Apontamentos</th>
                    <th style="width: 90px">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($result as $row)
                <tr>
                    <td>{{ $row->obra->numero_obra }}</td>
                    <td>{{ date('d/m/Y', strtotime($row->data_medicao)) }}</td>
                    <td>{{ $row->statusMedicao->nome }}</td>
                    <td>{{ $row->fiscal->nome }} {{ $row->fiscal->sobrenome }}</td>
                    <td style="background-color: {{ ($row->valor_pago >= $row->valor_total) ? '#00FF00' : '#ff0000' }};" >R$ {{ $row->valor_pago ? number_format($row->valor_pago,2,",",".") : '0,00'}}</td>
                    <td>R$ {{ $row->valor_total ? number_format($row->valor_total,2,",",".") : '0,00' }}</td>
                    <td>{{ $row->apontamentos }}</td>
                    <td>
                        <button type="button" class="btn btn-warning btn-xs" onclick="detalhes({{$row->id}})" title="Detalhes Medição"><i class="fa fa-search"></i></button>
                        <button type="button" class="btn btn-primary btn-xs" onclick="createValorPago({{$row->id}})" title="Adicionar Valor Recebido">&nbsp;<i class="fa fa-usd"></i>&nbsp;</button>
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

@includeIf('layouts.partials.modal', ['idModal' => 'modal-form-medicao', 'idContent' => 'content-modal-medicao' ])
@includeIf('layouts.partials.modal', ['idModal' => 'modal-form-valor-pago', 'idContent' => 'content-modal-valor-pago', 'typeModal' => 'modal-sm'])

@stop

@section('scripts-footer')
	<script type="text/javascript" src="{{ url('js/medicao.js') }}"></script>
@stop