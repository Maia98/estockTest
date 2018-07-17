<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> {{ (isset($tipoUnidade)) ? 'Editar' : 'Adicionar' }} Unidade Medida</h4>
</div>
@if(isset($tipoUnidade))
    {!! Form::model($tipoUnidade, ['action' => ('TipoUnidadeMedidaController@store'), 'id' => 'form-tipo-unidade-medida']) !!}
@else
    {!! Form::open(['action' => ('TipoUnidadeMedidaController@store'), 'id' => 'form-tipo-unidade-medida']) !!}
@endif
    <div class="modal-body">
        <div id='alert-modal2' class="alert" style="display: none;"></div>
        {!! Form::hidden('id', null) !!}
        {!! Form::label('codigo', 'Código:') !!}
        {!! Form::text('codigo', null, ['class' => 'form-control']) !!}<br/>
        {!! Form::label('descricao', 'Descrição:') !!}
        {!! Form::text('descricao', null, ['class' => 'form-control']) !!}
        <br/>

        <fieldset>
            <legend>Unidade possui valor decimal?</legend>
                <div class="row">
                    <div class="col-md-2">
                        {!! Form::radio('ponto_flutuante', '1', 0) !!} Sim
                    </div>
                    <div class="col-md-2">
                        {!! Form::radio('ponto_flutuante', '0', 1) !!} Não
                    </div>
                </div>
        </fieldset>

    </div>
    <div class="modal-footer">
        {!! Form::button('Cancelar', ['class' => 'btn btn-default pull-left', 'id' => 'fechar-tipo-unidade-medida']) !!}
        {!! Form::submit('Salvar', ['class' => 'btn btn-success', 'id' => 'salvar-tipo-unidade-medida']) !!}
    </div>
{!! Form::close() !!}
