@extends('layouts.default')

@section('main-content')

    <div class="box">
        <div class="box-header page-header">
            <h1><i class="glyphicon glyphicon-menu-right"></i>Detalhes Transferência</h1>
            @include('layouts.partials.alert-notify')
        </div>
        <div class="box-body">
            <div class="panel" style="background: #f5f5f5;">
                <div class="panel-body">
                    <div class="form-inline">
                        <div class="row">
                            {!! Form::open(['action' => ('TransferenciaEstoqueController@gerenciador'), 'id' => 'form', 'method' => 'GET']) !!}
                            <div class="col-md-4">
                                <strong>Almoxarifado Destino: </strong>{{ $transferencia->almoxarifadoDestino->nome   }}
                            </div>
                            <div class="col-md-4">
                                <strong>Obra Destino: </strong>{{ $transferencia->obraDestino->numero_obra }}
                            </div>
                            <div class="col-md-4">
                                <strong>Data Transferência: </strong>{{ dateToView($transferencia->data) }}
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Usuário: </strong>{{ $transferencia->usuario->name }}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-gray dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Exportar <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('/transferencia-estoque/detalhes/exportar-excel') .'/'. $transferencia->id }}" id="btn-excel"><i class="fa fa-file-excel-o"></i> Excel</a></li>
                    <li><a href="{{ url('/transferencia-estoque/detalhes/exportar-pdf') .'/'. $transferencia->id }}" id='btn-pdf'  target="_blank" ><i class="fa fa-file-pdf-o"></i> Pdf</a></li>
                </ul>
            </div>
            <hr/>
            <div class="table-responsive">
                <table class="table table-bordered" style="margin-bottom: 3px; background: #f5f5f5;">
                    <thead>
                    <tr>
                        <th width="19%" style="border-right: solid 2px #fff;"><center>Origem</center></th>
                        <th width="7.1%" style="border-right: solid 2px #fff;"><center>Destino</center></th>
                        <th width="6.4%"><center>Saldo</center></th>
                    </tr>
                    </thead>
                </table>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Almoxarifado</th>
                        <th>Nº Obra</th>
                        <th>Código</th>
                        <th>Material</th>
                        <th>Unidade</th>
                        <th>Qtde. Origem</th>
                        <th>Qtde. Destino</th>
                        <th>Qtde. Transferida</th>
                        <th>Saldo Origem</th>
                        <th>Saldo Destino</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($materiaisTransferencia as $materiais)
                        <tr>
                            <td>{{ $transferencia->almoxarifadoOrigem->nome }}</td>
                            <td>{{ $materiais->obraOrigem->numero_obra }} </td>
                            <td>{{ $materiais->material->codigo }}</td>
                            <td>{{ $materiais->material->descricao }}</td>
                            <td>{{ $materiais->material->unidade->codigo }}</td>
                            <td>{{ $materiais->qtde_obra_origem }}</td>
                            <td>{{ $materiais->qtde_obra_destino }}</td>
                            <td>{{ $materiais->qtde }}</td>
                            <td>{{ $materiais->qtde_obra_origem - $materiais->qtde }}</td>
                            <td>{{ $materiais->qtde_obra_destino + $materiais->qtde }}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>

            </div>
            <br>
            <div class="row">
                <div class="col-md-9">
                    <a href="/transferencia-estoque/gerenciador" style="text-decoretion:none; color:#515151;"><button type="button" class="btn btn-gray"><i class="fa fa-chevron-left"></i> &nbsp; Voltar</button></a>
                </div>
            </div>

        </div>
    </div>

@stop

@section('scripts-footer')

@stop