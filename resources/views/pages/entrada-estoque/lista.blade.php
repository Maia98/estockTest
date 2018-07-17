@extends('layouts.default')

@section('main-content')

    <div class="box">
        <div class="box-header page-header">
            <h1><i class="glyphicon glyphicon-menu-right"></i>Lista Entrada de Materiais</h1>
            @include('layouts.partials.alert-notify')
        </div>
        <div class="box-body">
            <div style="background-color:#f5f5f5; padding: 7px 7px 7px 7px">
                <div class="row">
                    <div class="col-md-4">
                        <span><strong>Número da Obra: &nbsp;</strong> {{ $entrada->obra->numero_obra }} </span>
                    </div>

                    <div class="col-md-4">
                        <span><strong>Tipo Entrada: &nbsp;</strong> {{ $entrada->tipoEntrada->nome }} </span>
                    </div>

                    <div class="col-md-4">
                        <span><strong>Data recebimento: &nbsp;</strong> {{ date_format($date = new DateTime($entrada->data),'d/m/Y') }} </span>
                    </div>
                </div>

                <br/>

                <div class="row">
                    <div class="col-md-4">
                        <span><strong>Conferente: &nbsp;</strong> {{ $entrada->conferente->nome }} {{ $entrada->conferente->sobrenome }} </span>
                    </div>

                    <div class="col-md-4">
                        <span><strong>Usuário Cadastrado: &nbsp;</strong> {{ $entrada->usuario->name }} </span>
                    </div>

                    <div class="col-md-4">
                        <span><strong>Almoxarifado: &nbsp;</strong> {{ $entrada->almoxarifado->nome }} </span>
                    </div>
                </div>

                <br/>

                <div class="row">
                    <div class="col-md-12">
                        <span><strong>Observações: &nbsp;</strong> {!! $entrada->obs  !!}</span>
                        <button type="button" class="btn btn-primary btn-xs" onclick="addObs({{ $entrada->id }})"> <i class="fa fa-commenting-o"></i></button>
                    </div>
                </div>
            </div>
            <br/><br/>
            <div class="row">
                <div class="col-md-8">
                    <div class="btn-group">
                        <button type="button" class="btn btn-gray dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Exportar <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" id="btn-excel"><i class="fa fa-file-excel-o"></i> Excel</a></li>
                            <li><a href="#" id='btn-pdf'><i class="fa fa-file-pdf-o"></i> Pdf</a></li>
                        </ul>
                    </div>
                </div>
                {!! Form::open(['action' => ('ListaEntradaMateriaisController@index'), 'id' => 'form', 'method' => 'GET']) !!}
                <div class="col-md-4">
                    <div class="input-group">
                        {!! Form::hidden('id', $entrada->id)!!}
                        {!! Form::text('filtro_input', null, ['class' => 'form-control', 'placeholder' => 'Filtrar...']) !!}
                        <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary btn-flat btn_icon_filter"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span></button>
                        </span>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>

            <br/>

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Descrição</th>
                                <th>RMA</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($result as $row)
                            <tr>
                                <td> {{ $row->tipoMaterial->codigo }} </td>
                                <td> {{ $row->tipoMaterial->descricao }} </td>
                                <td> {{ $row->qtde }} </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <a href="{{ url('/entrada-estoque/gerenciador') }}" class="btn btn-default pull-left button">Voltar</a>
        </div>
    </div>

    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-obs', 'idContent' => 'content-modal-obs' ])
@stop

@section('scripts-footer')

    <script type="text/javascript" src="{{ url('js/tabelas-tipos/lista-entrada-materiais.js') }}"></script>
 
@stop