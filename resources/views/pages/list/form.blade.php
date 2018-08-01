
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> {{ (isset($list)) ? 'Editar' : 'Adicionar' }} Lista</h4>
</div>



<!--,'id' => 'form-list'-->
@if(isset($list))
    {!! Form::model($list, ['action' => ('FormList\ListController@store'), 'method' => 'POST']) !!}
@else
    {!! Form::open([ 'action' => ('FormList\ListController@store'),'method' => 'POST']) !!}

@endif
<div class="modal-body">

    <div id='alert-modal' class="alert" style="display: none;">
    </div>

    {!! Form::hidden('id', null) !!}


    {!! Form::label('name', 'Nome:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
    <br>
    {!! Form::label('name_plura', 'Nome Plural:') !!}
    {!! Form::text('name_plura', null, ['class' => 'form-control']) !!}
    <br>
    {!! Form::label('sort_model', 'Ordenação:') !!}
    {!! Form::select('sort_model',[''=>'Selecionar Ordenação','Alpha' => 'Alfabética', '-Alpha' => 'Alfabética (Invertida)', 'SortCol' => 'Manualmente' ],null, ['class' => 'form-control']) !!}
    <br>
    {!! Form::label('type', 'Tipo de Campo:') !!}
    {!! Form::select('type',[''=>'Selecionar Tipo','cbox' => 'CheckBox', 'radiob' => 'Botão Rádio', 'select' => 'Seleção' ],null, ['class' => 'form-control']) !!}
    <br>
    {!! Form::label('notes', 'Notas Internas:') !!}
    {!! Form::textarea('notes', null, ['class' => 'form-control']) !!}

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" aria-label="Close">Cancelar</button>
    {!! Form::submit('Salvar', ['class' => 'btn btn-success', 'id' => empty($list)?'salvar-list':'']) !!}
</div>

{!! Form::close() !!}





