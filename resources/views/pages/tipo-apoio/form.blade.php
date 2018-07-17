<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> {{ (isset($tipoApoio)) ? 'Editar' : 'Adicionar' }} Tipo Apoio</h4>
</div>
@if(isset($tipoApoio))
    {!! Form::model($tipoApoio, ['action' => ('TipoApoioController@store'), 'id' => 'form-tipo-apoio']) !!}
@else
    {!! Form::open(['action' => ('TipoApoioController@store'), 'id' => 'form-tipo-apoio']) !!}
@endif
    <div class="modal-body">
        <div id='alert-modal' class="alert" style="display: none;"></div>
        {!! Form::hidden('id', null) !!}
        {!! Form::label('nome', 'Nome:') !!}
        {!! Form::text('nome', null, ['class' => 'form-control']) !!}
        <br />
        {!! Form::label('descricao', 'Descrição:') !!}
        {!! Form::text('descricao', null, ['class' => 'form-control']) !!}
    </div>
    <div class="modal-footer">
        {!! Form::button('Cancelar', ['class' => 'btn btn-default pull-left', 'id' => 'fechar-tipo-apoio']) !!}
        {!! Form::submit('Salvar', ['class' => 'btn btn-success', 'id' => 'salvar-funcao']) !!}
    </div>
{!! Form::close() !!}
