
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">×</span></button>
	<h4 class="modal-title"> Excluir Tipo Material</h4>
</div>
{!! Form::open(['action' =>('TipoMaterialController@destroy')]) !!}
	{!! Form::hidden('id', $tipoMaterial->id) !!}
	<div class="modal-body">
		<p>
			Deseja realmente excluir o Tipo Material: <strong>{{ $tipoMaterial->codigo }} - {{ $tipoMaterial->descricao }}</strong> ? 
		</p>
	</div>

	<div class="modal-footer">
        {!! Form::button('Não', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) !!}
        {!! Form::submit('Sim', ['class' => 'btn btn-danger']) !!}
	</div>
{!! Form::close() !!}