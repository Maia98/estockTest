@extends('layouts.default')

@section('main-content')
<div class="box">
    <div class="box-header page-header">
        <h1><i class="glyphicon glyphicon-menu-right"></i>Entrada Estoque</h1>
        {{ Form::hidden('_token', csrf_token(), ['id' => '_token'])}}
        <div id='alert' class="alert "></div>
        @if (notify()->ready())
            <script>
                showAlert('{{ notify()->type() }}', '{{ notify()->message() }}');
            </script>
        @endif
    </div>
    <div class="box-body">
         <div class="col-md-12">
            @if(isset($entradaEstoque))
                {{ Form::model($entradaEstoque, ['action' => ('EntradaEstoqueController@store'), 'id' => 'form-entrada-estoque', 'files' => 'true']) }}
            @else
                {{ Form::open(['action' => ('EntradaEstoqueController@store'), 'id' => 'form-entrada-estoque', 'files' => 'true']) }}
            @endif
            <div class="row">
                <div class="col-md-3">
                    {{ Form::label('obra_id', 'Número Obra:') }}
                    {{ Form::select('obra_id',arrayToSelect($obras , 'id', 'numero_obra') ,null, ['class' => 'form-control', 'id' => 'num_obra']) }}
                </div>
                <div class="col-md-3">
                    {{ Form::label('data', 'Data Recebimento:') }}
                    {{ Form::text('data', null, ['class' => 'form-control', 'id' => 'data_recebimento']) }}
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        {{ Form::label('tipo_entrada_estoque_id', 'Tipo de Entrada:') }}
                        {{ Form::select('tipo_entrada_estoque_id',arrayToSelect($tipoEntradas , 'id', 'nome') ,null, ['class' => 'form-control', 'id' => 'tipo_entrada']) }}
                        <span class="input-group-btn">
                            <button type="button" onclick="createTipoEntrada();" class="btn btn-primary btn-flat" style="height: 35px;margin-top: 27px;"><i class="fa  fa-plus"></i></button>
                        </span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        {{ Form::label('funcionario_conferente_id', 'Conferente:') }}
                        {{ Form::select('funcionario_conferente_id',arrayToSelect($funcionarios , 'id', 'nome') ,null, ['class' => 'form-control', 'id' => 'conferente']) }}
                        <span class="input-group-btn">
                            <button type="button" onclick="createConferente();" class="btn btn-primary btn-flat" style="height: 35px;margin-top: 27px;"><i class="fa  fa-plus"></i></button>
                        </span>
                    </div>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        {{ Form::label('almoxarifado_id', 'Almoxarifado:') }}
                        {{ Form::select('almoxarifado_id',arrayToSelect($almoxarifados , 'id', 'nome') ,null, ['class' => 'form-control', 'id' => 'almoxarifados']) }}
                        <span class="input-group-btn">
                            <button type="button" onclick="createAlmoxarifado();" class="btn btn-primary btn-flat" style="height: 35px;margin-top: 27px;"><i class="fa  fa-plus"></i></button>
                        </span>
                    </div>
                    <br/>
                    <fieldset class="fsStyle" style="margin: 13px 0px 0px 0px;">
                    <legend><strong>Escolha a forma de Entrada </strong></legend>
                        <div style="margin: 10px 0px 0px 20px;">
                            {{ Form::select('metodo_entrada', ['0' => 'Selecione', '1' => 'Manual', '2' => 'Planilha Excel Unica Obra', '3' => 'Planilha Excel Várias Obras'] ,null, ['class' => 'form-control', 'id' => 'metodo_entrada']) }}
                        </div>
                        <div id="opcaoEntradaExcel" class="form-group" style="margin: 10px 0px 0px 20px; display: none;">
                            {{ Form::file('arquivo', ['accept' => '.xls, .xlsx', 'id' => 'arquivo']) }}
                        </div>
                    </fieldset>
                </div>
                <div class="col-md-6">
                    {{ Form::label('obs', 'Observações:') }}
                    {{ Form::textarea('obs', null, ['class' => 'form-control', 'rows' => '7']) }}
                </div>
            </div>
            <br/>
            <fieldset class="fsStyle" id="fildset-manual" style="margin: 13px 0px 0px 0px; display: none;">
                <legend><strong>Entrada Estoque Manual </strong></legend>
                <div class="row" style="margin: 10px 0px 0px 3px;">
                    <div class="col-md-8">
                        <div class="input-group">
                            {{ Form::label('pesquisa', 'Campo de Pesquisa:') }}
                            {{ Form::select('pesquisa',arrayToSelect($tipoMateriais , 'id', 'descricao') ,null, ['class' => 'form-control', 'id' => 'select_materiais']) }}
                            <span class="input-group-btn">
                                <button type="button" onclick="createTipoMaterial();" class="btn btn-primary btn-flat" style="margin-top: 24px;"><i class="fa  fa-plus"></i></button>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        {{ Form::label('quantidade', 'Quantidade') }}
                        {{ Form::text('quantidade', null, ['class' => 'form-control', 'id' => 'quantidade', 'onkeypress' => 'return somenteNumeros(this, event)']) }}
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-primary" onclick="addMateriais();" style="margin-top: 24px;"><i class="glyphicon glyphicon-plus"></i> Adicionar</button>
                    </div>
                </div>
                <br>
                <table class="table table-bordered" style="margin-left: 10px;" id="table_materiais">
                    {{ Form::hidden('materiais', null, ['id' => 'materiais_tb'])}}
                    <thead>
                        <tr>
                            <th class="col-md-4">Cód-Descrição</th>
                            <th class="col-md-1">Quantidade</th>
                            <th class="col-md-1">Unidade Medida</th>
                            <th class="col-md-1">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </fieldset>
            <br>
            <div class="row">
                <div class="col-md-1 pull-right" style="margin-right: 10px;">
                {{ Form::submit('Avançar', ['class' => 'btn btn-success', 'id' => 'btn-avancar']) }}
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

@includeIf('layouts.partials.modal', ['idModal' => 'modal-conferir-materiais', 'idContent' => 'content-modal-conferir-materiais', 'typeModal' => 'modal-lg'])
@includeIf('layouts.partials.modal', ['idModal' => 'modal-form-tipo-material', 'idContent' => 'content-modal-tipo-material', 'typeModal' => 'modal-lg'  ])
@includeIf('layouts.partials.modal', ['idModal' => 'modal-form-tipo-unidade-medida', 'idContent' => 'content-modal-tipo-unidade-medida' ]) 
@includeIf('layouts.partials.modal', ['idModal' => 'modal-form-almoxarifado', 'idContent' => 'content-modal-almoxarifado' ])
@includeIf('layouts.partials.modal', ['idModal' => 'modal-form-funcionario', 'idContent' => 'content-modal-funcionario' ])
@includeIf('layouts.partials.modal', ['idModal' => 'modal-form-tipo-entrada', 'idContent' => 'content-modal-tipo-entrada' ])
@includeIf('layouts.partials.modal', ['idModal' => 'modal-form-cidade', 'idContent' => 'content-modal-cidade' ])
@includeIf('layouts.partials.modal', ['idModal' => 'modal-form-regional', 'idContent' => 'content-modal-regional' ])

@stop

@section('scripts-footer')

    <script type="text/javascript" src="{{ url('js/tabelas-tipos/regional.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/tabelas-tipos/cidade.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/tabelas-tipos/almoxarifado.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/tabelas-tipos/funcionario.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/tabelas-tipos/tipo-entrada.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/entrada-estoque.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/tabelas-tipos/tipo-unidade-medida.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/tabelas-tipos/tipo-material.js') }}"></script>

@stop