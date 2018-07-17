@extends('layouts.default')

@section('main-content')
<div class="box">
    <div class="box-header page-header">
        <h1><i class="glyphicon glyphicon-menu-right"></i>{{isset($obra) ? 'Editar ' : 'Cadastrar ' }} Obra</h1>
        <div id='alert' class="alert "></div>
    </div>
    <div class="box-body">
        @if(isset($obra))
            {!! Form::model($obra, ['action' => ('ObraController@store'), 'id' => 'form-obra', 'files' => 'true']) !!}
        @else
            {!! Form::open(['action' => ('ObraController@store'), 'id' => 'form-obra', 'files' => 'true']) !!}
        @endif
        {!! Form::hidden('id', null) !!}
        {{ Form::hidden('_token', csrf_token(), ['id' => '_token'])}}
        
        <fieldset class="fsStyle">
            <legend class="legendStyle"><strong>Dados da Obra</strong></legend>
            <div class="row">
                <div class="col-md-3">
                    {!! Form::label('numero_obra', 'Número Obra:') !!}
                    {!! Form::text('numero_obra', null, ['class' => 'form-control', 'onkeypress' => 'return somenteNumero(this, event)', 'maxLength' => 12]) !!}
                </div>
                <div class="col-md-3">
                    {!! Form::label('tipo_setor_obra_id', 'Setor:') !!}
                    <div class="input-group">
                        {!! Form::select('tipo_setor_obra_id', arrayToSelect($setorObra , 'id', 'descricao') ,null, ['class' => 'form-control', 'id' => 'select_setor']) !!}
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-flat" onclick="createSetorObra();"><i class="fa fa-plus"></i></button>
                        </span>
                    </div>
                </div>
                <div class="col-md-3">
                    {!! Form::label('data_abertura', 'Data Abertura:') !!}
                    {!! Form::text('data_abertura', null, ['class' => 'form-control', 'id' => 'input_data_abertura']) !!}
                </div>
                <div class="col-md-3">
                    {!! Form::label('data_recebimento', 'Data Recebimento:') !!}
                    {!! Form::text('data_recebimento', null, ['class' => 'form-control', 'id' => 'input_data_recebimento']) !!}

                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-3">
                    {!! Form::label('cidade_id', 'Cidade:') !!}
                    <div class="input-group">
                        {!! Form::select('cidade_id', arrayToSelect($cidades , 'id', 'nome') ,null, ['class' => 'form-control', 'id' => 'select_cidade']) !!}
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-flat" onclick="createCidade();"><i class="fa fa-plus"></i></button>
                        </span>
                    </div>
                </div>
                <div class="col-md-3">
                    {!! Form::label('tipo_prioridade_obra_id', 'Prioridade:') !!}
                    <div class="input-group">
                        {!! Form::select('tipo_prioridade_obra_id', arrayToSelect($prioridadeObra , 'id', 'nome') ,null, ['class' => 'form-control', 'id' => 'select_prioridade']) !!}
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-flat" onclick="createTipoPrioridade();"><i class="fa fa-plus"></i></button>
                        </span>
                    </div>
                </div>
                <div class="col-md-3">
                    {!! Form::label('prazo_execucao_inicio', 'Início Execução:') !!}
                    {!! Form::text('prazo_execucao_inicio', null, ['class' => 'form-control', 'id' => 'input_prazo_execucao_inicio']) !!}
                </div>
                <div class="col-md-3">
                    {!! Form::label('prazo_execucao_fim', 'Término Execução:') !!}
                    {!! Form::text('prazo_execucao_fim', null, ['class' => 'form-control', 'id' => 'input_prazo_execucao_fim']) !!}
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-md-3">
                    {!! Form::label('tipo_obra_id', 'Tipo:') !!}
                    <div class="input-group">
                        {!! Form::select('tipo_obra_id', arrayToSelect($tipoObra , 'id', 'descricao') ,null, ['class' => 'form-control', 'id' => 'select_tipo_obra']) !!}
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-primary btn-flat" onclick="createTipoObra();"><i class="fa fa-plus"></i></button>
                        </span>
                    </div>
                </div>
                <div class="col-md-3">
                    {!! Form::label('tipo_status_obra_id', 'Status Obra:') !!}
                    <div class="input-group">
                    {!! Form::select('tipo_status_obra_id', arrayToSelect($statusObra , 'id', 'nome') , null, ['class' => 'form-control', 'id' => 'select_status_obra']) !!}
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-primary btn-flat" 
                                onclick="createStatusObra();"><i class="fa fa-plus"></i></button>
                        </span>
                    </div>
                </div>
                <div class="col-md-3">
                    {!! Form::label('data_previsao_retirada_material', 'Previsão Ret. Material:') !!}
                    {!! Form::text('data_previsao_retirada_material', null, ['class' => 'form-control', 'id' => 'input_previsao_retirada_material']) !!}
                </div>
                <div class="col-md-3"> 
                    {!! Form::label('valor_orcado', 'Valor Orçado:') !!}
                    <div class="input-group">
                        <span class="input-group-addon">R$</span>
                        {!! Form::text('valor_orcado', null, ['step' => 'any', 'class' => 'form-control', 'onkeypress' => 'return somenteDouble(this, event)', 'min' => 1, 'id' => 'valor_orcado']) !!}
                    </div>
                </div>
            </div>
        </fieldset>
        <br>
        <div class="row">
            <div class="col-md-6">
                <fieldset class="fsStyle"  style="height: 289px;">
                    <legend><strong>Apoio</strong></legend>
                    {!! Form::label('apoio_execucao', 'Apoio Execução:') !!}
                    <div class="input-group">
                        {!! Form::select('apoio_execucao', arrayToSelect($apoios , 'id', 'descricao') ,null, ['class' => 'form-control', 'id' => 'select_apoio']) !!}
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-flat" onclick="createApoio();"><i class="fa fa-plus"></i></button>
                            <button type="button" class="btn btn-primary btn-flat" style="margin-left: 10px;" onclick="addApoio();"><i class="fa  fa-plus"></i> Adicionar</button>
                      </span>
                    </div>
                    <br />
                    <div style="height: 180px; overflow-y: auto;">
                        <table class="table table-bordered" id="table_apoio">
                            <thead>
                                <tr>
                                    <th>Apoio</th>
                                    <th style="width: 100px;">Ações</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if(isset($obra) && $obra->apoio)

                                    @foreach ($obra->apoio as $apoios)
                                        <tr id="{{$apoios->apoio->id}}">
                                            <td>{{ $apoios->apoio->descricao}}</td>
                                            <td style="width: 45px">
                                                <button type="button"  class="btn btn-danger btn-xs" onclick="deletarApoio('{{$apoios->apoio->id}}')">
                                                    <i class="glyphicon glyphicon-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>

                        </table>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-6">
                <fieldset class="fsStyle">
                    <legend><strong>Importar</strong></legend>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <strong>Material Orçado</strong>
                            </div>
                            <div class="col-md-6" id="materialOrcado">
                                {{ Form::file('arquivo', ['accept' => '.xls, .xlsx', 'id' => 'arquivo']) }}
                            </div>
                            <div class="col-md-6" style="margin-top: 10px;">
                            @if(isset($materialOrcado) && count($materialOrcado) > 0)
                                <span class="text-yellow">Lista já importada.</span>
                            @endif
                            </div>
                        </div>
                    </div>
                </fieldset>
                <br />
                <div class="col-md-12">
                    {!! Form::label('medidor', 'Descrição Medidor:', ['style' => 'font-family: Verdana, Arial, sans-serif; font-size: small;']) !!}
                    {!! Form::textArea('medidor', null, ['class' => 'form-control', 'rows' => 7]) !!}
                </div>
            </div>
        </div>
        <br />
        <br />
        <div class="row">
            <div class="col-md-6">
                <fieldset class="fsStyle" style="height: 393px;">
                    <legend><strong>Responsável</strong></legend>
                    {!! Form::label('funcionario_supervisor_id', 'Supervisor:') !!}
                    <div class="input-group">
                        {!! Form::select('funcionario_supervisor_id', arrayToSelect($supervisores , 'id', 'nome') ,null, ['class' => 'form-control', 'id' => 'funcionario_supervisor']) !!}
                        <span class="input-group-btn">
                          <button type="button" class="btn btn-primary btn-flat" onclick="createFuncionario();"><i class="fa  fa-plus"></i></button>
                        </span>
                    </div>

                    <br>
                    {!! Form::label('funcionario_fiscal_id', 'Fiscal:') !!}
                    <div class="input-group">
                        {!! Form::select('funcionario_fiscal_id',  arrayToSelect($fiscais , 'id', 'nome') ,null, ['class' => 'form-control', 'id' => 'funcionario_fiscal']) !!}
                        <span class="input-group-btn">
                          <button type="button" class="btn btn-primary btn-flat" onclick="createFuncionario();"><i class="fa  fa-plus"></i></button>
                      </span>
                    </div>

                    <br>
                    
                    {!! Form::label('encarregados', 'Encarregado:') !!}
                    <div class="input-group">
                        {!! Form::select('encarregados',  arrayToSelect($encarregados , 'id', 'nome') ,null, ['class' => 'form-control', 'id' => 'select_encarregado']) !!}
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-flat" onclick="createFuncionario();"><i class="fa  fa-plus"></i></button>
                            <button type="button" class="btn btn-primary btn-flat" onclick="addEncarregado();" style="margin-left: 10px"><i class="fa fa-plus"></i> Adicionar</button>
                        </span>
                    </div>
                    <br />
                    <div style="height: 130px; overflow-y: auto;">
                        <table class="table table-bordered" id="table_encarregado">
                            <thead>
                                <tr>
                                    <th>Encarregado</th>
                                    <th style="width: 100px;">Ações</th>
                                </tr>
                            </thead> 
                            <tbody>
                                @if(isset($obra) && $obra->encarregado)
                                       
                                    @foreach ($obra->encarregado as $encarregados)
                                        <tr id="{{$encarregados->encarregado->id}}">
                                            
                                            <td class="col-md-10">{{ $encarregados->encarregado->nome}} {{ $encarregados->encarregado->sobrenome}}</td>
                                            <td style="width: 45px">
                                                <button type="button" class="btn btn-danger btn-xs" onclick="deletarEncarregado('{{$encarregados->encarregado->id}}')"><i class="glyphicon glyphicon-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-6" style="margin-top: -25px;">
                <div class="col-md-12">
                    {!! Form::label('instalacao', 'Descrição Instalação:', ['style' => 'font-family: Verdana, Arial, sans-serif; font-size: small;']) !!}
                    {!! Form::textArea('instalacao', null, ['class' => 'form-control', 'rows' => 7]) !!}
                </div>
                <div style="clear:both;"></div>
                <br />
                <div class="col-md-12">
                    {!! Form::label('observacao', 'Observações:', ['style' => 'font-family: Verdana, Arial, sans-serif; font-size: small;']) !!}
                    {!! Form::textArea('observacao', null, ['class' => 'form-control', 'rows' => 7]) !!}
                </div>
            </div>

        </div>
        <br />
        <div class="pull-right">
            {!! Form::submit('Salvar', ['class' => 'btn btn-success', 'id' => 'salvar-obra']) !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>
    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-tipo-setor-obra', 'idContent' => 'content-modal-tipo-setor-obra' ])

    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-cidade', 'idContent' => 'content-modal-cidade' ])

    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-regional', 'idContent' => 'content-modal-regional' ])

    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-tipo-prioridade', 'idContent' => 'content-modal-tipo-prioridade' ])

    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-tipo-apoio', 'idContent' => 'content-modal-tipo-apoio' ])

    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-funcionario', 'idContent' => 'content-modal-funcionario' ])

    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-tipo-obra', 'idContent' => 'content-modal-tipo-obra' ])

    @includeIf('layouts.partials.modal', ['idModal' => 'modal-form-status-obra', 'idContent' => 'content-modal-status-obra' ])
@stop

@section('scripts-footer')
    <script type="text/javascript" src="{{ asset('js/tabelas-tipos/tipo-setor-obra.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/tabelas-tipos/cidade.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/tabelas-tipos/regional.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/tabelas-tipos/tipo-prioridade.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/tabelas-tipos/tipo-apoio.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/tabelas-tipos/funcionario.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/obra.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/tabelas-tipos/tipo-obra.js') }}"></script>
     <script type="text/javascript" src="{{ url('js/tabelas-tipos/status-obra.js') }}"></script>
@stop