@extends('layouts.default')

@section('main-content')
<div class="box">
    <div class="box-header page-header">
        <h1><i class="glyphicon glyphicon-menu-right"></i>Transferência Estoque</h1>
        {{ Form::hidden('_token', csrf_token(), ['id' => '_token'])}}
        <div id='alert' class="alert "></div>
        @if (notify()->ready())
            <script>
                showAlert('{{ notify()->type() }}', '{!! notify()->message() !!}');
            </script>
        @endif
    </div>
    <div class="box-body">
         <div class="col-md-12">
            {{ Form::open( ['action' => ('TransferenciaEstoqueController@selecionarEstoque') ]) }}
            
            <div class="row">
                <div class="col-md-3">
                    {{ Form::label('almoxarifado_origem_id', 'Almoxarifado Origem') }}
                    {{ Form::select('almoxarifado_origem_id', $almoxarifados, null, ['class' => 'form-control', 'id' => 'almoxarifado-origem']) }}
                </div>
                <div class="col-md-3">
                    {{ Form::label('obra_origem_id', 'Obra Origem') }}
                    {{ Form::select('obra_origem_id', [], null, ['class' => 'form-control', 'id' => 'obra-origem']) }}
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-md-3">
                    {{ Form::label('almoxarifado_destino_id', 'Almoxarifado Destino') }}
                    {{ Form::select('almoxarifado_destino_id', $almoxarifados, null, ['class' => 'form-control', 'id' => 'almoxarifado-destino']) }}
                </div>
                <div class="col-md-3">
                    {{ Form::label('obra_destino_id', 'Obra Destino') }}
                    {{ Form::select('obra_destino_id', [] ,null, ['class' => 'form-control', 'id' => 'obra-destino']) }}
                </div>
                <div class="col-md-2"> 
                    {{ Form::label('data', 'Data Transferência:') }}
                    {{ Form::text('data', null, ['class' => 'form-control', 'id' => 'data_transferencia']) }}
                </div>
            </div>
            <br />
            <div class="row">
                <div class="modal-footer">
                    {{ Form::button('Avançar <i style="margin-left:5px;" class="fa fa-chevron-circle-right"></i>', ['class' => 'btn btn-success', 'id' => 'btn-avancar', 'type' => 'submit' ]) }}
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