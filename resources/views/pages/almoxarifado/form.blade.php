<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> {{ (isset($almoxarifado)) ? 'Editar' : 'Adicionar' }} Almoxarifado</h4>
</div>
@if(isset($almoxarifado))
    {!! Form::model($almoxarifado, ['action' => ('AlmoxarifadoController@store'), 'id' => 'form-almoxarifado']) !!}
@else
    {!! Form::open(['action' => ('AlmoxarifadoController@store'), 'id' => 'form-almoxarifado']) !!}
@endif
    <div class="modal-body">
        <div id='alert-modal' class="alert" style="display: none;"></div>
        {!! Form::hidden('id', null) !!}
        
            
            {!! Form::label('nome', 'Nome:') !!}
            {!! Form::text('nome', null, ['class' => 'form-control']) !!}
         <br>

            {!! Form::label('descricao', 'Descrição:') !!}
            {!! Form::text('descricao', null, ['class' => 'form-control']) !!}
    
        
        <br>
        
        
        <div class="input-group">
            {!! Form::label('cidade_id', 'Cidade:') !!}
            {!! Form::select('cidade_id',arrayToSelect($cidades , 'id', 'nome') ,null, ['class' => 'form-control', 'id' => 'cidades']) !!}
            <span class="input-group-btn">
                <button type="button" onclick="createCidade();" class="btn btn-primary btn-flat" style="margin-top: 27px;"><i class="fa  fa-plus"></i></button>
            </span>
        </div>
            
    </div>
    <br>
    <div class="modal-footer">
        {!! Form::button('Cancelar', ['class' => 'btn btn-default pull-left', 'id' => 'fechar-almoxarifado']) !!}
        {!! Form::submit('Salvar', ['class' => 'btn btn-success', 'id' => 'salvar-almoxarifado']) !!}
    </div>

{!! Form::close() !!}
