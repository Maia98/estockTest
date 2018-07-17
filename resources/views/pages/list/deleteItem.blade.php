<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> Excluir Item</h4>
</div>
{!! Form::open(['action' =>('FormList\ListController@destroy'), 'method' => 'POST']) !!}

{!! Form::hidden('id', $item->id) !!}
{!! Form::hidden('lista_id', $item->lista_id) !!}
<div class="modal-body">
    <p>
        Deseja realmente excluir a Item: <strong>{{ $item->value }}</strong> ?
    </p>
</div>

<div class="modal-footer">
    {!! Form::button('Não', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) !!}
    {!! Form::button('Sim', ['class' => 'btn btn-danger','onclick' => 'deletarItem('.$item->id.')']) !!}
</div>
{!! Form::close() !!}