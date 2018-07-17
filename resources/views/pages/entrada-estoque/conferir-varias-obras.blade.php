<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title">Conferir Entrada Estoque</h4>
</div>
{!! Form::open(['action' => ('EntradaEstoqueController@store'), 'id' => 'form-conferir-entrada-estoque-varias-obras']) !!}
<div class="modal-body">
    <div id='alert-modal' class="alert" style="display: none;"></div>
    <div class="panel" style="background: #f5f5f5;">
        <div class="panel-body">
            <div class="form-inline">
            @if(isset($entradaEstoque))
                <div class="row">
                    <div class="col-md-4">
                        {!! Form::label('data', 'Data Recebimento:') !!}
                        <b>{{ $entradaEstoque->data }}</b>
                    </div>
                    <div class="col-md-4">
                        {!! Form::label('almoxarifado', 'Almoxarifado:') !!}
                        <b>{{$entradaEstoque->almoxarifado->nome}}</b>
                    </div>
                    <div class="col-md-4">
                        {!! Form::label('tipo_entrada', 'Tipo de Entrada:') !!}
                        <b>{{$entradaEstoque->tipoEntrada->nome}}</b>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        {!! Form::label('conferente', 'Conferente:') !!}
                        <b>{{$entradaEstoque->conferente->nome.' '.$entradaEstoque->conferente->sobrenome}}</b>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        {!! Form::label('observacoes', 'Observações:') !!}
                        <b>{{$entradaEstoque->obs}}</b>
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
                    <th>Núm. Obra</th>
                    <th>Cód-Descrição</th>
                    <th>Orçado</th>
                    <th>Qtde. Estoque</th>
                    <th>Saldo</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            @foreach($entradaEstoque->materiais as $row)
            <tr>
                @if(isset($row->num_obra) && $row->obraExiste == 'n')
                    <td style="color: red; cursor: pointer;" onclick="window.open('{{url('obra/create')}}', '_blank')"><strong>{{ $row->num_obra }}</strong></td>
                @else
                    <td>{{$row->num_obra}}</td>
                @endif
                <td>{{ $row->descricao }}</td>
                <td>{{ $row->quantidade }}</td>
                <td>{{ $row->qtdeEstoque == null ? 0 : $row->qtdeEstoque }}</td>
                <td>{{ isset($row->existe) && $row->existe == 'n' ? 0 : $row->quantidade + $row->qtdeEstoque }}</td>
                <td>
                    @if(isset($row->existe) && $row->existe == 'n')
                        <button type="button" id="btn-material" class="btn btn-primary btn-flat fa fa-plus" style="width: 40px;" onclick="inserir(this, {{$row->codigo_material}},'{{$row->descricao_original}}');"></button>
                    @else
                        <button type="button" class="btn btn-success btn-flat fa fa-check" ></button>
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer">
    {!! Form::button('Cancelar', ['class' => 'btn btn-default pull-left', 'id' => 'fechar']) !!}
    {!! Form::submit('Salvar', ['class' => 'btn btn-success', 'id' => 'salvar-varias-obras']) !!}
</div>
{!! Form::close() !!}

<script type="text/javascript">

    var entradaEstoqueConferido;
    
    @if(isset($entradaEstoque))
        //entradaEstoqueConferido = JSON.parse({{$entradaEstoque->toJson()}}'.replace(/&quot;/g,'"'));
        entradaEstoqueConferido = {!! $entradaEstoque !!};
    @endif
</script>