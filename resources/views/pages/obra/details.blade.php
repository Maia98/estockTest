<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"><strong> Detalhes da Obra</strong></h4>
</div>
    <div class="modal-body" style="max-height: 550px; overflow:auto;">
        <div class="box-body">
            <div class="row">    
                <div class="col-md-12">
                    <strong>Número:</strong> {!! $obra->numero_obra !!}
                </div>           
                
                <div class="col-md-12">
                    <strong>Status:</strong> {!! $obra->statusObra->nome !!} 
                </div>
                
                <div class="col-md-12">
                    <strong>Propriedade:</strong> {!! $obra->prioridadeObra->nome!!} 
                </div>
                
                <div class="col-md-12">
                    <strong>Setor:</strong> {!! $obra->setorObra->descricao!!} 
                </div>
                
                <div class="col-md-12">
                    <strong>Regional:</strong> {!! $obra->cidade->regional->descricao !!} 
                </div>
                
                <div class="col-md-12">
                    <strong>Cidade:</strong> {!! $obra->cidade->nome !!} 
                </div>
                
                <div class="col-md-12">
                    <strong>Tipo:</strong> {!! $obra->tipoObra->descricao!!} 
                </div>

                <div class="col-md-12">
                    <strong>Valor Orçado:</strong> R$ {{$obra->valor_orcado}}
                </div>
                
                <div class="col-md-12">
                    <strong>Valor Pago:</strong> R$ {{number_format($obra->getValorPago(),2,",",".")}}
                </div>
                
                <div class="col-md-12">
                    <strong>Valor Medido:</strong> R$ {{number_format($obra->getValorMedido(),2,",",".")}}
                </div>
            
                <div class="col-md-12">
                    <strong>Data Abertura:</strong> {{ $obra->data_abertura }}
                </div>         
                <div class="col-md-12">        
                    <strong>Data Recebimento:</strong>  {{ $obra->data_recebimento }} 
                </div>
                
                <div class="col-md-12">
                    <strong>Início Execução:</strong> {{ $obra->prazo_execucao_inicio }}   
                </div>

                <div class="col-md-12">
                    <strong>Término Execução:</strong> {{ $obra->prazo_execucao_fim }}   
                </div>
                
                <div class="col-md-12">
                    <strong>Previsão Retirada Material:</strong>  {{ $obra->data_previsao_retirada_material }}    
                </div>
                <div class="col-md-12">
                    <strong>Supervisor:</strong> {{ $obra->funcionarioSupervisor->nome or '' }} {{ $obra->funcionarioSupervisor->sobrenome or ''}}
                </div>
                
                <div class="col-md-12">
                    <strong>Fiscal:</strong> {{ $obra->funcionarioFiscal->nome or ''}} {{ $obra->funcionarioFiscal->sobrenome or ''}}
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary collapsed-box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Encarregado</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body" style="height: 80px; overflow-x: auto;">
                           @foreach($encarregado as $encarregados)
                            <p>{{ $encarregados->nome }} {{ $encarregados->sobrenome }}</p>
                           @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary collapsed-box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Apoio</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body" style="height: 80px; overflow-x: auto;">
                          @foreach($apoio as $apoios)
                            <p>{{ $apoios->descricao }}</p>
                          @endforeach
                        </div>
                    </div>
                </div>
            </div> 
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary collapsed-box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Medidor</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body" style="height: 80px; overflow-x: auto;">
                                <p>{{ $obra->medidor }}</p>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary collapsed-box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Instalação</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body" style="height: 80px; overflow-x: auto;">
                                <p>{{ $obra->instalacao }}</p>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary collapsed-box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Observação</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body" style="height: 80px; overflow-x: auto;">
                            <p>{{ $obra->observacao }}</p>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    <div class="modal-footer">
        {!! Form::button('Cancelar', ['class' => 'btn btn-default pull-left', 'data-dismiss' =>'modal']) !!}
    </div>
{!! Form::close() !!}

