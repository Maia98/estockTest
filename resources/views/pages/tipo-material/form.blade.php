<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> {{ (isset($tipoMaterial)) ? 'Editar' : 'Adicionar' }} Tipo Material</h4>
</div>
@if(isset($tipoMaterial))
    {!! Form::model($tipoMaterial, ['action' => ('TipoMaterialController@store'), 'id' => 'form-tipo-material']) !!}
@else
    {!! Form::open(['action' => ('TipoMaterialController@store'), 'id' => 'form-tipo-material']) !!}
@endif
    <div class="modal-body">
        <div id='alert-modal2' class="alert" style="display: none;"></div>
        {!! Form::hidden('id', null) !!}
        {!! Form::hidden('unidade_reload', 'reload')!!}
        <div class="row">
            <div class="col-md-3">
                {!! Form::label('codigo', 'Código:') !!}
                {!! Form::number('codigo', null, ['class' => 'form-control', 'onkeypress' => 'return somenteNumero(this, event)', 'min' => 1]) !!}
            </div>
            <div class="col-md-6">
                {!! Form::label('descricao', 'Descrição:') !!}
                {!! Form::text('descricao', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    {!! Form::label('tipo_unidade_medida_material_id', 'Unid. Medida:') !!}
                    {!! Form::select('tipo_unidade_medida_material_id',  arrayToSelect($tipoUnidade, 'id', 'codigo'), null, ['class' => 'form-control', 'id' => 'unidades']) !!}
                    <span class="input-group-btn">
                        <button type="button" onclick="createUnidade();" class="btn btn-primary btn-flat" style="margin-top: 27px;"><i class="fa  fa-plus"></i></button>
                    </span>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-3">
                {!! Form::label('constante_material', 'Constante:') !!}
                {!! Form::text('constante_material', null, ['id' => 'constante_material', 'class' => 'form-control', 'maxlength' => '25']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('valor_material', 'Valor:') !!}
                {!! Form::text('valor_material', null, ['id' => 'valor_material', 'class' => 'form-control', 'maxlength' => '25']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('qtde_minima', 'Qtde. Mínima:') !!}
                {!! Form::number('qtde_minima', null, ['class' => 'form-control', 'onkeypress' => 'return somenteNumero(this, event)', 'min' => 1]) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('qtde_critica', 'Qtde. Crítica:') !!}
                {!! Form::number('qtde_critica', null, ['class' => 'form-control', 'onkeypress' => 'return somenteNumero(this, event)', 'min' => 1]) !!}
            </div>
        </div>
    </div>
    <div class="modal-footer">
        {!! Form::button('Cancelar', ['class' => 'btn btn-default pull-left', 'id' => 'fechar-tipo-material']) !!}
        {!! Form::submit('Salvar', ['class' => 'btn btn-success', 'id' => 'salvar-tipo-material']) !!}
    </div>
{!! Form::close() !!}
