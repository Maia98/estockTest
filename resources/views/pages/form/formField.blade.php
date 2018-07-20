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
</div>

{!! Form::close() !!}

