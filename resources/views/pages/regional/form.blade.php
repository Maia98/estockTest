<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> {{ (isset($regional)) ? 'Editar' : 'Adicionar' }} Cadastro Regional </h4>
</div>
@if(isset($regional))
    {!! Form::model($regional, ['action' => ('RegionalController@store'), 'id' => 'form-regional']) !!}
@else
    {!! Form::open(['action' => ('RegionalController@store'), 'id' => 'form-regional']) !!}
@endif
    <div class="modal-body">
        <div id='alert-modal3' class="alert" style="display: none;"></div>
        {!! Form::hidden('id', null) !!}
        {!! Form::label('descricao', 'Descrição:') !!}
        {!! Form::text('descricao', null, ['class' => 'form-control']) !!}
    </div>
    <div class="modal-footer">
        {!! Form::button('Cancelar', ['class' => 'btn btn-default pull-left', 'id' => 'fechar']) !!}
        {!! Form::submit('Salvar', ['class' => 'btn btn-success', 'id' => 'salvar-funcao-regional']) !!}
    </div>
{!! Form::close() !!}
