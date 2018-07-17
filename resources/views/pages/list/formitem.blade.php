<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> {{ (isset($item)) ? 'Editar' : 'Adicionar' }} Item </h4>
</div>

    @if(isset($alert))
        <div class="alert alert-danger">
            <ul>
                <li>{{$alert}}</li>
            </ul>
        </div>
    @endif

<!--,'id' => 'form-list'-->
@if(isset($item))
    {!! Form::model($item, ['action' => ('FormList\ItemController@store')]) !!}
@else
    {!! Form::open(['action' => ('FormList\ItemController@store')]) !!}

@endif
<div class="modal-body">
    <div id='alert-modal' class="alert" style="display: none;"></div>
    <div class="row">

    {!! Form::hidden('id', null, ['id' => 'iditem']) !!}
    @if(isset($item))
       {!! Form::hidden('lista_id',$item->lista_id,['id' => 'lista_id']) !!}
    @endif
    @if(!isset($item))
    {!! Form::hidden('lista_id',$lista_id,['id' => 'lista_id']) !!}
    @endif
        <div class="col-md-8">

    {!! Form::label('value', 'Valor:') !!}
    {!! Form::text('value', null, ['class' => 'form-control', 'id' => 'value']) !!}

        </div>
        <div class="col-md-4">

    {!! Form::label('extra', 'Abreviação:') !!}
    {!! Form::text('extra', null, ['class' => 'form-control','id' => 'extra']) !!}
        </div>
        <!--<div class="col-md-2" style="margin-top: 30px">
            <button type="button" class="btn btn-sm btn-primary" onclick="addItem()"><i class="glyphicon glyphicon-plus"></i></button>
        </div>-->
        <div style="clear:both;"></div>
    </div>
    <br>
    <div class="col-md-12 table-permissoes" style=" max-height: 250px; overflow: scroll; overflow-y: auto; overflow-x: hidden;">
       <div class="row">
        <table class="table table-hover">
            <thead>
            <th class="col-sm-5">valor</th>
            <th class="col-sm-5">Abrev.</th>
            <th class="col-sm-2">Ações</th>
            </thead>
            <tbody id="table-body-itens"></tbody>
        </table>
       </div>
    </div>

</div>
<br>
<hr>
<br>
<div class="modal-footer border">
    {!! Form::button('Cancelar', ['class' => 'btn btn-default pull-left', 'id' => 'fechar-item']) !!}
    @if(!isset($item))
    {!! Form::button('Adicionar', ['class' => 'btn btn-success', 'id' => 'salvar-item','onclick' => 'insertItem()']) !!}
    @else
    {!! Form::button('Salvar', ['class' => 'btn btn-success', 'id' => 'salvar-item','onclick' => 'editItem()']) !!}
    @endif
</div>


{!! Form::close() !!}
@includeIf('layouts.partials.modal', ['idModal' => 'modal-form-item', 'idContent' => 'content-modal-item' ])

@includeIf('layouts.partials.modal', ['idModal' => 'modal-form-itemdelete', 'idContent' => 'content-modal-itemdelete' ])