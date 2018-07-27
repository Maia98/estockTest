<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> {{ (isset($field)) ? 'Editar' : 'Adicionar' }} Campos</h4>
</div>


<!--,'id' => 'form-list'-->
@if(isset($field))
    {!! Form::model($field, ['action' => ('FormList\FieldController@storeConfig'), 'method' => 'POST']) !!}
@else
    {!! Form::open([ 'action' => ('FormList\FieldController@storeConfig'),'method' => 'POST']) !!}

@endif
<div class="modal-body">

    <div id='alert-modal' class="alert" style="display: none;">
    </div>
            {!! Form::hidden('id', $field->id, ['id' => 'id']) !!}
            {!! Form::label('size', 'Tamanho:') !!}
            {!! Form::text('size', null, ['class' => 'form-control']) !!}         
        <br>
       
            {!! Form::label('width', 'Comprimento Máximo:') !!}
            {!! Form::text('width', null, ['class' => 'form-control']) !!}
        <br>
             {!! Form::label('validate', 'Validador:') !!}
            {!! Form::select('validate',[''=>'Nenhum','1' => 'Teste', '2' => 'Teste 2'],null, ['class' => 'form-control']) !!}
        
        <br>
        {!! Form::label('msgValidate', 'Erro de Validação:') !!}
        {!! Form::text('msgValidate',null,['class' => 'form-control']) !!}
        <em style="color:gray;display:inline-block">Mensagem exibida ao usuário, se a entrada não coincide com o validador</em>
        <br><br>

        {!! Form::label('spaceReser', 'Espaço Reservado:') !!}
        {!! Form::text('spaceReser',null,['class' => 'form-control']) !!}
        <em style="color:gray;display:inline-block">Texto exibido antes de qualquer entrada do usuário</em>
        <br><br>
        
        {!! Form::label('helptext', 'Texto de ajuda:') !!}
        {!! Form::textarea('helptext', null, ['class' => 'form-control', 'rows' => '3']) !!}
        <em style="color:gray;display:inline-block">
            Texto de ajuda mostrado com o campo</em>
    </div>
     
    

<div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" aria-label="Close">Cancelar</button>
    {!! Form::submit('Salvar', ['class' => 'btn btn-success','onclick' => 'salvar()']) !!}
</div>
</div>
{!! Form::close() !!}