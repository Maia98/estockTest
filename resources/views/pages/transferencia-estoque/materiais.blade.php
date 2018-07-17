@extends('layouts.default')

@section('main-content')
    <style>
        .select2-results__option {
            border-bottom: 1px solid #E2E2E2;
        }
    </style>
<div class="box">
    <div class="box-header page-header">
        <h1><i class="glyphicon glyphicon-menu-right"></i>Transferência Estoque</h1>
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
            {{ Form::open(['action' => ('TransferenciaEstoqueController@store'), 'id' => 'form-transferencia-material-estoque']) }}            
            <div class="row">
                <div class="col-md-3">
                    {{ Form::label('almoxarifado_origem_id', 'Almoxarifado Origem') }}
                    {{ Form::Text('', ($almoxarifadoOrigem) ? $almoxarifadoOrigem->nome : '', ['class' => 'form-control', 'disabled' => 'disabled']) }}
                    {{ Form::hidden('almoxarifado_origem_id', ($almoxarifadoOrigem) ? $almoxarifadoOrigem->id : 0, ['id' => 'almoxarifado-origem']) }}
                </div>
                <div class="col-md-3">
                    {{ Form::label('obra_origem_id', 'Obra Origem') }}
                    {{ Form::Text('', ($obraOrigem) ? $obraOrigem->numero_obra : 'Todos', ['class' => 'form-control', 'disabled' => 'disabled']) }}
                    {{ Form::hidden('obra_origem_id', ($obraOrigem) ? $obraOrigem->id : 0, ['id' => 'obra-origem']) }}
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-md-3">
                    {{ Form::label('almoxarifado_destino_id', 'Almoxarifado Destino') }}
                    {{ Form::Text('', ($almoxarifadoDestino) ? $almoxarifadoDestino->nome : '', ['class' => 'form-control', 'disabled' => 'disabled']) }}
                    {{ Form::hidden('almoxarifado_destino_id', ($almoxarifadoDestino) ? $almoxarifadoDestino->id : 0, ['id' => 'almoxarifado-destino']) }}
                </div>
                <div class="col-md-3">
                    {{ Form::label('obra_destino_id', 'Obra Destino') }}
                    {{ Form::Text('', ($obraDestino) ? $obraDestino->numero_obra : 'Todos', ['class' => 'form-control', 'disabled' => 'disabled']) }}
                    {{ Form::hidden('obra_destino_id', ($obraDestino) ? $obraDestino->id : 0, ['id' => 'obra-destino']) }}
                </div>
                <div class="col-md-2"> 
                    {{ Form::label('data', 'Data Transferência:') }}
                    {{ Form::text('data', null, ['class' => 'form-control', 'id' => 'data_transferencia', 'readonly' => 'readonly' ]) }}
                </div>
            </div>
            <br/><br/>
            <div class="row">
                <fieldset class="fsStyle" id="fildset-manual" style="margin: 13px 0px 0px 0px;">
                    <legend><strong>Materiais</strong></legend>
                    <div class="row">
                        <div class="col-md-8">
                            {{ Form::label('pesquisa', 'Material:') }}
                            {{ Form::select('pesquisa', [], null, ['class' => 'form-control', 'id' => 'select-materiais']) }}
                        </div>
                        <div class="col-md-2">
                            {{ Form::label('quantidade', 'Quantidade') }}
                            {{ Form::text('quantidade', null, ['class' => 'form-control', 'id' => 'quantidade']) }}
                        </div>
                        <div class="col-md-2">
                            <button type="button" id="add-material" class="btn btn-primary" style="margin-top: 24px;">
                                <i class="glyphicon glyphicon-plus"></i> Adicionar
                            </button>
                        </div>
                    </div>
                    <br>
                    <table class="table table-bordered" id="table_materiais">
                        {{ Form::hidden('materiais', null , ['id' => 'materiais-values']) }}
                        <thead>
                            <tr>
                                <th class="col-md-2">Obra Origem</th>
                                <th class="col-md-6">Material</th>
                                <th class="col-md-1">Quantidade</th>
                                <th class="col-md-2">Unidade Medida</th>
                                <th class="col-md-1">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="table-body-materiais">
                        </tbody>
                    </table>
                </fieldset>
            </div>
            <div class="row">
                <div class="modal-footer">
                    {{ Form::button('Salvar', ['class' => 'btn btn-success', 'id' => 'btn-avancar', 'type' => 'submit' ]) }}
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@stop

@section('scripts-footer')
    <script type="text/javascript" src="{{ url('js/transferencia-estoque.js') }}"></script>
@stop