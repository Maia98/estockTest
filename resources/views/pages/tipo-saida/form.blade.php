<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> {{ (isset($tipoSaida)) ? 'Editar' : 'Adicionar' }} Tipo Saída</h4>
</div>
@if(isset($tipoSaida))
    {!! Form::model($tipoSaida, ['action' => ('TipoSaidaController@store'), 'id' => 'form-tipo-saida']) !!}
@else
    {!! Form::open(['action' => ('TipoSaidaController@store'), 'id' => 'form-tipo-saida']) !!}
@endif
    <div class="modal-body">
        <div id='alert-modal' class="alert" style="display: none;"></div>
        {!! Form::hidden('id', null) !!}
        {!! Form::label('nome', 'Nome:') !!}
        {!! Form::text('nome', null, ['class' => 'form-control']) !!}
    </div>
    <div class="modal-footer">
        {!! Form::button('Cancelar', ['class' => 'btn btn-default pull-left', 'id' => 'fechar']) !!}
        {!! Form::submit('Salvar', ['class' => 'btn btn-success', 'id' => 'salvar-tipo-saida']) !!}
    </div>
{!! Form::close() !!}
