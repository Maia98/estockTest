<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title">Conferir Saída Estoque</h4>
</div>
{!! Form::open(['action' => ('SaidaEstoqueController@store'), 'id' => 'form-conferir-saida-estoque']) !!}
<div class="modal-body">
    <div id='alert-modal' class="alert" style="display: none;"></div>
    <div class="panel" style="background: #f5f5f5;">
        <div class="panel-body">
            <div class="form-inline">
            @if(isset($saidaEstoque))
                <div class="row">
                    <div class="col-md-4">
                        {!! Form::label('obra', 'Obra:') !!}
                        <b>{{$saidaEstoque->obra->numero_obra}}</b>

                    </div>
                    <div class="col-md-4">
                        {!! Form::label('data', 'Data Saída:') !!}
                        <b>{{ $saidaEstoque->data }}</b>
                    </div>
                    <div class="col-md-4">
                        {!! Form::label('almoxarifado', 'Almoxarifado:') !!}
                        <b>{{$saidaEstoque->almoxarifado->nome}}</b>
                    </div>
                </div>
            
            
                <div class="row">
                    <div class="col-md-4">
                        {!! Form::label('tipo_saida', 'Tipo de Saída:') !!}
                        <b>{{$saidaEstoque->tipoSaida->nome}}</b>
                    </div>
                    <div class="col-md-4">
                        {!! Form::label('execucao', 'Prev. Execução:') !!}
                        <b>{{$saidaEstoque->execucao}}</b>
                    </div>
                    <div class="col-md-4">
                        {!! Form::label('conferente', 'Conferente:') !!}
                        <b>{{$saidaEstoque->conferente->nome.' '.$saidaEstoque->conferente->sobrenome}}</b>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        {!! Form::label('observacoes', 'Observações:') !!}
                        <b>{{$saidaEstoque->obs}}</b>
                    </div>
                </div>
            @endif
            </div>
        </div>
    </div>
        <div style="height: 290px; overflow-x: hidden;">
            <table class="table table-bordered" style="margin-left: 10px;" id="table_conferir_materiais">
                <thead>
                    <tr>
                        <th>Cód-Descrição</th>
                        <th>Orçado</th>
                        <th>Qtde. Estoque</th>
                        <th>Saldo</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($saidaEstoque->materiais as $row)
                <tr>
                    <td>{{ $row->descricao }}</td>
                    <td>{{ $row->quantidade }}</td>
                    <td>@if ($row->qtdeEstoque <= 0) 0  @else {{ $row->qtdeEstoque }} @endif</td>
                    <td>@if (isset($row->existe) && $row->existe == 'n') 0 @else {{ $row->qtdeEstoque - $row->quantidade }} @endif</td>
                    <td>@if (isset($row->existe) && $row->existe == 'n')
                        <button type="button" id="btn-material" class="btn btn-danger btn-flat fa fa-close" style="width: 40px;"></button>
                        @else 
                            @if ($row->qtdeEstoque < $row->quantidade)
                                <button type="button" class="btn btn-warning btn-flat fa fa-minus" style="width: 40px;"></button>
                            @else
                                <button type="button" class="btn btn-success btn-flat fa fa-check"></button>
                            @endif    
                        @endif</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    
</div>
<div class="modal-footer">
    {!! Form::button('Cancelar', ['class' => 'btn btn-default pull-left', 'id' => 'fechar']) !!}
    {!! Form::submit('Salvar', ['class' => 'btn btn-success', 'id' => 'salvar-funcao']) !!}
</div>
{!! Form::close() !!}

<script type="text/javascript">

    var saidaEstoqueConferido;
    
    @if(isset($saidaEstoque))
        //saidaEstoqueConferido = JSON.parse('{{$saidaEstoque->toJson()}}'.replace(/&quot;/g,'"'));
        saidaEstoqueConferido = {!! $saidaEstoque !!};
    @endif
</script>