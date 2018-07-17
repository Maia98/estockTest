<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> {{ (isset($tipoStatusMedicao)) ? 'Editar' : 'Adicionar' }} Tipo Status Medição</h4>
</div>
@if(isset($tipoStatusMedicao))
    {!! Form::model($tipoStatusMedicao, ['action' => ('TipoStatusMedicaoController@store'), 'id' => 'form-status-medicao']) !!}
@else
    {!! Form::open(['action' => ('TipoStatusMedicaoController@store'), 'id' => 'form-status-medicao']) !!}
@endif
    <div class="modal-body">
        <div id='alert-modal' class="alert" style="display: none;"></div>
        {!! Form::hidden('id', null) !!}
        {!! Form::label('nome', 'Nome:') !!}
        {!! Form::text('nome', null, ['class' => 'form-control']) !!}
    </div>
    <div class="modal-footer">
        {!! Form::button('Cancelar', ['class' => 'btn btn-default pull-left', 'id' => 'fechar-status-medicao']) !!}
        {!! Form::submit('Salvar', ['class' => 'btn btn-success', 'id' => 'salvar-status-medicao']) !!}
    </div>
{!! Form::close() !!}
