@extends('layouts.default')

@section('main-content')

<div class="box">
    <div class="box-header page-header">
        <h1><i class="glyphicon glyphicon-menu-right"></i>Cadastrar Medição</h1>
        @include('layouts.partials.alert-notify')
    </div>
    <div class="box-body">
            {!! Form::open(['action' => ('MedicaoController@store'), 'id' => 'form-medicao']) !!}
            <fieldset>
                <legend>Dados</legend> 
                <div class="row">
                    <div class="col-md-3">
                        {!! Form::label('obra_id', 'Número Obra:') !!}
                        {!! Form::select('obra_id', arrayToselect($obra, 'id', 'numero_obra'), null, ['id' => 'obra_input', 'class' => 'form-control']) !!}
                    </div>

                    <div class="col-md-3">
                        {!! Form::label('funcionario_fiscal_id', 'Fiscal:') !!}
                        <div class="input-group">
                            {!! Form::select('funcionario_fiscal_id',  arrayToselect($fiscal, 'id', 'nome'), null, ['id' => 'funcionario_fiscal', 'class' => 'form-control']) !!}
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-flat" onclick="createFiscal();"><i class="fa fa-plus"></i></button>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        {!! Form::label('status_medicao_id', 'Status:') !!}
                        <div class="input-group">
                            {!! Form::select('status_medicao_id', arrayToselect($statusMedicao, 'id', 'nome'), null, ['id' => 'status_medicao_id', 'class' => 'form-control']) !!}
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-flat" onclick="createStatus();"><i class="fa fa-plus"></i></button>
                            </span>
                        </div>

                    </div>

                    <div class="col-md-3">
                        {!! Form::label('data_medicao', 'Data Medição:') !!}
                        {!! Form::date('data_medicao', null, ['id' => 'data_cadastro', 'class' => 'form-control', 'id' => 'input_data_medicao']) !!}
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        {!! Form::label('observacao', 'Observações:') !!}
                        {!! Form::textarea('observacao', null, ['id' => 'observacoes_obra', 'class' => 'form-control', 'rows' => '9']) !!}
                    </div>
                    <div class="col-md-6">
                        <fieldset class="fsStyle"  style="height: 250px;">
                            <legend><strong>Apontamento</strong></legend>
                            <div class="input-group">
                                {!! Form::select('apontamento-medicao', arrayToSelect($apontamentoMedicao , 'id', 'nome') ,null, ['class' => 'form-control', 'id' => 'select-apontamento-medicao']) !!}
                                <span class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-flat" onclick="createApontamento();"><i class="fa fa-plus"></i></button>
                            <button type="button" class="btn btn-primary btn-flat" style="margin-left: 10px;" onclick="addApontamento();"><i class="fa  fa-plus"></i> Adicionar</button>
                      </span>
                            </div>
                            <br />
                            <div style="height: 180px; overflow-y: auto;">
                                <table class="table table-bordered" id="table-apontamento">
                                    <thead>
                                    <tr>
                                        <th>Apontamento</th>
                                        <th style="width: 100px;">Ações</th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    </tbody>

                                </table>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <br/>
            </fieldset>
        <br/>
        
        <div class="row">
            
            <div class="col-md-12">
            
                <fieldset>
                    <legend>Dados da Medição</legend>
    
                    <div class="col-md-2">
                        {!! Form::label('tipo_mao_de_obra', 'Tipo Mão de Obra:') !!}
                        {!! Form::select('mao_de_obra', arrayToselect($tipoMaoObra, 'id', 'nome'), null, ['id' => 'select_tipo_mao_obra', 'class' => 'form-control']) !!}
                    </div>

                    <div class="col-md-2">
                        {!! Form::label('', 'Buscar Por:') !!}
                        {!! Form::select('codigo', ['0' => 'CÓDIGO', '1' => 'DESCRIÇÃO'], null, ['id' => 'opcao_busca', 'class' => 'form-control']) !!}
                    </div>
                    
                    <div class="col-md-4">
                        {!! Form::label('campo_pesquisa' , 'Campo de Pesquisa:') !!}
                        {!! Form::text('campo_pesquisa', null, ['id' => 'campo_pesquisa', 'class' => 'form-control ui-autocomplete-input ui-autocomplete-loading']) !!}
                    </div>

                    <div class="col-md-2">
                        {!! Form::label('quantidade_obra', 'Quantidade:') !!}
                        {!! Form::number('quantidade', null, ['id' => 'quantidade_obra', 'class' => 'form-control', 'min' => '1']) !!}
                    </div>

                    <div class="col-md-1" style="margin-top: 5px;">
                        <br/>
                         <button type="button" class="btn btn-primary btn-flat" id="add" onclick="adicionarDadosMedicao();"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Adicionar</button>
                    </div>

                    <div style="clear:both;"></div>
                    <br/>

                    <table id="dadosMedicaoArray" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mão de Obra</th>
                                <th>Código</th>
                                <th>Descrição Serviço</th>
                                <th>Qtde</th>
                                <th>Valor Unitário</th>
                                <th>Subtotal</th>
                                <th style="width: 50px">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($dadosMedicao))
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td style="width: 45px">
                                        <button type="button"  class="btn btn-danger btn-xs" onclick="deletarDadosMedicao('')">
                                            <i class="glyphicon glyphicon-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        </tbody>

                    </table>

                </fieldset>

            </div>
        </div>            
        
        <br/>        
        
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12" style="background-color: #eee;padding: 10px;">
                    <div class="col-md-3">
                       <span><strong>Valor da US: </strong>R$ <span id="valor_us">{{ isset($valorUS->id) ? $valorUS->valor : '0,00'}}</span> &nbsp;<button type="button" onclick="adicionarValorUs();" class="btn btn-primary btn-xs" title="Editar Valor US"><i class="glyphicon glyphicon-pencil"></i></button></span> 
                    </div>

                    <div class="col-md-3">
                       <span><strong>Total Mão de Obra ODI: <span id='odi' class="valoresDinheiro" style="color: rgb(50,50,131)">R$ 0,00</strong></span></span> 
                    </div>

                    <div class="col-md-3">
                       <span><strong>Total Mão de Obra ODD: <span id='odd' class="valoresDinheiro" style="color: rgb(212,61,61)">R$ 0,00</strong></span></span> 
                    </div>

                    <div class="col-md-3">
                       <span><strong>Valor Total da Mão de Obra: <span id='total_valor_obra' class="valoresDinheiro" style="color: rgb(8,156,8)">R$ 0,00</strong></span></span> 
                    </div>

                </div>
            </div>
        </div>

        <br/>

        <div class="row">
                <div class="col-md-11">
                    <a href="/medicao/gerenciador" style="text-decoretion:none; color:#515151;"><button type="button" class="btn btn-gray"><i class="fa fa-chevron-left"></i> &nbsp; Voltar</button></a>
                </div>
                <div class="col-md-1">
                    <button type="submit" id="salvar-medicao" class="btn btn-success">Salvar</button>
                </div>
        </div>

    </div>
</div>

@includeIf('layouts.partials.modal', ['idModal' => 'modal-form-status-medicao', 'idContent' => 'content-modal-status-medicao' ])

@includeIf('layouts.partials.modal', ['idModal' => 'modal-form-funcionario', 'idContent' => 'content-modal-funcionario' ])

@includeIf('layouts.partials.modal', ['idModal' => 'modal-form-valor-us', 'idContent' => 'content-modal-valor-us' ])

@includeIf('layouts.partials.modal', ['idModal' => 'modal-form-apontamento-medicao', 'idContent' => 'content-modal-apontamento-medicao' ])

@stop

@section('scripts-footer')
    <script type="text/javascript" src="{{ url('js/tabelas-tipos/tipo-status-medicao.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/tabelas-tipos/apontamento-medicao.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/tabelas-tipos/funcionario.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/medicao.js') }}"></script>
@stop