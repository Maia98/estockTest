
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">×</span></button>
	<h4 class="modal-title">Excluir Apontamento Medição</h4>
</div>
{!! Form::open(['action' =>('ApontamentoMedicaoController@destroy')]) !!}
	{!! Form::hidden('id', $apontamentoMedicao->id) !!}
	<div class="modal-body">
		<p>
			Deseja realmente excluir o Apontamento de Medição: <strong>{{ $apontamentoMedicao->nome }}</strong> ?
		</p>
	</div>

	<div class="modal-footer">
        {!! Form::button('Não', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) !!}
        {!! Form::submit('Sim', ['class' => 'btn btn-danger']) !!}
	</div>
{!! Form::close() !!}