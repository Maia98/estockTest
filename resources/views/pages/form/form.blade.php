<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> {{ (isset($form)) ? 'Editar' : 'Adicionar' }} Formulário</h4>
</div>



<!--,'id' => 'form-list'-->
@if(isset($form))
    {!! Form::model($form, ['action' => ('FormList\FormController@store'), 'method' => 'POST']) !!}
@else
    {!! Form::open([ 'action' => ('FormList\FormController@store'),'method' => 'POST']) !!}
<<<<<<< HEAD
=======

>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
@endif
<div class="modal-body">

    <div id='alert-modal' class="alert" style="display: none;">
    </div>

    {!! Form::hidden('id', null) !!}

<<<<<<< HEAD
    {!! Form::label('title', 'Título:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
    <br>
        {!! Form::label('instructions', 'Instrução:') !!}
        {!! Form::text('instructions', null, ['class' => 'form-control']) !!}
    <br>
    
    {{--    {!! Form::label('nametable', 'Nome do Banco:') !!}
        {!! Form::text('nametable',null, ['class' => 'form-control']) !!}
    <br>--}}
    @if(isset($form))
        {!! Form::label('deletable', 'Permissão para deletar Formuário:') !!}
        {!! Form::select('deletable',[''=>'Selecionar Opção','1' => 'Sim', '0' => 'Não'],null, ['class' => 'form-control']) !!}
    @endif
    <br>
        {!! Form::label('notes', 'Notas Internas:') !!}
        {!! Form::textarea('notes', null, ['class' => 'form-control' ]) !!}
    <br> 
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" aria-label="Close">Cancelar</button>
    {!! Form::submit('Salvar', ['class' => 'btn btn-success']) !!}
</div>
=======

    {!! Form::label('title', 'Título:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
    <br>
    {!! Form::label('instructions', 'Instrução:') !!}
    {!! Form::text('instructions', null, ['class' => 'form-control']) !!}
    <br>
<<<<<<< HEAD
    {!! Form::label('nametable', 'Nome do Banco:') !!}
    {!! Form::text('nametable',null, ['class' => 'form-control']) !!}
    <br>
=======
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
    @if(isset($form))
    {!! Form::label('deletable', 'Permissão para deletar Formuário:') !!}
    {!! Form::select('deletable',[''=>'Selecionar Opção','1' => 'Sim', '0' => 'Não'],null, ['class' => 'form-control']) !!}
    @endif
    <br>
    {!! Form::label('notes', 'Notas Internas:') !!}
    {!! Form::textarea('notes', null, ['class' => 'form-control' ]) !!}
    <br>
<<<<<<< HEAD
    
=======
    {{--{!! Form::label('type', 'Tipo:') !!}
    {!! Form::select('type',[''=>'Selecionar Ordenação','u' => 'U', 't' => 'T', 'c' => 'C','o' => 'O' ],null, ['class' => 'form-control']) !!}
    <br>--}}
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
    
</div>
<div class="modal-footer">
    {!! Form::button('Cancelar', ['class' => 'btn btn-default pull-left', 'id' => 'fechar-lista']) !!}
    {!! Form::submit('Salvar', ['class' => 'btn btn-success']) !!}
</div>

>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
{!! Form::close() !!}
