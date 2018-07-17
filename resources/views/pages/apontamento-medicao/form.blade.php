<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> {{ (isset($apontamentoMedicao)) ? 'Editar' : 'Adicionar' }} Apontamento Medição</h4>
</div>
@if(isset($apontamentoMedicao))
    {!! Form::model($apontamentoMedicao, ['action' => ('ApontamentoMedicaoController@store'), 'id' => 'form-apontamento-medicao']) !!}
@else
    {!! Form::open(['action' => ('ApontamentoMedicaoController@store'), 'id' => 'form-apontamento-medicao']) !!}
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
        {!! Form::button('Cancelar', ['class' => 'btn btn-default pull-left', 'id' => 'fechar-apontamento-medicao']) !!}
        {!! Form::submit('Salvar', ['class' => 'btn btn-success', 'id' => 'salvar-apontamento-medicao']) !!}
    </div>
{!! Form::close() !!}
