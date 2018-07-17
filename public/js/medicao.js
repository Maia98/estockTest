var dadosMedicao = new Array();
var campoPesquisa = new Array();
var _apontamentos = new Array();
var totalODI = 0;
var totalODD = 0;
var valorUs = 0;
var dados = new Array();
var statusNew = [];
var funcionarioNew = [];
var apontamentoMedicaoNew = [];

$('select').select2();

$('#obra_id, #funcionario_fiscal_id').select2();

$('.sub_total').priceFormat({
        prefix: 'R$',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });

$( document ).ready(function() {
// recebe o valor de US como float e depois devolve como fixed para a mascara funcionar adequadamente    
    valorUs = parseFloat($('#valor_us').text());
    $('#valor_us').text(valorUs.toFixed(2));
    $('#valor_us').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });
});

$('#data_termino').on('change',function(){
    var data_inicio  = $('#data_inicio').val();
    var data_termino = $('#data_termino').val();

    if(data_termino < data_inicio){
    	$.confirm({
    		title   : 'Data',
    		content : 'Data término é menor que a data início',
    		type    : 'red',
    		buttons :{
    			ok  :{
	    			text 	 : 'OK',
	    			btnClass : 'btn-danger',
	    			action   : function(){}
    			}
    		}

    	});

    	$('#data_termino').val('');
    }
    
});

$('#data_inicio').on('change',function(){
    var data_termino = $('#data_termino').val();
    var data_inicio  = $('#data_inicio').val();
    if(data_termino != ''){

    	if(data_inicio > data_termino){
	    	$.confirm({
	    		title   : 'Data',
	    		content : 'Data Início é maior que a data término',
	    		type    : 'red',
	    		buttons :{
	    			ok  :{
		    			text 	 : 'OK',
		    			btnClass : 'btn-danger',
		    			action   : function(){}
	    			}
	    		}

	    	});

	    	$('#data_inicio').val('');
	    }

    }
    
});

$('#filtrar').click(function(){
	var data_inicio = $('#data_inicio').val();
    var data_final  = $('#data_termino').val();
    var msg         = '';

    if(data_inicio != '' && data_final == ''){
    	msg = "A data término não foi preenchida";
    }else if(data_inicio == '' && data_final != ''){
    	msg = "A data início não foi preenchida";
    }

    if(msg != ''){
    	$.confirm({
    		title   : 'Data',
    		content : msg,
    		type    : 'red',
    		buttons :{
    			ok  :{

	    			text 	 : 'OK',
	    			btnClass : 'btn-danger',
	    			action   : function(){}
    			}
    		}

    	});
    	return false;
    }

});

$("#content-modal-medicao").on("click", "#fechar-medicao", function() {
    $('#modal-form-medicao').modal('toggle');
});

$("#form-medicao").submit(function(event){
    event.preventDefault();
    waitingDialog.show('Carregando...');
    //desabilitar quando for enviado a requisicao   
    document.getElementById("salvar-medicao").disabled = true;
    
    $('#dadosMedicaoArray').val(JSON.stringify(dadosMedicao));
    dados = $("#form-medicao").serializeArray();
    dados.push({ name: 'dados_medicao', value: $('#dadosMedicaoArray').val()});
    dados.push({ name: 'apontamentos', value: _apontamentos});

    $.ajax({
        type: "POST",
        dataType: 'json',
        url: urlBase + "medicao/store",
        data: dados,
        success: function(data){
            if (data.success === true) {
                waitingDialog.hide();
                showAlert('success', data.msg);
                $('html, body').animate({ scrollTop: 10 }, 300);
                setTimeout(function(){ 
                    window.location.href = urlBase + "medicao/gerenciador";
                }, 1000);
               
            }else{
                document.getElementById("salvar-medicao").disabled = false;
                waitingDialog.hide();
                showAlert('warning', data.msg);
                $('html, body').animate({ scrollTop: 10 }, 500);
            }
        }
    });

});

function editar(id){
    $.get(urlBase + "medicao/edit/" + id, function(resposta){
        $("#content-modal-medicao").html(resposta);
        $('#modal-form-medicao').modal('show')
    });
}

function deletar(id){
    $.get(urlBase + "medicao/delete/" + id, function(resposta){
        $("#content-modal-medicao").html(resposta);
        $('#modal-form-medicao').modal('show')
    });
}

function detalhes(id){
    window.location.replace(urlBase + "medicao/detalhe-medicao/" + id);
}

function createValorPago(id){
    $.get(urlBase + "medicao/create-valor-pago/" + id, function(resposta){
        if(resposta != 'undefined' && resposta.success === false){
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-valor-pago").html(resposta);
            $('#modal-form-valor-pago').modal('show');
            $('#valor_pago').priceFormat({
                prefix: '',
                centsSeparator: ',',
                thousandsSeparator: '.'
            });
        }
    });
}

$("#content-modal-valor-pago").on("click", "#fechar-valor-pago", function() {
    $('#modal-form-valor-pago').modal('toggle');
});

$("#content-modal-valor-pago").on("submit", "#form-valor-pago",function(event){
    // removendo mascara
    $('#valor_pago').priceFormat({
        prefix: '',
        thousandsSeparator: '',
        clearOnEmpty: true
    });
    
    event.preventDefault();
    waitingDialog.show('Carregando...');
    //desabilitar quando for enviado a requisicao   
    document.getElementById("salvar-valor-pago").disabled = true;

    $.ajax({
        type: "POST",
        dataType: 'json',
        url: urlBase + "medicao/store-valor-pago",
        data: $("#form-valor-pago").serialize(),
        success: function(data){
            if (data.success === true) {
                showAlertModal('success', data.msg);
                setTimeout(function(){ 
                    location.reload();
                }, 1000);
                
            }else{
                document.getElementById("salvar-valor-pago").disabled = false;
                showAlertModal('warning', data.msg);
            }
            // recoloca a mascara de dinheiro
            waitingDialog.hide();
        }
    });
});

$("#campo_pesquisa").autocomplete({
    delay: 1000,
    source: function (request, response) {
        var tipoBusca = $("#opcao_busca option:selected").val();
        $.ajax({
            url: urlBase + "medicao/busca-dados",
            type: "GET",
            dataType: "json",
            data: { filterValue: request.term, typeFilter: tipoBusca },
            success: function (data) {
                if(data.result.length <= 0){
                    $.confirm({
                        title   : 'Campo de Pesquisa',
                        content : 'Nenhum serviço encontrado na busca!',
                        type    : 'red',
                        buttons :{
                            ok  :{
                                text     : 'OK',
                                btnClass : 'btn-danger',
                                action   : function(){}
                            }
                        }
                    });
                }
                response($.map(data.result, function (item) {
                    return {
                        label: item.cod_mobra + " | " + item.descricao,
                        nome: item.nome,
                        descricao: item.descricao,
                        value: item.cod_mobra,
                        instalar: item.instalar,
                        retirar: item.retirar,
                        instalar_emergencial: item.instalar_emergencial,
                        retirar_emergencial: item.retirar_emergencial
                    };
                }));
            }
        });//fim
    },
    select: function (event, ui) {
        // faz um clone do objeto selecionado 
        campoPesquisa = jQuery.extend({}, ui.item);
        ui.item.value = ui.item.label;
    }
});

function adicionarDadosMedicao(){

    var tipo_mao_obra    = $('#select_tipo_mao_obra').find('option:selected').text();
    var tipo_mao_obra_id = $('#select_tipo_mao_obra').find('option:selected').val();
    var campo_pesquida   = $('#campo_pesquisa').val();
    var quantidade       = $('#quantidade_obra').val();
    var tr               = '';
    var valorMaoObra;
    var valor_unitario; 
    var sub_total; 


    // Verificações 
    if(tipo_mao_obra_id == 0){
        $.confirm({
            title   : 'Tipo Mão de Obra',
            content : 'Tipo mão de obra não foi seleciondo!',
            type    : 'red',
            buttons :{
                ok  :{
                    text     : 'OK',
                    btnClass : 'btn-danger',
                    action   : function(){}
                }
            }
        });
        return false;
    }

    if(campo_pesquida == '' ){
        $.confirm({
            title   : 'Campo de Pesquisa',
            content : 'Campo de pesquisa não preenchido!',
            type    : 'red',
            buttons :{
                ok  :{
                    text     : 'OK',
                    btnClass : 'btn-danger',
                    action   : function(){}
                }
            }
        });
        return false;
    }

    if(quantidade == ''){
        $.confirm({
            title   : 'Quantidade',
            content : 'Quantidade não preenchida!',
            type    : 'red',
            buttons :{
                ok  :{
                    text     : 'OK',
                    btnClass : 'btn-danger',
                    action   : function(){}
                }
            }
        });
        return false;
    }

    if(quantidade <= 0){
        $.confirm({
            title   : 'Quantidade',
            content : 'Quantidade tem que ser maior que 0!',
            type    : 'red',
            buttons :{
                ok  :{
                    text     : 'OK',
                    btnClass : 'btn-danger',
                    action   : function(){}
                }
            }
        });
        return false;
    }

    // Funções 
    for (var i = 0; i < dadosMedicao.length;  i++) {
        // verifica se existe 
        if(dadosMedicao[i]['cod_mobra'] == campoPesquisa['value']){
            if(tipo_mao_obra_id == dadosMedicao[i]['tipo_mao_obra']){
                $.confirm({
                    title   : 'Item medição',
                    content : 'Item já incluido na lista com mão de obra ' + tipo_mao_obra , 
                    type    : 'red',
                    buttons :{
                        ok  :{
                            text     : 'OK',
                            btnClass : 'btn-danger',
                            action   : function(){}
                        }
                    }
                });
                return ;
            }
        }
    }

    // verifica qual o tipo de mão de obra para adicionar o valor ao valor unitario 
    switch(tipo_mao_obra_id){
        case '1':
            if(campoPesquisa['instalar'] <= 0 ){
                $.confirm({
                    title   : 'Item medição',
                    content : 'Operação Instalar não disponivel para item selecionado',
                    type    : 'red',
                    buttons :{
                        ok  :{
                            text     : 'OK',
                            btnClass : 'btn-danger',
                            action   : function(){}
                        }
                    }
                });
                return;
            }
            valorMaoObra = campoPesquisa['instalar'];
            tr = '<tr class=\"text-blue\">';
        break;
        
        case '2':
            if(campoPesquisa['retirar'] <= 0 ){
                $.confirm({
                    title   : 'Item medição',
                    content : 'Operação Retirar não disponivel para item selecionado',
                    type    : 'red',
                    buttons :{
                        ok  :{
                            text     : 'OK',
                            btnClass : 'btn-danger',
                            action   : function(){}
                        }
                    }
                });
                return;
            }
            valorMaoObra = campoPesquisa['retirar'];
            tr = '<tr class=\"text-red\">';            
        break;
        
        case '3':
            if(campoPesquisa['instalar_emergencial'] <= 0 ){
                    $.confirm({
                        title   : 'Item medição',
                        content : 'Operação Instalar Emergencial não disponivel para item selecionado',
                        type    : 'red',
                        buttons :{
                            ok  :{
                                text     : 'OK',
                                btnClass : 'btn-danger',
                                action   : function(){}
                            }
                        }
                    });
                    return;
                }
                valorMaoObra = campoPesquisa['instalar_emergencial'];
                tr = '<tr class=\"text-blue\">'; 
        break;
        
        case '4':
            if(campoPesquisa['retirar_emergencial'] <= 0 ){
                $.confirm({
                    title   : 'Item medição',
                    content : 'Operação Retirar Emergencial não disponivel para item selecionado',
                    type    : 'red',
                    buttons :{
                        ok  :{
                            text     : 'OK',
                            btnClass : 'btn-danger',
                            action   : function(){}
                        }
                    }
                });
                return;
            }
            valorMaoObra = campoPesquisa['retirar_emergencial'];
            tr = '<tr class=\"text-red\">';
        break;

        default:
        tr = '<tr';        
    }
    

    //  variaveis de valor unitario e o sub total a view
    //console.log('valor' + valorMaoObra);
    valor_unitario  = valorMaoObra * valorUs;
    valor_unitario  = valor_unitario.toFixed(2);
    sub_total       = valor_unitario * quantidade;
    sub_total       = sub_total.toFixed(2);
  

    // array para adicionar os dados da medição
    dadosMedicao.push({
        tipo_mao_obra: tipo_mao_obra_id,
        nome_mao_obra: campoPesquisa['nome'], 
        descricao_mao_obra: campoPesquisa['descricao'], 
        cod_mobra: campoPesquisa['value'],
        quantidade: quantidade,
        valor_us: valorUs,
        valor_unitario: valor_unitario,
        sub_total: sub_total,
    });

    adicionarValoresTotais(sub_total, tipo_mao_obra_id);
    
    // adicionando a view os valores
    tr += '<td>'+ tipo_mao_obra +'</td>';
    tr += '<td>'+ campoPesquisa['value'] +'</td>';
    tr += '<td>'+ campoPesquisa['descricao'] +'</td>';
    tr += '<td>'+ quantidade +'</td>';
    tr += '<td><span class="valor_unitario">'+ valor_unitario +'</span></td>';
    tr += '<td><span class="sub_total">'+  sub_total +'</span></td>';
    tr += "<td style='width: 45px'><button type=\"button\" title=\"Excluir\" class=\"btn btn-danger btn-xs\" onclick=\"deletarDadosMedicao('"+campoPesquisa['value']+"','"+ tipo_mao_obra_id +"')\"><i class=\"glyphicon glyphicon-trash\"></i></button></td>";
    tr += '</tr>';
    // adicionado valores na view e limpando os campos
    $("#dadosMedicaoArray").append(tr);
    $('#campo_pesquisa').val("");
    $('#quantidade_obra').val("");
    $('#select_tipo_mao_obra').val("0").change();
    // mascara nos valores uitario e sub total
    $('.valor_unitario, .sub_total, .valoresDinheiro').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });
}

function adicionarValorUs(){
    if(dadosMedicao.length > 0){
        $.confirm({
                title   : 'Valor US',
                content : 'Só é possivel alterar o valor da US se a lista de Dados estiver vazia',
                type    : 'red',
                buttons :{
                    ok  :{
                        text     : 'OK',
                        btnClass : 'btn-danger',
                        action   : function(){}
                    }
                }
            });
            return; 
    }
    $.get(urlBase + "medicao/create-valor-us", function(resposta){
        if(resposta != 'undefined' && resposta.success === false){
            showAlert('warning',resposta.msg);
        }else {
            $("#content-modal-valor-us").html(resposta);
            $('#modal-form-valor-us').modal('show');
            $('#valor, #valor_us').priceFormat({
                prefix: '',
                centsSeparator: '.',
                thousandsSeparator: ','
            });
        }
    });
}
// função que preenche as informações de valores abaixo da tabela de items medição
function adicionarValoresTotais(valor, tipoMaoObra){
    // na hora de excluir é chamada a mesma função porem o numero é convertido para negativo assim fazendo processo de subtração
    if(tipoMaoObra == 1 || tipoMaoObra == 3){
        totalODI = parseFloat(totalODI) + parseFloat(valor);
        $('#odi').text('R$ ' + totalODI.toFixed(2));
    }else{
        totalODD = parseFloat(totalODD) + parseFloat(valor);
        $('#odd').text('R$ ' + totalODD.toFixed(2));
    }
    
    var total  = parseFloat(totalODI) + parseFloat(totalODD);
        $('#total_valor_obra').text('R$ ' + total.toFixed(2));
}

function deletarDadosMedicao(cod_mobra,tipoMaoObra){
    console.log(cod_mobra);
    $.confirm({
        title: 'Excluir Dado Medição',
        type: 'red',
        animation: 'bottom',
        content: 'Deseja Realmente esse Dado ?',
        buttons: {
            confirm: {
                text: 'Sim',
                btnClass: 'btn-red',
                action: function(){
                    var linhaTabela = 0;
                    while(dadosMedicao[linhaTabela]['cod_mobra'] != cod_mobra && 
                          dadosMedicao[linhaTabela]['tipo_mao_obra'] != tipoMaoObra)
                    {
                        
                        linhaTabela++;
                    }
                    // chama função adicionar concatenando com valor negativo para executar a subtração dos valores
                    adicionarValoresTotais(-1 * dadosMedicao[linhaTabela]['sub_total'],dadosMedicao[linhaTabela]['tipo_mao_obra']);
                    // mascara recolocada pois quando um item é subtraido a mascara nao funciona mais
                    $('.valoresDinheiro').priceFormat({
                        prefix: '',
                        centsSeparator: ',',
                        thousandsSeparator: '.'
                    });   
                    dadosMedicao.splice(linhaTabela,1);
                    document.getElementById('dadosMedicaoArray').deleteRow(linhaTabela + 1);
                    return;
                }  
            },

            cancel: {
                text: 'Não',
                action: function(){

                }}
            }
        });
}

$("#content-modal-valor-us").on("click", "#fechar-valor-us", function() {
    $('#modal-form-valor-us').modal('toggle');
    $('#valor_us').priceFormat({
                        prefix: '',
                        centsSeparator: ',',
                        thousandsSeparator: '.'
                    });
});

$("#content-modal-valor-us").on("submit", "#form-valor-us",function(event){
    event.preventDefault();    
    waitingDialog.show('Carregando...');
    //desabilitar quando for enviado a requisicao   
    document.getElementById("salvar-valor-us").disabled = true;

    $.ajax({
        type: "POST",
        dataType: 'json',
        url: urlBase + "medicao/store-valor-us",
        data: $("#form-valor-us").serialize(),
        success: function(data){
            if (data.success === true) {
                showAlertModal('success', data.msg);
                setTimeout(function(){ 
                    
                    $('#modal-form-valor-us').modal('toggle');
                    valorUs = parseFloat(data.result.valor);
                    $('#valor_us').text(valorUs.toFixed(2));
                    $('#valor_us').priceFormat({
                        prefix: '',
                        centsSeparator: ',',
                        thousandsSeparator: '.'
                    });
                }, 1000);
            }else{
                
                document.getElementById("salvar-valor-us").disabled = false;
                showAlertModal('warning', data.msg);
            }
            // recoloca a mascara de dinheiro
            waitingDialog.hide();
        }
    });
});

$('#btn-pdf').on('click', function(event){
    window.open(urlBase + "medicao/exportar-pdf?" + $("#form_filter").serialize());
});

$('#btn-excel').on('click', function(event){
    $.ajax({
        cache: false,
        type: "GET",
        url: urlBase + "medicao/exportar-excel",
        data: $("#form-filter").serialize(),
        success: function(response, request){
            if(response.success === true) {
                var a = document.createElement("a");
                a.href = response.file;
                a.download = response.name;
                document.body.appendChild(a);
                a.click();
                a.remove();
            }else{
                showAlert('warning', response.msg);
            }
        }
    });
});

$('#input_data_medicao').change(function(){
    var date = new Date();
    if( date.getDate() > 9 && (date.getMonth()+1) >9) {
        var today = date.getFullYear()+'-'+(date.getMonth()+1)+'-'+ date.getDate();
    }
    else if((date.getMonth()+1) >9 && (date.getMonth()+1) <=9){
        var today = date.getFullYear()+'-'+(date.getMonth()+1)+'-'+ '0'+ date.getDate(); 
    }
    else if (date.getDate() > 9 && (date.getMonth()+1) <= 9){
     var today = date.getFullYear()+'-'+'0'+(date.getMonth()+1)+'-'+ date.getDate();
    }
    else{
        var today = date.getFullYear()+'-'+'0'+(date.getMonth()+1)+'-'+'0'+ date.getDate();
    }
    var data_val = $('#input_data_medicao').val();

    if(today < data_val)
    {
       $.confirm({
        title: 'Data',
        content:'Data Medição é maior que data atual.',
        type: 'red',
        animation: 'bottom',
        buttons:{
           ok:{
              text: 'Fechar',
              btnClass: 'btn-danger',
              action: function(){
              }
          }
      }
    });
       $('#input_data_medicao').val(today);
    }
    else
    {
     $('#input_data_medicao').val();
    }
});

$("#filter_data_final").focusout(function(e) {
    var data_inicio = $('#filter_data_inicial').val();
    var data_final = $('#filter_data_final').val();
    var dateToday = getDateAtual();


    if(data_inicio == ''){
        $.confirm({
            title: 'Data Término',
            content:'Data Início não selecionada.',
            type: 'red',
            animation: 'bottom',
            buttons:{
                ok:{
                    text: 'Fechar',
                    btnClass: 'btn-danger',
                    action: function(){
                        $('#filter_data_final').val(" ");
                    }
                }
            }
        });  
    }
    
    if(data_inicio > data_final){
        $.confirm({
            title: 'Data Início',
            content:'Data Início não pode ser maior que a data Término.',
            type: 'red',
            animation: 'bottom',
            buttons:{
                ok:{
                    text: 'Fechar',
                    btnClass: 'btn-danger',
                    action: function(){
                        $('#filter_data_inicial').val(" ");
                        $('#filter_data_final').val(" ");
                    }
                }
            }
        });  
    }

    if( data_final > dateToday && data_inicio != ''){
        $.confirm({
            title: 'Data Término',
            content:'Data Término é maior que data atual.',
            type: 'red',
            animation: 'bottom',
            buttons:{
                ok:{
                    text: 'Fechar',
                    btnClass: 'btn-danger',
                    action: function(){
                        $('#filter_data_final').val(dateToday);
                    }
                }
            }
        });  
    }
    else{
        $('#filter_data_final').val();
    }
});

$('#filter_data_inicial').on('change', function(){
    var data_inicio = $('#filter_data_inicial').val();
    var dateToday = getDateAtual();

    if(data_inicio > dateToday){
        $.confirm({
            title: 'Data Início',
            content:'Data Início é maior que data atual.',
            type: 'red',
            animation: 'bottom',
            buttons:{
                ok:{
                    text: 'Fechar',
                    btnClass: 'btn-danger',
                    action: function(){
                        $('#filter_data_inicial').val(dateToday);
                    }
                }
            }
        });  
    }
    else{
        $('#filter_data_inicial').val();
    }
    
});

function getDateAtual(){
    var date = new Date();
    var today;
    if( date.getDate() > 9 && (date.getMonth()+1) >9) {
        today = date.getFullYear()+'-'+(date.getMonth()+1)+'-'+ date.getDate();
    }
    else if((date.getMonth()+1) >9 && (date.getMonth()+1) <=9){
        today = date.getFullYear()+'-'+(date.getMonth()+1)+'-'+ '0'+ date.getDate(); 
    }
    else if (date.getDate() > 9 && (date.getMonth()+1) <= 9){
        today = date.getFullYear()+'-'+'0'+(date.getMonth()+1)+'-'+ date.getDate();
    }
    else{
        today = date.getFullYear()+'-'+'0'+(date.getMonth()+1)+'-'+'0'+ date.getDate();
    }
    return today;   
}

function createFiscal(){
    $.get(urlBase + "sistema/funcionario/create", function(resposta){
        $("#content-modal-funcionario").html(resposta);
        $('#modal-form-funcionario').modal('show');
        $('#cpf').inputmask({'mask': "999.999.999-99", greedy: false, reverse: true, autoUnmask: true});
        $('#fiscal').attr("checked" , "checked");
    });
}

function createStatus(){
    $.get(urlBase + "sistema/tipo-status-medicao/create", function(resposta){
        $("#content-modal-status-medicao").html(resposta);
        $('#modal-form-status-medicao').modal('show')
    });
}

$('#modal-form-status-medicao').on('hidden.bs.modal', function (e) {        
    if(statusNew.length > 0){
        $("#status_medicao_id").append('<option value='+statusNew[0].id+'>'+statusNew[0].nome+'</option>');
        statusNew = [];
    }
});

$('#modal-form-funcionario').on('hidden.bs.modal', function (e) {        
    if(funcionarioNew.length > 0){
       $("#funcionario_fiscal").append('<option value='+funcionarioNew[0].id+'>'+funcionarioNew[0].nome+'</option>');
        funcionarioNew = [];
    }
});

function createApontamento(){
    $.get(urlBase + "sistema/apontamento-medicao/create", function(resposta){
        $("#content-modal-apontamento-medicao").html(resposta);
        $('#modal-form-apontamento-medicao').modal('show');
    });
}

function addApontamento(){
    var descricao = $('#select-apontamento-medicao').find('option:selected').text();
    var id = $('#select-apontamento-medicao').find('option:selected').val();

    if(id == 0){
        $.confirm({
            title: 'Apontamento',
            content:'Apontamento não selecionado',
            type: 'red',
            animation: 'bottom',
            buttons:{
                ok:{
                    text: 'OK',
                    btnClass: 'btn-success',
                    action: function(){
                    }
                }
            }
        });
        return;
    }

    for(i = 0; i < _apontamentos.length; i++) {

        if(_apontamentos[i] == id){
            $.confirm({
                title: 'Apontamento',
                content:'Apontamento já adicionado a lista atual',
                type: 'red',
                animation: 'bottom',
                buttons:{
                    ok:{
                        text: 'OK',
                        btnClass: 'btn-success',
                        action: function(){
                        }
                    }
                }
            });
            return;
        }
    }

    _apontamentos.push(id);

    var tr = '';
    tr = "<tr>";
    tr += "<td class=\"col-md-10\">"+ descricao +"</td>";
    tr += "<td style='width: 45px'><button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"deletarApontamento('"+id+"')\"><i class=\"glyphicon glyphicon-trash\"></i></button></td>";
    tr += "</tr>";
    $("#table-apontamento").append(tr);
    $('#select-apontamento-medicao').val("0").change();
}

function deletarApontamento(id){

    $.confirm({
        title: 'Excluir Apontamento!',
        type: 'red',
        animation: 'bottom',
        content: 'Deseja Realmente o Apontamento?',
        buttons: {
            confirm: {
                text: 'Sim',
                btnClass: 'btn-red',
                action: function(){
                    var linhaTabela = 0;
                    while(_apontamentos[linhaTabela] != id){
                        linhaTabela++;
                    }

                    _apontamentos.splice(linhaTabela, 1);
                    document.getElementById('table-apontamento').deleteRow(linhaTabela + 1);
                    return;
                }
            },

            cancel: {
                text: 'Não',
                action: function(){

                }}
        }
    });
}

$('#modal-form-apontamento-medicao').on('hidden.bs.modal', function (e) {
    $('#alert-modal').remove();
    if(apontamentoMedicaoNew.length > 0){
        $("#select-apontamento-medicao").append('<option value='+apontamentoMedicaoNew[0].id+'>'+apontamentoMedicaoNew[0].nome+'</option>');
        apontamentoMedicaoNew = [];
    }
});

try{
    var row = document.getElementById("table-apontamento").getElementsByTagName("tr");
    for (var i = 1; i < row.length; i++) {
        _apontamentos.push(row[i].id)
    }
} catch(err){

}