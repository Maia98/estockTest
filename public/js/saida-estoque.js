var materiais = new Array();
var unidadeMedida;
var codigoMaterial;
var tipoMaterialNew = new Array();
var formDataConferido = new FormData();
var funcionarioNew = [];
var almoxarifadoNew = [];
var tipoSaidaNew = [];
var pontoFlutuante;

$(document).ready(function() {
    metodoEntrada();
});

$('select').select2();

$('select').on("select2:close", function (e) { e.target.focus(); });

$('#data_saida').inputmask({'mask': "d/m/y", greedy: false, clearIncomplete: true });

$('#data-execucao').inputmask({'mask': "d/m/y", greedy: false, clearIncomplete: true });

$("#content-modal-conferir-materiais").on("click", "#fechar", function() {
    $('#modal-conferir-materiais').modal('toggle');
});

$('#modal-form-funcionario').on('hidden.bs.modal', function (e) {  
    if(funcionarioNew.length > 0 && funcionarioNew[0].conferente == true){
        $("#conferente").append('<option value='+funcionarioNew[0].id+'>'+funcionarioNew[0].nome+'</option>');
        $('#conferente').val(funcionarioNew[0].id).change();
        funcionarioNew = [];
    }
});

$('#modal-form-almoxarifado').on('hidden.bs.modal', function (e) {  
    if(almoxarifadoNew.length > 0){
        $("#almoxarifados").append('<option value='+almoxarifadoNew[0].id+'>'+almoxarifadoNew[0].nome+'</option>');
        $('#almoxarifados').val(almoxarifadoNew[0].id).change();
        almoxarifadoNew = [];
    }
});

$('#modal-form-tipo-saida').on('hidden.bs.modal', function (e) {  
    if(tipoSaidaNew.length > 0){
        $("#tipo_saida").append('<option value='+tipoSaidaNew[0].id+'>'+tipoSaidaNew[0].nome+'</option>');
        $('#tipo_saida').val(tipoSaidaNew[0].id).change();
        tipoSaidaNew = [];
    }
});

$('#form-saida-estoque #num_obra').focusout(function(){
    var id_almoxarifado = $(this).val();
    if(id_almoxarifado != 0) {
        waitingDialog.show('Carregando...');
        $.post(urlBase + "saida-estoque/almoxarifado/"+id_almoxarifado, function(resposta){
            $('#form-saida-estoque #almoxarifados').html("").append('<option value="0">Selecione</option>');
            waitingDialog.hide();
            $.each( resposta, function(id, nome){
                $('#form-saida-estoque #almoxarifados').append('<option value="'+resposta[id]['id']+'">'+resposta[id]['nome']+'</option>');
            });
        });
    }
});

$("#form-saida-estoque").submit(function(event){

    $('#materiais_tb').val(JSON.stringify(materiais));
	var formData = new FormData(this);
    event.preventDefault();
    waitingDialog.show('Carregando...');

    $.ajax({
        type: "POST",
        //dataType: 'json',
        url: urlBase + "saida-estoque/conferir-saida",
        data: formData,
        success: function(data){
            if (data.success == false) {
                showAlert('warning', data.msg);
                $('html, body').animate({ scrollTop: 10 }, 500);
            }else{
	            $("#content-modal-conferir-materiais").html(data);
	            //Utilizado para quando clicar fora do modal não fechar.
	            $('#modal-conferir-materiais').modal({backdrop: 'static', keyboard: false});
            }
            waitingDialog.hide();
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

$("#content-modal-conferir-materiais").on("submit", "#form-conferir-saida-estoque",function(event){

	event.preventDefault();
    waitingDialog.show('Carregando...');

	$.ajax({
        type: "POST",
        //dataType: 'json',
        url: urlBase + "saida-estoque/store",
        data: {_token: _token.value, saidaEstoqueConferido: saidaEstoqueConferido},
        
        success: function(data){
			if (data.success === true) {
                showAlertModal('success', data.msg);
                setTimeout(function(){ 
                    window.location.pathname = "saida-estoque/gerenciador";
                }, 1000);
               
            }else{
                document.getElementById("salvar-funcao").disabled = false;
                showAlertModal('warning', data.msg);
            }
            waitingDialog.hide();
        }
    });

});

$("#content-modal-conferir-materiais").on("submit", "#form-conferir-saida-estoque-varias-obras",function(event){

    event.preventDefault();
    waitingDialog.show('Carregando...');

    $.ajax({
        type: "POST",
        //dataType: 'json',
        url: urlBase + "saida-estoque/store-varias-obras",
        data: {_token: _token.value, saidaEstoqueConferido: saidaEstoqueConferido},

        success: function(data){
            if (data.success === true) {
                showAlertModal('success', data.msg);
                setTimeout(function(){
                    window.location.pathname = "saida-estoque/gerenciador";
                }, 1000);

            }else{
                document.getElementById("salvar-varias-obras").disabled = false;
                showAlertModal('warning', data.msg);
            }
            waitingDialog.hide();
        }
    });
});

$('#modal-form-tipo-material').on('hidden.bs.modal', function (e) { 

    if(tipoMaterialNew.length > 0){
        if(typeof buttonActive !== 'undefined'){
            buttonActive.prop('onclick', null).off('click')
            buttonActive.removeClass('btn btn-primary btn-flat fa fa-plus active');
            buttonActive.addClass('btn btn-success btn-flat fa fa-check');
            buttonActive = null;
        }else{
            $("#select_materiais").append('<option value='+tipoMaterialNew[0].id+'>'+tipoMaterialNew[0].descricao+'</option>');
            $('#select_materiais').val(tipoMaterialNew[0].id).change();
        }
        tipoMaterialNew = [];
    }
});

$("#select_materiais").change(function() {

	var _token = $('#_token').val();
	var idMaterial = $('#select_materiais').find('option:selected').val();
	$('#quantidade').val("").change();
	if(idMaterial != 0){
		$.ajax({
        type: "POST",
        dataType: 'json',
        url: urlBase + "saida-estoque/obter-unidade-medida",
        data: {_token: _token, idMaterial: idMaterial},
        success: function(data){
            if (data.success == true) {
        		unidadeMedida = data.unidadeMedida;
        		codigoMaterial = data.codigo;
                pontoFlutuante = data.ponto_flutuante;
            }
        }
    });
  	}
});

$('#metodo_entrada').on('change', function(e) {
    metodoEntrada();
});

function addMateriais(){

      var descricao = $('#select_materiais').find('option:selected').text();
      var id = $('#select_materiais').find('option:selected').val();
	  var quantidade = $('#quantidade').val();

      if(id == 0 || quantidade == 0 || quantidade == ''){
        $.confirm({
                title: 'Material',
                content:'Material não selecionado',
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
    for(i = 0; i < materiais.length; i++) {

        if(materiais[i].id == id){
            $.confirm({
                title: 'Material',
                content:'Material já adicionado a lista atual',
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

 	materiais.push({'id':id, 'descricao':descricao, 'quantidade':quantidade, 'unidade_medida':unidadeMedida, 'codigo_material': codigoMaterial});
    var tr = '';
        tr = "<tr>";
        tr += "<td class=\"col-md-3\">"+ descricao +"</td>";
        tr += "<td class=\"col-md-3\">"+ quantidade +"</td>";
        tr += "<td class=\"col-md-3\">"+ unidadeMedida +"</td>";
        tr += "<td style='width: 45px'><button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"deletarMaterial('"+id+"','"+descricao+"')\" style='margin-left: 10%'><i class=\"glyphicon glyphicon-trash\"></i></button></td>";
        tr += "</tr>";
    $("#table_materiais").append(tr);
    $('#select_materiais').val("0").change();
    $('#quantidade').val("").change();
    unidadeMedida = '';
    codigoMaterial = '';
}

function deletarMaterial(id, descricao){

	$.confirm({
	    title: 'Excluir Material!',
	    type: 'red',
	    animation: 'bottom',
	    content: 'Deseja remover o material '+descricao+' ?',
	    buttons: {
        confirm: {
            text: 'Sim',
            btnClass: 'btn-red',
            action: function(){
                var linhaTabela = 0;
                while(materiais[linhaTabela].id != id){
                    linhaTabela++;
                }
                materiais.splice(linhaTabela,1);
                document.getElementById('table_materiais').deleteRow(linhaTabela + 1);
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

function createTipoSaida(){
    $.get(urlBase + "sistema/tipo-saida/create", function(resposta){
        $("#content-modal-tipo-saida").html(resposta);
        $('#modal-form-tipo-saida').modal('show');
    });
}

function createAlmoxarifado(){
    $.get(urlBase + "sistema/almoxarifado/create", function(resposta){
        $("#content-modal-almoxarifado").html(resposta);
        $('#modal-form-almoxarifado').modal('show');
    });
}

function createConferente(){
    $.get(urlBase + "sistema/funcionario/create", function(resposta){
        $("#content-modal-funcionario").html(resposta);
        $('#modal-form-funcionario').modal('show');
        $('#cpf').inputmask({'mask': "999.999.999-99", greedy: false, reverse: true, autoUnmask: true});
    });
}

function somenteNumeros(obj, e) {

    var tecla = (window.event) ? e.keyCode : e.which;

    if (pontoFlutuante) {
        var texto = document.getElementById("quantidade").value
        var indexpon = texto.indexOf(".")

        if (tecla == 8 || tecla == 0)
            return true;
        if (tecla != 46 && tecla < 48 || tecla > 57)
            return false;
        if (tecla == 46) { if (indexpon !== -1) { return false } }

    } else {
        if (tecla == 8 || tecla == 0)
            return true;
        if (tecla < 48 || tecla > 57)
            return false;
    }
}

function createTipoMaterial(elm, codigoMaterial, descricaoMaterial){
    
    $.get(urlBase + "sistema/tipo-material/create", function(resposta){
        $("#content-modal-tipo-material").html(resposta);
        //Utilizado para quando clicar fora do modal não fechar.
        $('#modal-form-tipo-material').modal({backdrop: 'static', keyboard: false});

        $('#constante_material, #valor_material').priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.'
        });

    });

}

$('#btn-pdf').on('click', function(event){
    window.open(urlBase + "saida-estoque/gerenciador/exportar-pdf?" + $("#form").serialize());
});

$('#btn-excel').on('click', function(event){
    $.ajax({
        cache: false,
        type: "GET",
        //dataType: 'json',
        url: urlBase + "saida-estoque/gerenciador/exportar-excel",
        data: $("#form").serialize(),
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

function listaDetalhes(id){
    window.location.replace(urlBase + "saida-estoque/lista?id=" + id);
}

$('#data_saida').focusout(function(){
    var input = $(this);
    var verificarData = $(this).unmask();

    if ($(this).inputmask("isComplete")){
        var dataArray = $(this).val().split('/');
        var dateAgora = new Date(getDateAtual());
        var dataInput = new Date(dataArray[2]+'-'+dataArray[1]+'-'+dataArray[0]);

        if(dataInput.getTime() > dateAgora.getTime()){
            $.confirm({
                title: 'Data',
                content:'Data Saída é maior que data atual.',
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
            input.val("");
        }

    }else{
        $.confirm({
            title: 'Data',
            content:'Data Saída inválida.',
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
        input.val("");
    }



});

$('#data-execucao').focusout(function(){

    // var dataExecucao = $(this).val().split("/").reverse().join("-");
    // var dataSaida = $("#data_saida").val().split("/").reverse().join("-");
    //
    // console.log(dataExecucao);
    // console.log(dataSaida);


    if ($(this).inputmask("isComplete")){
        var dataExecucao = $(this).val().split("/").reverse().join("-");
        var dataSaida = $("#data_saida").val().split("/").reverse().join("-");

        if($("#data_saida").inputmask("isComplete") == false)
        {
            $.confirm({
                title: 'Data de Saída Inválida',
                content:'Para preencher a previsão de execução é necessário a data de saída do estoque.',
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
            $(this).val("");
            return;
        }

        if(dataExecucao < dataSaida)
        {
            $.confirm({
                title: 'Data de Execução Inválida',
                content:'A data de execução deve ser maior ou igual a data de saída do estoque.',
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
            $(this).val("");
            return;
        }
    }




});

function getDateAtual(){
    var date = new Date();
    var data;
    if(date.getDate() < 10 && date.getMonth() < 10){
        data = date.getFullYear()+'-0'+(date.getMonth()+1)+'-0'+date.getDate();
    }else if(date.getDate() < 10 && date.getMonth() > 10){
        data = date.getFullYear()+'-'+(date.getMonth()+1)+'-0'+date.getDate();
    }else if(date.getDate() > 10 && date.getMonth() < 10){
        data = date.getFullYear()+'-0'+(date.getMonth()+1)+'-'+date.getDate();
    }else if(date.getDate() > 10 && date.getMonth() > 10){
        data = date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate();
    }

    return data;
    
}

$('#data_final').on('change',function(){
    var data_inicio  = $('#data_inicio').val();
    var data_final = $('#data_final').val();

    if(data_final < data_inicio){
        $.confirm({
            title   : 'Data',
            content : 'Data término é menor que a data início',
            type    : 'red',
            buttons :{
                ok  :{
                    text     : 'OK',
                    btnClass : 'btn-danger',
                    action   : function(){}
                }
            }

        });

        $('#data_final').val('');
    }
    
});

$('#data_inicio').on('change',function(){
    var data_final = $('#data_final').val();
    var data_inicio  = $('#data_inicio').val();

    if(data_final != ''){

        if(data_inicio > data_final){
            $.confirm({
                title   : 'Data',
                content : 'Data Início é maior que a data término',
                type    : 'red',
                buttons :{
                    ok  :{
                        text     : 'OK',
                        btnClass : 'btn-danger',
                        action   : function(){}
                    }
                }

            });

            $('#data_inicio').val('');
        }

    }
    
});

$('#data_inicio, #data_final' ).change(function(e){
    var target = '#' + e.target.id;

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
    var data_val = $(target).val();

    if(today < data_val)
    {
       $.confirm({
        title: 'Data',
        content:'Data selecionada é maior que a data atual.',
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
       $(target).val(today);
    }
    else
    {
     $(target).val();
    }
});

function metodoEntrada(){
    var fileExcel = $('#opcaoEntradaExcel');
    var metodo_entrda = $('#metodo_entrada').val();

    if (metodo_entrda == 1) {
        fileExcel.css('display', 'none');
        $('#fildset-manual').css('display', 'block')
        $("#almoxarifados").empty();
    } else if(metodo_entrda == 2 || metodo_entrda == 3){
        materiais = new Array();
        $("#form-saida-estoque #table_materiais tbody").empty()
        $("#form-saida-estoque #almoxarifados").html("").append('<option value="0">Selecione uma obra</option>');
        fileExcel.css('display', 'block');
        $('#fildset-manual').css('display', 'none')

    } else {
        fileExcel.css('display', 'none');
        $("#table_materiais tbody").empty()
        $('#fildset-manual').css('display', 'none')
        $("#form-saida-estoque #table_materiais tbody").empty()
        $("#form-saida-estoque #almoxarifados").html("").append('<option value="0">Selecione uma obra</option>');
    }

    if (metodo_entrda == 3){
        $('#num_obra').attr('disabled', 'disabled');
        $('#num_obra').val(0).change();
        getAlmoxarifados();
    } else{
        $('#num_obra').removeAttr('disabled');
    }
}

function getAlmoxarifados(){
    waitingDialog.show('Carregando...');
    $.post(urlBase + "saida-estoque/almoxarifado-all/", function(resposta){
        $('#form-saida-estoque #almoxarifados').html("").append('<option value="0">Selecione</option>');
        waitingDialog.hide();
        $.each( resposta, function(id, nome){
            $('#form-saida-estoque #almoxarifados').append('<option value="'+resposta[id]['id']+'">'+resposta[id]['nome']+'</option>');
        });
    });
};