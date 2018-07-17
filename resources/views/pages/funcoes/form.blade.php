<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> {{ (isset($funcao)) ? 'Editar' : 'Adicionar' }} Função</h4>
</div>
@if(isset($funcao))
    {!! Form::model($funcao, ['action' => ('FuncaoController@store'), 'id' => 'form-funcoes']) !!}
@else
    {!! Form::open(['action' => ('FuncaoController@store'), 'id' => 'form-funcoes']) !!}
@endif
    <div class="modal-body">
        <div id='alert-modal' class="alert" style="display: none;"></div>
        <div class="row">
            {!! Form::hidden('id', null, ['id' => 'id-role' ]) !!}
            {!! Form::hidden('permissoes', null, ['id' => 'permissoes-values']) !!}
            <div class="col-md-4">
                {!! Form::label('name', 'Função:') !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-8">
                {!! Form::label('description', 'Descrição:') !!}
                {!! Form::text('description', null, ['class' => 'form-control']) !!}
            </div>
            <div style="clear:both;"></div>
            <br/>
            <div class="col-md-12">
                {!! Form::label('', 'Permissões:') !!}
                <div class="input-group input-group">
                    {!! Form::select('', $permissoes, null, ['class' => 'form-control', 'id' => 'permissao-option']) !!}
                    <span class="input-group-btn">
                        <button type="button" id = "add-permissao" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Adicionar </button>
                    </span>
                </div>
            </div>
            <div class="col-md-12 table-permissoes" style=" max-height: 250px; overflow: scroll; overflow-y: auto; overflow-x: hidden;">
                <br />
                <table class="table table-hover">
                    <thead>
                        <th>Permissão</th>
                        <th>Ações</th>
                    </thead>
                    <tbody id="table-body-permissoes"></tbody>
                </table>
            </div>
            
        </div>
    </div>
    <div class="modal-footer border">
        {!! Form::button('Cancelar', ['class' => 'btn btn-default pull-left', 'id' => 'fechar']) !!}
        {!! Form::submit('Salvar', ['class' => 'btn btn-success', 'id' => 'salvar']) !!}
    </div>
{!! Form::close() !!}
<script type="text/javascript">
    loadPermissoes();
</script>