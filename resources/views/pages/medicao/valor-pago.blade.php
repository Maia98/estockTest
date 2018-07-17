<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"> Valor Recebido</h4>
</div>
@if(isset($valorPago))
    {!! Form::model($valorPago, ['action' => ('MedicaoController@storeValorPago'), 'id' => 'form-valor-pago']) !!}
@else
    {!! Form::open(['action' => ('MedicaoController@storeValorPago'), 'id' => 'form-valor-pago']) !!}
@endif
    <div class="modal-body">
        <div id='alert-modal' class="alert" style="display: none;"></div>
        {!! Form::hidden('id', null) !!}
        <div class="input-group margin">
            <div class="input-group-btn">
                <a class="btn btn-default">R$</a>
            </div>
            {!! Form::text('valor_pago', null, ['class' => 'form-control', 'id' => 'valor_pago','min' => '1']) !!}
        </div>
    </div>
    <div class="modal-footer">
        {!! Form::button('Cancelar', ['class' => 'btn btn-default pull-left', 'id' => 'fechar-valor-pago']) !!}
        {!! Form::submit('Salvar', ['class' => 'btn btn-success', 'id' => 'salvar-valor-pago']) !!}
    </div>
{!! Form::close() !!}