
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">×</span></button>
	<h4 class="modal-title">Observações</h4>
</div>
{!! Form::open(['action' =>('ListaEntradaMateriaisController@storeObs')]) !!}
	{!! Form::hidden('id', $id) !!}
	<div class="modal-body">
		{!! Form::textarea('observacao', null, ['class' => 'form-control', 'rows' => 5]) !!}
	</div>

	<div class="modal-footer">
        {!! Form::button('Cancelar', ['class' => 'btn btn-danger pull-left', 'data-dismiss' => 'modal']) !!}
        {!! Form::submit('Salvar', ['class' => 'btn btn-success']) !!}
	</div>
{!! Form::close() !!}