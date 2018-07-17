// variaveis
var _apoios = new Array();
var _encarregados = new Array();
var funcionarioNew = [];
var tipoApoioNew = [];
var tipoSetorObraNew = [];
var cidadeNew = [];
var tipoPrioridadeNew = [];
var tipoObraNew = [];
var statusObraNew = [];


// Inicio das funções ações gerenciar 

function editar(id){
    
    window.location.href = urlBase + "obra/edit/" + id;
}

function detalhes(id){
    $.get(urlBase + "obra/details/" + id, function(resposta){
        if(resposta != 'undefined' && resposta.success === false){
            showAlert('warning', resposta.msg);
        }else{
            $("#content-modal-obra").html(resposta);
            $('#modal-obra').modal('show');
        }
    });
}

function createHistorico(id){
    $.get(urlBase + "obra/create-historico/" + id, function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else{
            $("#content-modal-historico").html(resposta);
            $('#modal-historico').modal('show');
        }
    });
}

function showHistorico(id){
     window.location.href = urlBase + "obra/show-historico/" + id;
}

function showBalanco(id){
    var saldo = $('#filtro_saldo').find('option:selected').val();
    window.location.href = urlBase + "obra/show-balanco/" + id + "/" + saldo;
}

function voltarObra(){
    window.location.href = urlBase + "obra/gerenciador/";
}

//exporta documentos
function docmuentsExport(id) {
   window.location.href = urlBase + "obra/documents-export/" + id ;
}

function addApoio(){
      var descricao = $('#select_apoio').find('option:selected').text();
      var id = $('#select_apoio').find('option:selected').val();

      if(id == 0){
        $.confirm({
                title: 'Apoio',
                content:'Apoio não selecionado',
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

    for(i = 0; i < _apoios.length; i++) {

        if(_apoios[i] == id){
            $.confirm({
                title: 'Apoio',
                content:'Apoio já adicionado a lista atual',
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

     _apoios.push(id);
                
        var tr = '';
            tr = "<tr>";
            tr += "<td class=\"col-md-10\">"+ descricao +"</td>";
            tr += "<td style='width: 45px'><button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"deletarApoio('"+id+"')\"><i class=\"glyphicon glyphicon-trash\"></i></button></td>";
            tr += "</tr>";
        $("#table_apoio").append(tr);
        $('#select_apoio').val("0").change();
}

// adicionar encarregado
function addEncarregado(){
      var descricao = $('#select_encarregado').find('option:selected').text();
      var id = $('#select_encarregado').find('option:selected').val();

      if(id == 0){
        $.confirm({
                title: 'Encarregado',
                content:'Encarregado não selecionado',
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

    for(i = 0; i < _encarregados.length; i++) {

        if(_encarregados[i] == id){
            $.confirm({
                title: 'Encarregado',
                content:'Encarregado já adicionado a lista atual',
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

     _encarregados.push(id);
                
        var tr = '';
            tr = "<tr>";
            tr += "<td class=\"col-md-10\">"+ descricao +"</td>";
            tr += "<td style='width: 45px'><button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"deletarEncarregado('"+id+"')\"><i class=\"glyphicon glyphicon-trash\"></i></button></td>";
            tr += "</tr>";
        $("#table_encarregado").append(tr);
        $('#select_encarregado').val("0").change();
}

function deletarApoio(id){

    $.confirm({
        title: 'Excluir Apoio!',
        type: 'red',
        animation: 'bottom',
        content: 'Deseja Realmente o Apoio ?',
        buttons: {
            confirm: {
                text: 'Sim',
                btnClass: 'btn-red',
                action: function(){
                    var linhaTabela = 0;
                    while(_apoios[linhaTabela] != id){
                        linhaTabela++;
                        console.log(linhaTabela);
                    }

                    _apoios.splice(linhaTabela,1);
                    document.getElementById('table_apoio').deleteRow(linhaTabela + 1);
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

function deletarEncarregado(id){

    $.confirm({
        title: 'Excluir Encarregado!',
        type: 'red',
        animation: 'bottom',
        content: 'Deseja Realmente o Encarregado ?',
        buttons: {
            confirm: {
                text: 'Sim',
                btnClass: 'btn-red',
                action: function(){
                    var linhaTabela = 0;
                    while(_encarregados[linhaTabela] != id){
                        linhaTabela++;
                        console.log(linhaTabela);
                    }

                    _encarregados.splice(linhaTabela,1);
                    document.getElementById('table_encarregado').deleteRow(linhaTabela + 1);
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

function createTipoObra(){
    
    $.get(urlBase + "sistema/tipo-obra/create", function(resposta){
        $("#content-modal-tipo-obra").html(resposta);
        $('#modal-form-tipo-obra').modal('show')
    });
}

function createSetorObra(){
    
    $.get(urlBase + "sistema/tipo-setor-obra/create", function(resposta){
        $("#content-modal-tipo-setor-obra").html(resposta);
        $('#modal-form-tipo-setor-obra').modal('show');
    });
}

function createStatusObra(){
    $.get(urlBase + "sistema/status-obra/create", function(resposta){
        $("#content-modal-status-obra").html(resposta);
        $('#modal-form-status-obra').modal('show')
    });
}

function createCidade(){
    
    $.get(urlBase + "sistema/cidade/create", function(resposta){
        $("#content-modal-cidade").html(resposta);
        $('#modal-form-cidade').modal('show');
    });
}

function createTipoPrioridade(){
    
    $.get(urlBase + "sistema/tipo-prioridade/create", function(resposta){
        $("#content-modal-tipo-prioridade").html(resposta);
        $('#modal-form-tipo-prioridade').modal('show');
    });
}

function createFuncionario(){
    $.get(urlBase + "sistema/funcionario/create", function(resposta){
        $("#content-modal-funcionario").html(resposta);
        $('#modal-form-funcionario').modal('show');
        $('#cpf').inputmask({'mask': "999.999.999-99", greedy: false, reverse: true, autoUnmask: true});
    });
}

function createApoio(){
    $.get(urlBase + "sistema/tipo-apoio/create", function(resposta){
        $("#content-modal-tipo-apoio").html(resposta);
        $('#modal-form-tipo-apoio').modal('show');
    });
}

function somenteDouble(obj, e) {
    var tecla = (window.event) ? e.keyCode : e.which;    
    if(tecla == 43 || tecla == 45 || tecla == 101 || tecla == 69 ) {
        return false;   
    }
}

$('#valor_orcado').priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.'
        });

$('#modal-form-funcionario').on('hidden.bs.modal', function (e) {        
    $('#alert-modal2').remove();
    if(funcionarioNew.length > 0){

        if(funcionarioNew[0].supervisor == true){
            $("#funcionario_supervisor").append('<option value='+funcionarioNew[0].id+'>'+funcionarioNew[0].nome+' '+funcionarioNew[0].sobrenome +'</option>');
        }

        if(funcionarioNew[0].fiscal == true){
            $("#funcionario_fiscal").append('<option value='+funcionarioNew[0].id+'>'+funcionarioNew[0].nome+' '+funcionarioNew[0].sobrenome +'</option>');
        }

        if(funcionarioNew[0].encarregado == true){
            $("#select_encarregado").append('<option value='+funcionarioNew[0].id+'>'+funcionarioNew[0].nome+' '+funcionarioNew[0].sobrenome +'</option>');
        }
        funcionarioNew = [];
    }
});

// Colocar os valores no select sem atualizar a pagina
$('#modal-form-tipo-apoio').on('hidden.bs.modal', function (e) {        
    $('#alert-modal').remove();
    if(tipoApoioNew.length > 0){
        $("#select_apoio").append('<option value='+tipoApoioNew[0].id+'>'+tipoApoioNew[0].nome+'</option>');
        tipoApoioNew = [];
    }
});

$('#modal-form-tipo-obra').on('hidden.bs.modal', function (e) {        
    $('#alert-modal').remove();
    if(tipoObraNew.length > 0){
        $("#select_tipo_obra").append('<option value='+tipoObraNew[0].id+'>'+tipoObraNew[0].descricao+'</option>');
        tipoObraNew = [];
    }
});

$('#modal-form-tipo-setor-obra').on('hidden.bs.modal', function (e) {        
    $('#alert-modal').remove();
    if(tipoSetorObraNew.length > 0){
        $("#select_setor").append('<option value='+tipoSetorObraNew[0].id+'>'+tipoSetorObraNew[0].nome+'</option>');
        tipoSetorObraNew = [];
    }
});

$('#modal-form-status-obra').on('hidden.bs.modal', function (e) {        
    $('#alert-modal').remove();
    if(statusObraNew.length > 0){
        $("#select_status_obra").append('<option value='+statusObraNew[0].id+'>'+statusObraNew[0].nome+'</option>');
        statusObraNew = [];
    }
});

$('#modal-form-cidade').on('hidden.bs.modal', function (e) {        
    $('#alert-modal2').remove();
    if(cidadeNew.length > 0){
        $("#select_cidade").append('<option value='+cidadeNew[0].id+'>'+cidadeNew[0].nome+'</option>');
        cidadeNew = [];
    }
});

$('#modal-form-tipo-prioridade').on('hidden.bs.modal', function (e) {        
    $('#alert-modal').remove();
    if(tipoPrioridadeNew.length > 0){
        $("#select_prioridade").append('<option value='+tipoPrioridadeNew[0].id+'>'+tipoPrioridadeNew[0].nome+'</option>');
        tipoPrioridadeNew = [];
    }
});

$("#content-modal-historico").on("submit", "#form-historico",function(event){
    event.preventDefault();
    waitingDialog.show('Carregando...'); 
    document.getElementById("salvar-historico").disabled = true;    
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: urlBase + "obra/store-historico",
        data: $("#form-historico").serialize(),
        success: function(data){
            if (data.success === true) {
                showAlertModal('success', data.msg);
                waitingDialog.hide();
                setTimeout(function(){ 
                    $('#modal-historico').modal('toggle');
                }, 1000);
            }else{
                document.getElementById("salvar-historico").disabled = false;
                showAlertModal('warning', data.msg);
                waitingDialog.hide();
            }
        }
    });
});

$('#btn-excel').on('click', function(event){
    $.ajax({
        cache: false,
        type: "GET",
        url: urlBase + "obra/gerenciador/exportar-excel",
        data: $("#form-filter").serialize(),
        success: function(response, request){
            if(response.success){
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

$('#btn-excel-geral').on('click', function(event){
    $.ajax({
        cache: false,
        type: "GET",
        url: urlBase + "obra/gerenciador/exportar-geral-excel",
        data: $("#form-filter").serialize(),
        success: function(response, request){
            if(response.success){
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

$('#btn-pdf').on('click', function(event){
    window.open(urlBase + "obra/gerenciador/exportar-pdf?" + $("#form-filter").serialize());
});
// fim das ações e funções gerenciar


// Inicio das funções cadastrar e ações cadastrar 
$('#input_data_recebimento').inputmask({'mask': "d/m/y", greedy: false, reverse: true});
$('#input_data_abertura').inputmask({'mask': "d/m/y", greedy: false, reverse: true});
$('#input_prazo_execucao_inicio').inputmask({'mask': "d/m/y h:s", greedy: false, reverse: true});
$('#input_prazo_execucao_fim').inputmask({'mask': "d/m/y h:s", greedy: false, reverse: true});
$('#input_previsao_retirada_material').inputmask({'mask': "d/m/y", greedy: false, reverse: true});

// try catch colocado para impedir que os For para tables de encarregados e de apoio apresentem erros 
// quando a tela gerencial por chamada
try{
    var row = document.getElementById("table_encarregado").getElementsByTagName("tr");
    for (var i = 1; i < row.length; i++) {
        _encarregados.push(row[i].id)
    }

    var row = document.getElementById("table_apoio").getElementsByTagName("tr");
    for (var i = 1; i < row.length; i++) {
        _apoios.push(row[i].id)
    }
} catch(err){

}

$("#form-obra").submit(function(event){
    
    event.preventDefault();
    waitingDialog.show('Carregando...');
    //desabilitar quando for enviado a requisicao   
    document.getElementById("salvar-obra").disabled = true;     
    
    var fomData = new FormData(this);
    
    fomData.append('_token', $('#_token').val());
    fomData.append('apoio', _apoios);
    fomData.append('encarregados', _encarregados);

    $.ajax({
        type: "POST",
        //dataType: 'json',
        url: urlBase + "obra/store",
        data: fomData,
        success: function(data){
            if (data.success === true) {
                showAlert('success', data.msg);
                $('html, body').animate({ scrollTop: 10 }, 300);
                setTimeout(function(){ 
                    window.location.href = urlBase + "obra/gerenciador";
                }, 1000);               
            }else{
                document.getElementById("salvar-obra").disabled = false;
                showAlert('warning', data.msg);
                $('html, body').animate({ scrollTop: 10 }, 500);
            }
            waitingDialog.hide();
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

$("#form-filter").on("submit",function(event){
    event.preventDefault();
    var tipo_data = $('#filter_tipo_data').val();
    var filter_data_inicial = $('#filter_data_init').val();
    var filter_data_final = $('#filter_data_final').val();

    if(tipo_data == 0 && filter_data_inicial == '' && filter_data_final == ''){
        document.getElementById("form-filter").submit();
    }else if(tipo_data != 0 && filter_data_inicial != '' && filter_data_final != ''){
        document.getElementById("form-filter").submit();
    }
    else{
        $('#group_datas').addClass('has-warning');
        showAlert('warning','Filtro tipo data é obrigatorio o preechimento das datas.');
    }
    
});

$('#filter_data_final').change(function(){
    var filter_data_inicial = $('#filter_data_init').val();
    var filter_data_final = $('#filter_data_final').val();

    if(filter_data_inicial > filter_data_final ){
        $.confirm({
            title   : 'Data',
            content : 'Informe a data corretamente.',
            type    : 'red',
            buttons :{
                ok  :{
                    text     : 'OK',
                    btnClass : 'btn-danger',
                    action   : function(){}
                }
            }

        });

        $('#filter_data_final').val('');
    }
});

$('#listao-excel').on('click', function(event){

    event.preventDefault();
    var saldoBalanco =  $('#filtro_saldo').val();
    if(saldoBalanco === '0'){
        console.log(saldoBalanco);
        waitingDialog.show('Carregando...');

        $.ajax({
            cache: false,
            contentType: false,
            processData: false,
            type: "GET",
            url: urlBase + "obra/gerenciador/exportar-listao-excel",
            data: $("#form-filter").serialize(),
            success: function(data){
                if(data.success != 'undefined' && data.success == false){
                    showAlert('warning', data.msg);
                }else{
                    var a = document.createElement("a");
                    a.href = this.url;
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                }
            }
        });
        waitingDialog.hide();
    }
});

$("#filter_regional").on("change", function(e) {
    var id_regional = $("#filter_regional").val();
    var _token = '{{csrf_token()}}';

    waitingDialog.show('Carregando...');
    $.ajax({
        type: "GET",
        data: {_token: _token, regional_id: id_regional},
        url: urlBase + "sistema/cidade/get-cidade",
        dataType: 'json',
        success: function(data) {

            var $campo = $("#filter_cidade");
            $campo.empty();
            $campo.append('<option value="0">Selecione</option>');

            $.each(data, function(index, row) {
                $campo.append('<option value='+ row.id +'>'+ row.nome +'</option>');
                document.getElementById("filter_regional").disabled = false;
            });

            waitingDialog.hide();
        }
    });
});

$('#filter_clear').on('click', function(event){
   location.replace(urlBase + 'obra/gerenciador');
});

$('#input_data_abertura, #input_data_recebimento' ).change(function(){
    var input = $(this);
    var verificarData = $(this).unmask();

    if(verificarData.length == 8){
        var dataArray = $(this).val().split('/');
        var dateAgora = new Date(getDateAtual());
        var dataInput = new Date(dataArray[2]+'-'+dataArray[1]+'-'+dataArray[0]); 
    console.log(dataInput.getTime());
    console.log(dateAgora.getTime());
        if(dataInput.getTime() > dateAgora.getTime()){
            $.confirm({
                title: 'Data',
                content:'Data informada é maior que data atual.',
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
    }
});

function getDateAtual(){
    var date = new Date();
    var today;
    var date = new Date();
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

$("input[type=file]").change(function(event){

    waitingDialog.show('Carregando...');
    
    var formData = new FormData(this);
    var _token = $('#_token').val();
    formData.append('_token', _token);
    formData.append('arquivo', event.target.files[0]);
    if(event.target.files[0]){
        $.ajax({
            type: "POST",
            //dataType: 'json',
            url: urlBase + "obra/conferir-material-orcado",
            data: formData,
            success: function(data){
                if (data.success == false) {
                    document.getElementById("arquivo").value = "";
                    //showAlert('warning', data.msg);
                    if(data.modelo == false){
                        $.confirm({
                        title: 'Aviso!',
                        content: data.msg,
                        buttons: {
                            ok: {
                                btnClass: 'btn-success',
                                action: function(){

                                }

                            },
                            somethingElse: {
                                text: 'Download Modelo',
                                btnClass: 'btn-blue',
                                action: function(){
                                    location.href = urlBase + 'modelo_material_orcado.xls';
                                }
                            }
                        }
                        });
                    }
                }
            },
            error: function(data){
                showAlert('danger', 'Ocorreu algum erro.');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
    waitingDialog.hide();
    event.preventDefault();
});

function somenteNumero(obj, e) {
    var tecla = (window.event) ? e.keyCode : e.which;
    if (tecla == 8 || tecla == 0)
        return true;
    if (tecla < 48 || tecla > 57)
        return false;
}

$('#input_prazo_execucao_inicio' ).change(function(){
        var input = $(this);
        var verificarData = $(this).unmask();
        if(verificarData.length < 13){
            $.confirm({
                title: 'Data',
                content:'Data informada é invalida ou incompleta',
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
            return;
        }
});

$('#input_prazo_execucao_fim').change(function(){
    var input = $(this);
    var inputInicio = $("#input_prazo_execucao_inicio");
    console.log(inputInicio);

    if(inputInicio.unmask() == ""){
        $.confirm({
            title: 'Data',
            content:'Informa a data do Início da execução primeiro',
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
        return;
    }

    var verificarData = $(this).unmask();
    if(verificarData.length < 13){
        $.confirm({
            title: 'Data',
            content:'Data informada é invalida ou incompleta',
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
        return;
    }
    var inputFim = $(this).val().replace(' ', '/').replace(':','/').split('/');
    var inputInicio = inputInicio.val().replace(' ', '/').replace(':','/').split('/');

    var dataInicio = new Date(inputInicio[2],inputInicio[1],inputInicio[0],inputInicio[3],inputInicio[4],00);
    var dataFim = new Date(inputFim[2],inputFim[1],inputFim[0],inputFim[3],inputFim[4],00);
    if(dataInicio.getTime() >= dataFim.getTime()){
        $.confirm({
            title: 'Data',
            content:'Data Término não pode ser maior que data Início',
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
        return;

    }
});

$('#filtro_saldo').change(function() {
    var saldoBalanco =  $('#filtro_saldo').val();
    if(saldoBalanco > 0){
        $('#btn-exportar').attr("disabled", "true");
        $('#listao-excel').attr("disabled", "true");
    }else{
        $('#btn-exportar').removeAttr("disabled");
        $('#listao-excel').removeAttr("disabled");
    }
});