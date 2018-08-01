<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> {{ (isset($field)) ? 'Editar' : 'Adicionar' }} Campos</h4>
</div>


<!--,'id' => 'form-list'-->
@if(isset($field))
    {!! Form::model($field, ['action' => ('FormList\FieldController@store'), 'method' => 'POST']) !!}
@else
    {!! Form::open([ 'action' => ('FormList\FieldController@store'),'method' => 'POST']) !!}

@endif
<div class="modal-body">

    <div id='alert-modal' class="alert" style="display: none;">
    </div>

<<<<<<< HEAD

    {!! Form::hidden('id', null, ['id' => 'id'] )!!}
=======
    {!! Form::hidden('id', null, ['id' => 'id'] )!!}
<<<<<<< HEAD
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
    
    @if(isset($field))
        {!! Form::hidden('form_id', $field->form_id, ['id' => 'form_id'])  !!}
    @else 
<<<<<<< HEAD
    {!! Form::hidden('form_id', $form_id->id, ['id' => 'form_id'])  !!}
    @endif
    
        
                {!! Form::label('label', 'Descrição:') !!}
=======
        {!! Form::hidden('form_id', $form_id->id, ['id' => 'form_id'])  !!}
    @endif
    
        
                {!! Form::label('label', 'Rótulo:') !!}
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
                {!! Form::text('label', null, ['class' => 'form-control']) !!}         
         <br>
        
                    {!! Form::label('name', 'Variável:') !!}
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
         <br>
                {{-- {!! Form::label('type', 'Tipo:') !!}
                    {!! Form::select('type',array([
                        'Campos Básicos'        =>  @foreach($type as $t)
                                                        {{$t->id}} => {{$t->desc}}
                                                    @endforeach,
                        'Campos dinâmicos'      =>  array('dinamico' => 'dinâmicos'),
                                        
                    ]),null, ['class' => 'form-control']) !!}
                
                {!! Form::label('label', 'Rótulo:') !!}
                {!! Form::text('label', null, ['class' => 'form-control']) !!}  --}}     
                
                {!! Form::label('type_id', 'Tipo:')!!}
                <select name="type_id" class="form-control" id="type_id">
                        <optgroup label="Campos Básicos">
                            @foreach($type as $t) 
                                <option value="{{'type-'.$t->id}}">{{$t->desc}}</option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Lista Personalizadas">
                            @foreach($lists as  $l)
                            <option value="{{'list-'.$l->id}}">{{$l->name}}</option>
                            @endforeach     
                        </optgroup>
                    </select>
         <br>
        
                {!! Form::label('required', 'Obrigatório:') !!}
                {!! Form::select('required',[''=>'Selecionar Opção','1' => 'Sim', '0' => 'Não'],null, ['class' => 'form-control']) !!}
        <br>
        
                {!! Form::label('private', 'Privado:') !!}
                {!! Form::select('private',[''=>'Selecionar Opção','1' => 'Sim', '0' => 'Não'],null, ['class' => 'form-control']) !!}
        <br>
<<<<<<< HEAD
=======
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible" role="alert">
                @foreach ($errors->all() as $error)
                    <li><p>{{ $error }}</p></li>
                @endforeach
            </div>
        @endif
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
    </div>

    

<div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" aria-label="Close">Cancelar</button>
    {!! Form::submit('Salvar', ['class' => 'btn btn-success']) !!}
<<<<<<< HEAD
=======
=======
    {!! Form::hidden('form_id', $form_id->id, ['id' => 'form_id'])  !!}

    <div class="row">
        <div class="col-md-2">
            {!! Form::label('label', 'Rótulo:') !!}
            {!! Form::text('label', null, ['class' => 'form-control']) !!}         
        </div>
        <div class="col-md-2">
                {!! Form::label('name', 'Variável:') !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-3">
               {{-- {!! Form::label('type', 'Tipo:') !!}
                {!! Form::select('type',array([
                    'Campos Básicos'        =>  @foreach($type as $t)
                                                    {{$t->id}} => {{$t->desc}}
                                                @endforeach,
                    'Campos dinâmicos'      =>  array('dinamico' => 'dinâmicos'),
                                     
                   ]),null, ['class' => 'form-control']) !!}
            
            {!! Form::label('label', 'Rótulo:') !!}
            {!! Form::text('label', null, ['class' => 'form-control']) !!}  --}}     
            
            {!! Form::label('type', 'Tipo:')!!}
            <select name="type" class="form-control" id="type">
                    <optgroup label="Campos Básicos">
                            @foreach($type as $t) 
                            <option value="{{'type-'.$t->id}}">{{$t->desc}}</option>
                         @endforeach
                    </optgroup>
                    <optgroup label="Campos dinâmicos">
                      <option value="dinamico">dinâmicos</option>
                    </optgroup>
                    <optgroup label="Lista Personalizadas">
                        @foreach($lists as  $l)
                        <option value="{{'list-'.$l->id}}">{{$l->name}}</option>
                        @endforeach     
                    </optgroup>
                  </select>
        </div>
        <div class="col-md-2">
                {!! Form::label('required', 'Obrigatório:') !!}
                {!! Form::select('required',[''=>'Selecionar Opção','1' => 'Sim', '0' => 'Não'],null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-2">
                {!! Form::label('private', 'Privado:') !!}
                {!! Form::select('private',[''=>'Selecionar Opção','1' => 'Sim', '0' => 'Não'],null, ['class' => 'form-control']) !!}
        </div>
        
    </div>
{{--
    {!! Form::label('title', 'Título:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
    <br>
    {!! Form::label('instructions', 'Instrução:') !!}
    {!! Form::text('instructions', null, ['class' => 'form-control']) !!}
    <br>
    @if(isset($field))
    {!! Form::label('deletable', 'Permissão para deletar Formuário:') !!}
    {!! Form::select('deletable',[''=>'Selecionar Opção','1' => 'Sim', '0' => 'Não'],null, ['class' => 'form-control']) !!}
    @endif
    <br>
    {!! Form::label('notes', 'Notas Internas:') !!}
    {!! Form::textarea('notes', null, ['class' => 'form-control' ]) !!}
    <br>
    {{--{!! Form::label('type', 'Tipo:') !!}
    {!! Form::select('type',[''=>'Selecionar Ordenação','u' => 'U', 't' => 'T', 'c' => 'C','o' => 'O' ],null, ['class' => 'form-control']) !!}
    <br>--}}
    
</div>
<div class="modal-footer">
    {!! Form::button('Cancelar', ['class' => 'btn btn-default pull-left', 'id' => 'fechar-lista']) !!}
    {!! Form::submit('Salvar', ['class' => 'btn btn-success','onclick' => 'salvar()']) !!}
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
>>>>>>> afa5779e42b414a12eb95d68a5bec7a2c91ce409
</div>

{!! Form::close() !!}

