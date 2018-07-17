
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">×</span></button>
	<h4 class="modal-title"> Excluir Tipo Entrada</h4>
</div>
{!! Form::open(['action' =>('TipoEntradaController@destroy')]) !!}
	{!! Form::hidden('id', $tipoEntrada->id) !!}
	<div class="modal-body">
		<p>
			Deseja realmente excluir o Tipo Entrada: <strong>{{ $tipoEntrada->nome }}</strong> ? 
		</p>
	</div>

	<div class="modal-footer">
        {!! Form::button('Não', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) !!}
        {!! Form::submit('Sim', ['class' => 'btn btn-danger']) !!}
	</div>
{!! Form::close() !!}