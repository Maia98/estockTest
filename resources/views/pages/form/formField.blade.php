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

    {!! Form::hidden('id', null, ['id' => 'id'] )!!}
    
    @if(isset($field))
        {!! Form::hidden('form_id', $field->form_id, ['id' => 'form_id'])  !!}
    @else 
        {!! Form::hidden('form_id', $form_id->id, ['id' => 'form_id'])  !!}
    @endif
    
        
                {!! Form::label('label', 'Rótulo:') !!}
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
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible" role="alert">
                @foreach ($errors->all() as $error)
                    <li><p>{{ $error }}</p></li>
                @endforeach
            </div>
        @endif
    </div>

    

<div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" aria-label="Close">Cancelar</button>
    {!! Form::submit('Salvar', ['class' => 'btn btn-success']) !!}
</div>

{!! Form::close() !!}

