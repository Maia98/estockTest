<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title">{{ (isset($valorUS)) ? 'Editar' : 'Adicionar' }} Valor da US </h4>
</div>
@if(isset($valorUS))
    {!! Form::model($valorUS, ['action' => ('ValorUSController@store'), 'id' => 'form-valor-us']) !!}
@else
    {!! Form::open(['action' => ('ValorUSController@store'), 'id' => 'form-valor-us']) !!}
@endif
    <div class="modal-body">
        {!! Form::hidden('id', null) !!}
        <div id='alert-modal' class="alert" style="display: none;"></div>
            <div class="panel" style="background: #f5f5f5;">
                <div class="panel-body">
                    <div class="form-inline">
                        <p>
                            <strong>Última Atualização:</strong>
                            @if( isset( $valorUS->updated_at ) )

                                {{ isset($valorUS->updated_at) ? date( "d/m/Y H:m", strtotime($valorUS->updated_at)) : '' }}

                            @else

                                {{ isset($valorUS->created_at) ? date( "d/m/Y H:m", strtotime($valorUS->created_at)) : '' }}

                            @endif
                        </p>
                        <p>
                            <strong>Adicionado Por:</strong>
                            {{ isset($valorUS->usuario_id) ? $valorUS->name : '' }}
                        </p>
                        <p>
                            <strong>Valor Atual: </strong>
                            <span id="valor">{{ isset($valorUS->valor) ? $valorUS->valor : '' }}</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6">
                        {!! Form::label('valor', 'Novo Valor da US:') !!}
                        <div class="input-group margin">
                            <div class="input-group-btn">
                                <a class="btn btn-default">R$</a>
                            </div>
                            {!! Form::text('valor', null, ['class' => 'form-control', 'id'=> 'valor_us','min' => '1']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        {!! Form::button('Cancelar', ['class' => 'btn btn-default pull-left', 'id' => 'fechar-valor-us']) !!}
        {!! Form::submit('Salvar', ['class' => 'btn btn-success', 'id' => 'salvar-valor-us']) !!}
    </div>
{!! Form::close() !!}