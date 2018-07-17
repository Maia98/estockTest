<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> {{ (isset($tipoObra)) ? 'Editar' : 'Adicionar' }} Tipo Obra</h4>
</div>
@if(isset($tipoObra))
    {!! Form::model($tipoObra, ['action' => ('TipoObraController@store'), 'id' => 'form-tipo-obra']) !!}
@else
    {!! Form::open(['action' => ('TipoObraController@store'), 'id' => 'form-tipo-obra']) !!}
@endif
    <div class="modal-body">
        <div id='alert-modal' class="alert" style="display: none;"></div>
        {!! Form::hidden('id', null) !!}
        {!! Form::label('descricao', 'Descrição:') !!}
        {!! Form::text('descricao', null, ['class' => 'form-control']) !!}
    </div>
    <div class="modal-footer">
        {!! Form::button('Cancelar', ['class' => 'btn btn-default pull-left', 'id' => 'fechar-tipo-obra']) !!}
        {!! Form::submit('Salvar', ['class' => 'btn btn-success', 'id' => 'salvar-tipo-obra']) !!}
    </div>
{!! Form::close() !!}
