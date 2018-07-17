
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">×</span></button>
	<h4 class="modal-title"> Excluir Funcionário</h4>
</div>
{!! Form::open(['action' =>('FuncionarioController@destroy')]) !!}
	{!! Form::hidden('id', $funcionario->id) !!}
	<div class="modal-body">
		<p>
			Deseja realmente excluir o Funcionário: <strong>{{ $funcionario->nome }} {{$funcionario->sobrenome}}</strong> ? 
		</p>
	</div>

	<div class="modal-footer">
        {!! Form::button('Não', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) !!}
        {!! Form::submit('Sim', ['class' => 'btn btn-danger']) !!}
	</div>
{!! Form::close() !!}