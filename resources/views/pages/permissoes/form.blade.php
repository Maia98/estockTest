<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> {{ (isset($permissao)) ? 'Editar' : 'Cadastrar' }} Permissão</h4>
</div>
@if(isset($permissao))
    {!! Form::model($permissao, ['action' => ('PermissoesController@store'), 'id' => 'form-permissoes']) !!}
@else
    {!! Form::open(['action' => ('PermissoesController@store'), 'id' => 'form-permissoes']) !!}
@endif
    <div class="modal-body">
        <div id='alert-modal' class="alert" style="display: none;"></div>
        <div class="row">
            {!! Form::hidden('id', null) !!}
            <div class="col-md-4">
                {!! Form::label('name', 'Ação:') !!}
                @if(isset($permissao))
                    {!! Form::text('name', null, ['class' => 'form-control', 'readonly' => true]) !!}
                @else
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                @endif
            </div>
            <div class="col-md-8">
                {!! Form::label('description', 'Descrição:') !!}
                {!! Form::text('description', null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="modal-footer border">
        {!! Form::button('Cancelar', ['class' => 'btn btn-default pull-left', 'id' => 'fechar']) !!}
        {!! Form::submit('Salvar', ['class' => 'btn btn-success', 'id' => 'salvar']) !!}
    </div>
{!! Form::close() !!}