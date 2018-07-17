<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> {{ (isset($empresa)) ? 'Editar' : 'Adicionar' }} Empresa</h4>
</div>


@if(isset($empresa))
    {!! Form::model($empresa, ['action' => ('EmpresaController@store'), 'id' => 'form-fab']) !!}
@else
    {!! Form::open(['action' => ('EmpresaController@store'), 'id' => 'form-fab']) !!}
@endif
    <div class="modal-body">

        {!! Form::hidden('id', null) !!}
        <div id='alert-modal' class="alert"></div>
        <fieldset>
            <legend>Dados pessoais</legend>
                <div class="row">
                    <div class="col-md-4">
                        {!! Form::label('cnpj', 'CNPJ:') !!}
                        {!! Form::text('cnpj', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-4">
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
                    <div class="col-md-4">
                        {!! Form::label('insc_estadual', 'Inscrição Estadual:') !!}
                        {!! Form::number('insc_estadual', null, ['class' => 'form-control', 'onkeypress' => 'return somenteNumero(this, event)', 'min' => 1]) !!}
                    </div>
                    <div class="col-md-8">
                        {!! Form::label('email', 'E-mail:') !!}
                        {!! Form::text('email', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </fieldset>
            <br><br>
            <fieldset>
                <legend>Endereço</legend>
                <div class="row">
                    <div class="col-md-3">
                        {!! Form::label('cep', 'CEP:') !!}
                        {!! Form::text('cep', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-7">
                        {!! Form::label('logradouro', 'Logradouro:') !!}
                        {!! Form::text('logradouro', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::label('numero', 'Nº:') !!}
                        {!! Form::text('numero', null, ['class' => 'form-control', 'id' => 'numero']) !!}
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-3">
                        {!! Form::label('complemento', 'Complemento:') !!}
                        {!! Form::text('complemento', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::label('bairro', 'Bairro:') !!}
                        {!! Form::text('bairro', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-4">
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
                    <div class="col-md-3">
                        {!! Form::label('telefone', 'Telefone:') !!}
                        {!! Form::text('telefone', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::label('celular', 'Celular:') !!}
                        {!! Form::text('celular', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </fieldset>
    </div>
    <div class="modal-footer">
        {!! Form::button('Cancelar', ['class' => 'btn btn-default pull-left', 'id' => 'fechar']) !!}
        {!! Form::submit('Salvar', ['class' => 'btn btn-success', 'id' => 'salvar-funcao']) !!}
    </div>
{!! Form::close() !!}
