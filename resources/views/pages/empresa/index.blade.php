@extends('layouts.default')

@section('main-content')
	<div class="box">
        <div class="box-header page-header">
            <h1><i class="glyphicon glyphicon-menu-right"></i>Empresa</h1>
            @include('layouts.partials.alert-notify')
        </div>
        <div id='alert-modal' class="alert"></div>
        @if (notify()->ready())
            <script>
                showAlert('{!! notify()->type() !!}', '{!! notify()->message() !!}');
            </script>
        @endif
        <div class="box-body">
            @if(isset($empresa))
                {!! Form::model($empresa, ['action' => ('EmpresaController@store'), 'id' => 'form-empresa', 'files' => true]) !!}
            @else
                {!! Form::open(['action' => ('EmpresaController@store'), 'id' => 'form-empresa', 'files' => true]) !!}
            @endif
                {!! Form::hidden('id', null) !!}
                <fieldset>
                    <legend>Dados pessoais</legend>
                    <div class="row">
                        <div class="col-md-2">
                            {!! Form::label('cnpj', 'CNPJ:') !!}
                            {!! Form::text('cnpj', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-5">
                            {!! Form::label('razao_social', 'Razão Social:') !!}
                            {!! Form::text('razao_social', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-4">
                            {!! Form::label('nome_fantasia', 'Nome Fantasia:') !!}
                            {!! Form::text('nome_fantasia', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2">
                            {!! Form::label('insc_estadual', 'Inscrição Estadual:') !!}
                            {!! Form::number('insc_estadual', null, ['class' => 'form-control', 'min' => 1]) !!}
                        </div>

                        <div class="col-md-5" style="margin-right: 15px;">
                            {!! Form::label('email', 'E-mail:') !!}
                            {!! Form::text('email', null, ['class' => 'form-control']) !!}
                        </div>

                        <fieldset style="width: 328px;">
                            <legend>Importar Logo:</legend>
                            <div class="col-md-4">
                                @if($image)
                                    <img src="{{ asset('storage/imagens/empresa/'.$image)}}" style="max-width:280px;max-height:120px;margin-bottom:15px;" />
                                @endif
                                {!! Form::file('image', ['accept'=>'image/*', 'multiple'=>true, 'id'=>'image']) !!}
                            </div>
                        </fieldset>
                    </div>
                </fieldset>
                <br><br>
                <fieldset>
                    <legend>Endereço</legend>
                    <div class="row">
                        <div class="col-md-2">
                            {!! Form::label('cep', 'CEP:') !!}
                            {!! Form::text('cep', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-7">
                            {!! Form::label('logradouro', 'Logradouro:') !!}
                            {!! Form::text('logradouro', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-2">
                            {!! Form::label('numero', 'Nº:') !!}
                            {!! Form::number('numero', null, ['class' => 'form-control', 'id' => 'numero', 'maxlength' => '5', 'min' => '0']) !!}
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2">
                            {!! Form::label('complemento', 'Complemento:') !!}
                            {!! Form::text('complemento', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-2">
                            {!! Form::label('bairro', 'Bairro:') !!}
                            {!! Form::text('bairro', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-5">
                            {!! Form::label('cidade', 'Cidade:') !!}
                            {!! Form::text('cidade', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-2">
                            {!! Form::label('uf_id', 'UF:') !!}
                            {!! Form::select('uf_id', $estado, null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-2">
                            {!! Form::label('telefone', 'Telefone:') !!}
                            {!! Form::text('telefone', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-2">
                            {!! Form::label('celular', 'Celular:') !!}
                            {!! Form::text('celular', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </fieldset>
                <div class="modal-footer">
                    {!! Form::submit('Salvar', ['class' => 'btn btn-success', 'id' => 'salvar-funcao']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div> 

@stop

@section('scripts-footer')
    <script type="text/javascript" src="{{ url('js/tabelas-tipos/empresa.js') }}"></script>
@stop