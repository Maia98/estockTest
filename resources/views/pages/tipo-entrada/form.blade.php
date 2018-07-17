<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> {{ (isset($tipoEntrada)) ? 'Editar' : 'Adicionar' }} Tipo Entrada</h4>
</div>
@if(isset($tipoEntrada))
    {!! Form::model($tipoEntrada, ['action' => ('TipoEntradaController@store'), 'id' => 'form-tipo-entrada']) !!}
@else
    {!! Form::open(['action' => ('TipoEntradaController@store'), 'id' => 'form-tipo-entrada']) !!}
@endif
    <div class="modal-body">
        <div id='alert-modal' class="alert" style="display: none;"></div>
        {!! Form::hidden('id', null) !!}
        {!! Form::label('nome', 'Nome:') !!}
        {!! Form::text('nome', null, ['class' => 'form-control']) !!}
    </div>
    <div class="modal-footer">
        {!! Form::button('Cancelar', ['class' => 'btn btn-default pull-left', 'id' => 'fechar-tipo-entrada']) !!}
        {!! Form::submit('Salvar', ['class' => 'btn btn-success', 'id' => 'salvar-tipo-entrada']) !!}
    </div>
{!! Form::close() !!}
