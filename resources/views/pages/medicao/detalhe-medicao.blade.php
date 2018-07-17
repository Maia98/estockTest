@extends('layouts.default')

@section('main-content')
<div class="box">
    <div class="box-header page-header">
        <h1><i class="glyphicon glyphicon-menu-right"></i>Detalhe Medição</h1>
        @include('layouts.partials.alert-notify')
    </div>
    <div class="box-body">
        <div class="box-body" style="background-color: #f5f5f5;">
            <div class="row">
                <div class="col-md-4">
                    <span><strong>Número da Obra: </strong>{{$dadosMedicao->obra->numero_obra }}</span>
                </div>

                <div class="col-md-4">
                    <span><strong>Status: </strong>{{ $dadosMedicao->statusMedicao->nome }}</span>
                </div>

                <div class="col-md-4">
                    <span><strong>Fiscal: </strong>{{ $dadosMedicao->fiscal->nome }}</span>
                </div>

            </div>
        

            <br/>

            <div class="row">

                <div class="col-md-4">
                    <span><strong>Data Execução: </strong>{{dateToView($dadosMedicao->data_medicao)}}</span>
                </div>

                <div class="col-md-4">
                    <span style="color: rgb(0,153,0)"><strong>Valor Total: </strong>R$ {{ number_format($totalMedicao,2,",",".")}}</span>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-md-12">
                    <strong>
                        Apontamentos:
                    </strong>
                    <span>
                        {{ $itensApontamento }}
                    </span>
                </div>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-3" style="margin-top:5px;">
                <div class="btn-group">
                    <button type="button" class="btn btn-gray dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Exportar <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('/medicao/detalhes/exportar-excel') .'/'. $dadosMedicao->id }}" id="btn-excel"><i class="fa fa-file-excel-o"></i> Excel</a></li>
                        <li><a href="{{ url('/medicao/detalhes/exportar-pdf') .'/'. $dadosMedicao->id }}" id='btn-pdf'  target="_blank" ><i class="fa fa-file-pdf-o"></i> Pdf</a></li>
                    </ul>
                </div> 
            </div>
        </div>

        <br />

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tipo Mão de Obra</th>
                    <th>Código</th>
                    <th>Descrição Serviço</th>
                    <th>Qtde</th>
                    <th>Valor Unitário</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($itensMedicao as $itens)
                    <tr>
                        <td>{{ $itens->tipoMaoObra() }}</td>
                        <td>{{ $itens->cod_mobra }}</td>
                        <td>{{ $itens->descricao_mobra }}</td>
                        <td>{{ $itens->qtde}}</td>
                        <td>R$ {{ number_format($itens->valor_unitario,2,",",".") }}</td>
                        <td>R$ {{ number_format($itens->sub_total,2,",",".") }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <br/>

        <div class="row">
            <div class="col-md-9">
                <a href={{url("/medicao/gerenciador")}} style="text-decoration:none; color:#515151;"><button type="button" class="btn btn-gray"><i class="fa fa-chevron-left"></i> &nbsp; Voltar</button></a>
            </div>
        </div>
    </div>
</div>

@includeIf('layouts.partials.modal', ['idModal' => 'modal-form-medicao', 'idContent' => 'content-modal-medicao' ])

@stop

@section('scripts-footer')
@stop