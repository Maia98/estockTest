<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> {{ (isset($cidade)) ? 'Editar' : 'Adicionar' }} Cidade</h4>
</div>
@if(isset($cidade))
    {!! Form::model($cidade, ['action' => ('TipoSetorObraController@store'), 'id' => 'form-cidade']) !!}
@else
    {!! Form::open(['action' => ('TipoSetorObraController@store'), 'id' => 'form-cidade']) !!}
@endif
    <div class="modal-body">
        <div id='alert-modal2' class="alert" style="display: none;"></div>
        {!! Form::hidden('id', null) !!}
        {!! Form::label('nome', 'Nome:') !!}
        {!! Form::text('nome', null, ['class' => 'form-control']) !!}
        <br />
        <div class="input-group">
            {!! Form::label('regional_id', 'Regional:') !!}
            {!! Form::select('regional_id', arrayToSelect($regional , 'id', 'descricao'), null, ['class' => 'form-control', 'id' => 'regional_id']) !!}
            <span class="input-group-btn">
                <button type="button" onclick="createRegional();" class="btn btn-primary btn-flat" style="margin-top: 27px;"><i class="fa  fa-plus"></i></button>
            </span>
        </div>
    </div>
    <div class="modal-footer">
        {!! Form::button('Cancelar', ['class' => 'btn btn-default pull-left', 'id' => 'fechar-cidade']) !!}
        {!! Form::submit('Salvar', ['class' => 'btn btn-success', 'id' => 'salvar-cidade']) !!}
    </div>
{!! Form::close() !!}