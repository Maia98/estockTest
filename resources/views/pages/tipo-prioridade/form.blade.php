<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> {{ (isset($tipoPrioridade)) ? 'Editar' : 'Adicionar' }} Tipo Prioridade</h4>
</div>
@if(isset($tipoPrioridade))
    {!! Form::model($tipoPrioridade, ['action' => ('TipoPrioridadeController@store'), 'id' => 'form-tipo-prioridade']) !!}
@else
    {!! Form::open(['action' => ('TipoPrioridadeController@store'), 'id' => 'form-tipo-prioridade']) !!}
@endif
    <div class="modal-body">
        <div id='alert-modal' class="alert" style="display: none;"></div>
        {!! Form::hidden('id', null) !!}
        {!! Form::label('nome', 'Nome:') !!}
        {!! Form::text('nome', null, ['class' => 'form-control']) !!}
    </div>
    <div class="modal-footer">
        {!! Form::button('Cancelar', ['class' => 'btn btn-default pull-left', 'id' => 'fechar-tipo-prioridade']) !!}
        {!! Form::submit('Salvar', ['class' => 'btn btn-success', 'id' => 'salvar-tipo-prioridade']) !!}
    </div>
{!! Form::close() !!}
