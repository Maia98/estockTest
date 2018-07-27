
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">×</span></button>
	<h4 class="modal-title"> Excluir Campo</h4>
</div>
{!! Form::open(['action' => ('FormList\FieldController@destroy'), 'method' => 'post']) !!}
	{!! Form::hidden('id', $field->id) !!}
	{!! Form::hidden('form_id', $field->form_id) !!}
	<div class="modal-body">
		<p>
			Deseja realmente excluir a Formulário: <strong>{{ $field->label }}</strong> ?
		</p>
	</div>

	<div class="modal-footer">
        {!! Form::button('Não', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) !!}
        {!! Form::submit('Sim', ['class' => 'btn btn-danger']) !!}
	</div>
{!! Form::close() !!}