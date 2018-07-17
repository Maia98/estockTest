<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> {{ (isset($statusObra)) ? 'Editar' : 'Adicionar' }} Status Obra</h4>
</div>
@if(isset($statusObra))
    {!! Form::model($statusObra, ['action' => ('StatusObraController@store'), 'id' => 'form-status-obra']) !!}
@else
    {!! Form::open(['action' => ('StatusObraController@store'), 'id' => 'form-status-obra']) !!}
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
        {!! Form::button('Cancelar', ['class' => 'btn btn-default pull-left', 'id' => 'fechar-status-obra']) !!}
        
        {!! Form::submit('Salvar', ['class' => 'btn btn-success', 'id' => 'salvar-status-obra']) !!}
    </div>
{!! Form::close() !!}
