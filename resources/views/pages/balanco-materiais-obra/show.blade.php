@extends('layouts.default')

@section('main-content')

    <div class="box">
        <div class="box-header page-header">
            <h1><i class="glyphicon glyphicon-menu-right"></i>Balanço Materiais</h1>
            @include('layouts.partials.alert-notify')
        </div>
        <div class="box-body">
            {!! Form::hidden('obra_id', $obra->id) !!}
            <div class="panel" style="background: #f5f5f5;">
                <div class="panel-body">
                    <div class="form-inline">
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Número da Obra:</strong> {{$obra->numero_obra}}
                            </div>
                            <div class="col-md-4">
                                <strong>Data Abertura:</strong> {{$obra->data_abertura}}
                            </div>
                            <div class="col-md-4">
                                <strong>Data Recebimento:</strong> {{$obra->data_recebimento}}
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Cidade:</strong> {{$obra->cidade->nome}}
                            </div>
                            <div class="col-md-4">
                                <strong>Status da Obra:</strong> {{$obra->statusObra->nome}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(isset($balanco))
            <div class="btn-group">
                <button type="button" class="btn btn-gray dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Exportar <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="#" name="{{ $obra->id }}" id="btn-excel"><i class="fa fa-file-excel-o"></i> Excel</a></li>
                    <li><a href="#" name="{{ $obra->id }}" id='btn-pdf'><i class="fa fa-file-pdf-o"></i> Pdf</a></li>
                </ul>
            </div>
            <hr/>
            <table class="table table-bordered table-hover" id="table-balanco-materiais">
                <thead>
                    <tr style="margin-bottom: 3px; background: #f5f5f5;">
                        <th colspan="3" style="border-right: solid 2px #fff; text-align: center;">Material</th>
                        <th colspan="4" style="border-right: solid 2px #fff; text-align: center;">Movimento</th>
                        <th colspan="3" style="border-right: solid 2px #fff; text-align: center;">Transferência</th>
                    </tr>
                    <tr>
                        <th>Código</th>
                        <th>Descrição</th>
                        <th>Unid. Medida</th>
                        <th>Orçado</th>
                        <th>Entrada</th>
                        <th>Saída</th>
                        <th>Saldo</th>
                        <th>Trans. Entrada</th>
                        <th>Trans. Saída</th>
                        <th>Trans. Saldo</th>
                    </tr>
                </thead>
                <tbody style="cursor: pointer;">
                    @foreach($balanco as $row)
                     @php
                        $saldo = $row->entrada - $row->saida;
                        $saldotrans = $row->transferenciaent - $row->transferenciasai;
                    @endphp
                    @if($saldo > 0)
                    <tr class="text-yellow">
                    @else
                    @if($saldo == 0)
                    <tr class="text-green">
                    @else
                    <tr class="text-red">
                    @endif
                    @endif
                        <td style="display:none;">{{ $row->id }}</td>
                        <td>{{ $row->codigo }}</td>
                        <td>{{ $row->descricao }}</td>
                        <td>{{ $row->unidade }}</td>
                        <td>{{ $row->orcado}}</td>
                        <td>{{ $row->entrada }}</td>
                        <td>{{ $row->saida }}</td>
                        <td>{{ $saldo }}</td>
                        <td>{{ $row->transferenciaent }}</td>
                        <td>{{ $row->transferenciasai }}</td>
                        <td>{{ $saldotrans  }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else

                <h4 class="help-block"><center>Não há movimentações para esta obra</center> </h2>
            @endif
        </div>
        <div class="modal-footer">
            <a href="{{ url('/obra/gerenciador') }}" class="btn btn-default pull-left button">Voltar</a>
        </div>
    </div>
    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-materiais', 'idContent' => 'content-modal-materiais' ])
@stop

@section('scripts-footer')

    <script type="text/javascript" src="{{ url('js/balanco.js') }}"></script>
 
@stop
