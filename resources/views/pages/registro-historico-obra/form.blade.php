<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> <strong>Adicionar Histórico Obra Nº {{$numeroObra->numero_obra}}</strong></h4>
</div>
    {!! Form::open(['action' => ('RegistroHistoricoObraController@store'), 'id' => 'form-historico']) !!}
    <div class="modal-body">
        <div id='alert-modal' class="alert" style="display: none;"></div>
        {!! Form::hidden('id', null) !!}
        {!! Form::hidden('idObra', $idObra ) !!}
        {!! Form::label('descricao', 'Observações:') !!}
        {!! Form::textarea('descricao', null, ['class' => 'form-control', 'rows' => 5]) !!}
    </div>
    <div class="modal-footer">
        {!! Form::button('Cancelar', ['class' => 'btn btn-default pull-left', 'data-dismiss' =>'modal']) !!}
        {!! Form::submit('Salvar', ['class' => 'btn btn-success', 'id' => 'salvar-historico']) !!}
    </div>
{!! Form::close() !!}
