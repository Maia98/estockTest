@extends('layouts.default')
@section('main-content')

<style>
    .c3-axis-x-label {
        font: 13px sans-serif;
        font-weight: bold;
    }
    .c3-chart-arcs-title {
        font: 13px sans-serif;
        font-weight: bold;
    }
    .listViewParques {
        border: solid 1px #d2d6de; 
        height: 63px; 
        width: 250px; 
        overflow-y: auto;
    }
    .listViewParques ul {
        list-style-type: none;
        padding: 0;
    }
    .listViewParques ul li:hover{
        background-color: #dadada;
        cursor: pointer;
    }
    .listViewParques ul li a{
        margin: 0px 5px;
        color: #000000;
    }
    .msg-alert-filter {
        padding-left: 45px;
        font-weight: bold;
    }
</style>
<div id="box-pesquisar" class="box box-default color-palette-box">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        <div class="row">
            <div id='alert' class="alert "></div>
            <div class="col-md-12">
                <div class="box box-primary box-solid collapsed-box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Principais resultados obtidos de {{ date("d/m/Y",strtotime($data_inicio_filtro)) }} até {{ date("d/m/Y",strtotime($data_fim_filtro)) }}</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        {!! Form::open(['action' => ('GerencialController@index'), 'id' => 'form-filtro', 'method' => 'GET']) !!}
                        <div class="col-md-3 data_inicio_input form-group">
                            {!! Form::label('data_inicio', 'De:') !!}
                            {!! Form::date('data_inicio', $data_inicio_filtro, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-3 data_fim_input form-group">
                            {!! Form::label('data_fim', 'Até:') !!}
                            {!! Form::date('data_fim', $data_fim_filtro, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-3" style="margin-top: 2.3%;">
                            <button type="submit" class="btn btn-primary btn-flat btn_icon_filter"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span> Filtrar</button>
                            <button type="button" class="btn btn-primary btn-flat" id="btn_save_periodo"><span class="fa fa-save" aria-hidden="true"></span></button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary" id="box-obra-por-status">
                    <div class="box-header with-border">
                        <h3 class="box-title">Obra Por Status</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" id="refresh_ObraPorStatus" data-toggle="tooltip" title="Atualizar" data-widget="chat-pane-toggle" data-original-title="Atualizar"><i class="fa fa-refresh"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="overlay overlayObraStatus" id="overlay" style="display: block;" >
                          <i class="fa fa-refresh fa-spin"></i>
                          <h4 class="msg-alert-filter"></h4>
                        </div>
                        <div id="obraPorStatus"></div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">            
        	<div class="col-md-12">
        		<div class="box box-primary">
        			<div class="box-header with-border">
        				<h3 class="box-title">Obra por Regional</h3>
        				<div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" id="refresh_ObraPorRegional" data-toggle="tooltip" title="Atualizar" data-widget="chat-pane-toggle" data-original-title="Atualizar"><i class="fa fa-refresh"></i></button>
        				</div>
        			</div>
    	    		<div class="box-body">
                        <div class="overlay overlayObraPorRegional" id="overlay" style="display: block;" >
                          <i class="fa fa-refresh fa-spin"></i>
                          <h4 class="msg-alert-filter"></h4>
                        </div>
                        <div id="obrasPorRegional"></div>
    	    		</div>
          		</div>
            </div>
    	</div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Obra por Valor(R$) Orçado</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" id="refresh_ObraPorValorOrcado" data-toggle="tooltip" title="Atualizar" data-widget="chat-pane-toggle" data-original-title="Atualizar"><i class="fa fa-refresh"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="overlay overlayObraPorValorOrcado" id="overlay" style="display: block;" >
                          <i class="fa fa-refresh fa-spin"></i>
                          <h4 class="msg-alert-filter"></h4>
                        </div>
                        <div id="obraPorValorOrcado"></div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>


<script type="text/javascript">
    
    $(document).ready(function(){
        
        getObraPorStatus();
        getObraPorRegional();
        getObraPorValorOrcado();


        $("#form-filtro").on("submit",function(event){
            
            if(validarFiltro()){
                $( "#form-filtro" ).submit();
            }
            event.preventDefault();
        });

        
        function getObraPorStatus(){

            var formData = new FormData();
            var _token = '{{ csrf_token() }}';
            formData.append('_token', _token);
            formData.append('data_inicio', $('#data_inicio').val());
            formData.append('data_fim', $('#data_fim').val());

            $.ajax({
                type: "POST",
                dataType: 'json',
                url: urlBase + "gerencial/obra-por-status",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function(data){
                    if (data.success === true) {
                        
                        var result = {};
                        var status_obra_descricao = [];
                        var total = 0;
                        
                        JSON.parse(data.result).forEach(function(e) {
                            status_obra_descricao.push(e.nome);
                            result[e.nome] = e.count_status_obra;
                            total += parseInt(e.count_status_obra);
                        });
                        
                        var obraPorStatus = c3.generate({
                            bindto: '#obraPorStatus',
                            data: {
                                json: [ result ],
                                keys: {
                                    value: status_obra_descricao,
                                },
                                type : 'donut'
                            },
                            donut: {
                                title: "Total: "+ total,
                                label: {
                                  format: function (value) { return value; }
                                }
                            }
                        });

                        $(".overlayObraStatus").hide();

                    }else{
                        $('#obraPorStatus').empty();
                        $('.overlayObraStatus i').removeClass('fa fa-refresh fa-spin');
                        $('.overlayObraStatus i').addClass('fa fa-calendar-times-o');
                        $('.overlayObraStatus i').css({'left':'2%', 'top': '28%'});
                        $('.overlayObraStatus h4').text(data.msg);
                    }
                }
            });
        }

        function getObraPorRegional(){

            var formData = new FormData();
            var _token = '{{ csrf_token() }}';
            formData.append('_token', _token);
            formData.append('data_inicio', $('#data_inicio').val());
            formData.append('data_fim', $('#data_fim').val());

            $.ajax({
                type: "POST",
                dataType: 'json',
                url: urlBase + "gerencial/obra-por-regional",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function(data){
                    if (data.success === true) {
                        
                    var xvalue;
                    var yvalue = [];
                    var i = 0;

                    for ( var key2 in data.result) {
                        for ( var key in data.result[key2]) {
                            if (xvalue == undefined)
                                xvalue = key;
                            else {
                                yvalue[i] = key;
                                i++;
                            }
                        }
                    }

                    var obrasPorRegional = c3.generate({
                        bindto: '#obrasPorRegional',
                        data : {
                            json : data.result,
                            type : 'bar',
                            labels: true,
                            keys : {
                                x : xvalue,
                                value : yvalue,
                            },
                            groups: [yvalue]
                        },
                        bar : {
                            width : {
                                ratio : 0.3
                            }
                        },
                        axis : {
                            x : { 
                                type : 'category'
                            },
                        },
                        grid: {
                            y: {
                                lines: [{value: 0}]
                            }
                        }
                    });

                        $(".overlayObraPorRegional").hide();

                    }else{
                        $('#obrasPorRegional').empty();
                        $('.overlayObraPorRegional i').removeClass('fa fa-refresh fa-spin');
                        $('.overlayObraPorRegional i').addClass('fa fa-calendar-times-o');
                        $('.overlayObraPorRegional i').css({'left':'2%', 'top': '28%'});
                        $('.overlayObraPorRegional h4').text(data.msg);
                    }
                }
            });
        }

        function getObraPorValorOrcado(){

            var formData = new FormData();
            var _token = '{{ csrf_token() }}';
            formData.append('_token', _token);
            formData.append('data_inicio', $('#data_inicio').val());
            formData.append('data_fim', $('#data_fim').val());

            $.ajax({
                type: "POST",
                dataType: 'json',
                url: urlBase + "gerencial/obra-por-valor-orcado",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function(data){
                    if (data.success === true) {
                    var xvalue;
                    var yvalue = [];
                    var i = 0;
                    var valores_orcados = [];

                    for ( var key2 in data.result) {
                        for ( var key in data.result[key2]) {
                            if (xvalue == undefined)
                                xvalue = key;
                            else {
                                valores_orcados.push(data.result[key2].valor_orcado);
                                yvalue[i] = key;
                                i++;
                            }
                        }
                    }

                    var obraPorValorOrcado = c3.generate({
                        bindto: '#obraPorValorOrcado',
                        data : {
                            json : data.result,
                            names: {
                                'valor_orcado': 'Valor Orçado',
                            },
                            type : 'bar',
                            keys : {
                                x : xvalue,
                                value : yvalue,
                            },
                            groups: [yvalue],
                            labels: {
                                format: function (v) { return "R$ " + formatReal(v); },
                            },
                        },
                        bar : {
                            width : {
                                ratio : 0.2
                            }
                        },
                        axis : {
                            x : { 
                                type : 'category'
                            },
                            y: {
                                tick: {
                                    // format: d3.format("R$,")
                                   format: function (d) { return "R$" + formatReal(d); }
                                },
                                max: Math.max.apply(null, valores_orcados),
                            }
                        },
                        tooltip: {
                            contents: function (d, defaultTitleFormat, defaultValueFormat, color) {
                            return "<table class='c3-tooltip'>"+
                                      "<tbody>"+
                                        "<tr><th colspan='2'>Obra - "+defaultTitleFormat(d[0].index)+"</th></tr>"+
                                        "<tr class='c3-tooltip-name-data1'>"+
                                            "<td class='name'><span style='background-color:#1f77b4'></span>Valor Orçado</td>"+
                                            "<td class='value'>R$ "+formatReal(d[0].value)+"</td>"+
                                        "</tr>"+
                                      "</tbody>"+
                                    "</table>";
                    
                            }
                        }
                    });

                        $(".overlayObraPorValorOrcado").hide();

                    }else{
                        $('#obraPorValorOrcado').empty();
                        $('.overlayObraPorValorOrcado i').removeClass('fa fa-refresh fa-spin');
                        $('.overlayObraPorValorOrcado i').addClass('fa fa-calendar-times-o');
                        $('.overlayObraPorValorOrcado i').css({'left':'2%', 'top': '28%'});
                        $('.overlayObraPorValorOrcado h4').text(data.msg);
                    }
                }
            });
        }     

        //BTN REFRESH OBRA POR STATUS
        $("#refresh_ObraPorStatus").on("click", function(event) {
            if(validarFiltro()){
                $(".overlayObraStatus").show();
                getObraPorStatus();
            }
        });

        //BTN REFRESH OBRA POR REGIONAL
        $("#refresh_ObraPorRegional").on("click", function(event) {
            if(validarFiltro()){
                $(".overlayObraPorRegional").show();
                getObraPorRegional();
            }
        });

        //BTN REFRESH OBRA POR VALOR ORÇADO
        $("#refresh_ObraPorValorOrcado").on("click", function(event) {

            if(validarFiltro()){
                $(".overlayObraPorValorOrcado").show();
                getObraPorValorOrcado();
            }
        });

        function formatReal(int){
            return int.toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+\,)/g, "$1.");
        }
        
        $("#btn_save_periodo").on("click", function(event) {

            if(validarFiltro()){
                waitingDialog.show();
                var formData = new FormData();
                var _token = '{{ csrf_token() }}';
                formData.append('_token', _token);
                formData.append('data_inicio', $('#data_inicio').val());
                formData.append('data_fim', $('#data_fim').val());

                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: urlBase + "gerencial/store-filter-usuario",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(data){
                        if (data.success === true) {
                            showAlert('success', data.msg);
                        }else{
                            showAlert('warning', data.msg);
                        }
                    }
                });
                waitingDialog.hide();
            }

        });
    });


    function validarFiltro(){

        if($('#data_inicio').val() === '' && $('#data_fim').val() === ''){
            $('.data_inicio_input').addClass('has-warning');
            $('.data_fim_input').addClass('has-warning');
            showAlert('warning', 'Datas não preenchidas.');
            return false;
        }else if($('#data_inicio').val() != '' && $('#data_fim').val() === ''){
            $('.data_inicio_input').removeClass('has-warning');
            $('.data_fim_input').addClass('has-warning');
            showAlert('warning', 'Data Até: não preenchidas.');
            return false;
        }else if($('#data_inicio').val() === '' && $('#data_fim').val() != ''){
            $('.data_inicio_input').addClass('has-warning');
            $('.data_fim_input').removeClass('has-warning');
            showAlert('warning', 'Data De: não preenchidas.');
            return false;
        }else{
            $('.data_inicio_input').removeClass('has-warning');
            $('.data_fim_input').removeClass('has-warning');
            return true;
        }
    }
</script>
@stop