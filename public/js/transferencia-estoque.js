$('select').select2();

$('#data_transferencia').inputmask({
    'mask': "d/m/y",
    greedy: false,
    reverse: true
});

$('#data_transferencia').focusout(function(){
    var input = $(this);
    var verificarData = $(this).unmask();

    if(verificarData.length == 8){
        var dataArray = $(this).val().split('/');
        var dateAgora = new Date(getDateAtual());
        var dataInput = new Date(dataArray[2]+'-'+dataArray[1]+'-'+dataArray[0]); 

        if(dataInput.getTime() > dateAgora.getTime()){
            $.confirm({
                title: 'Data',
                content:'Data Transferência é maior que data atual.',
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
            content:'Data Transferência inválida.',
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

$("#almoxarifado-origem").change(function () {
    var almoxarifadoOrigem = $('#almoxarifado-origem').find('option:selected').val();
    $("#obra-origem").empty();

    if (almoxarifadoOrigem != 0) {
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: urlBase + "transferencia-estoque/obras-origem",
            data: {
                almoxarifado: almoxarifadoOrigem
            },
            success: function (data) {
                if (data && data.length > 0) {
                    $("#obra-origem").append($('<option>', {
                        value: 0,
                        text: 'Selecione'
                    }));
                    data.forEach(function (element) {
                        $("#obra-origem").append($('<option>', {
                            value: element.id,
                            text: element.numero_obra
                        }));
                    });
                } else {
                    $.confirm({
                        title: 'Opss!',
                        content: 'Não há nenhuma obra com materiais nesse almoxarifado.',
                        type: 'red',
                        typeAnimated: true,
                        buttons: {
                            close: {
                                text: 'Ok',
                                btnClass: 'btn-red',
                                action: function () {}
                            }
                        }
                    });
                }
            },
            error: function(err) {
                $.confirm({
                    title: 'Erro!',
                    content: 'Erro ao obter obras.',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        close: {
                            text: 'Ok',
                            btnClass: 'btn-red',
                            action: function () {
                                console.log(err);
                            }
                        }
                    }
                });
            }
        });
    }
});

$("#obra-origem").change(function () {
    var almoxarifadoDestino = $("#almoxarifado-destino").val();

    if(almoxarifadoDestino > 0)
    {
        $("#almoxarifado-destino").trigger("change");
    }

});

$("#almoxarifado-destino").change(function () {
    var almoxarifadoOrigem = $('#almoxarifado-origem').find('option:selected').val();
    var obraOrigem = $('#obra-origem').find('option:selected').val();
    var almoxarifadoDestino = $('#almoxarifado-destino').find('option:selected').val();
    $("#obra-destino").empty();

    if (almoxarifadoOrigem < 1 && almoxarifadoDestino > 0) {
        $.confirm({
            title: 'Opss!',
            content: 'Por favor, selecione o almoxarifado de Origem.',
            type: 'red',
            typeAnimated: true,
            buttons: {
                close: {
                    text: 'Ok',
                    btnClass: 'btn-red',
                    action: function () {
                        $('#almoxarifado-destino').val(0).change();
                    }
                }
            }
        });

        return false;
    }

    if (almoxarifadoDestino != 0) {
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: urlBase + "transferencia-estoque/obras-destino",
            data: {
                obraOrigem: obraOrigem
            },
            success: function (data) {
                if (data && data.length > 0) {
                    $("#obra-destino").append($('<option>', {
                        value: 0,
                        text: 'Selecione'
                    }));
                    data.forEach(function (element) {
                        console.log(element);
                        $("#obra-destino").append($('<option>', {
                            value: element.id,
                            text: element.numero_obra
                        }));
                    });
                } else {
                    $.confirm({
                        title: 'Opss!',
                        content: 'Não há nenhuma obra disponivel para transferir os materiais.',
                        type: 'red',
                        typeAnimated: true,
                        buttons: {
                            close: {
                                text: 'Ok',
                                btnClass: 'btn-red',
                                action: function () {}
                            }
                        }
                    });
                }
            },
            error: function(err) {
                $.confirm({
                    title: 'Erro!',
                    content: 'Erro ao obter obras.',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        close: {
                            text: 'Ok',
                            btnClass: 'btn-red',
                            action: function () {
                                console.log(err);
                            }
                        }
                    }
                });
            }
        });
    }
});

$("#select-materiais").select2({
    language: 'pt-BR',
    ajax: {
        url: urlBase + "transferencia-estoque/pesquisar-material",
        dataType: 'json',
        delay: 400,
        data: function (params) {
            var almoxarifadoOrigem = $("#almoxarifado-origem").val();
            var obraOrigem = $("#obra-origem").val();
            var obraDestino = $("#obra-destino").val();

            return {
                q: params.term,
                alx: almoxarifadoOrigem,
                obr_o: obraOrigem,
                obr_d: obraDestino,
                page: params.page
            };
        },
        processResults: function (data, params) {
            params.page = params.page || 1;

            return {
                results: data.data,
                pagination: {
                    more: data.current_page < data.last_page
                }
            };
        },
        cache: true
    },
    escapeMarkup: function (markup) { return markup; }, 
    minimumInputLength: 2,
    templateResult: formatRepo,
    templateSelection: formatRepoSelection
});


$("#form-transferencia-material-estoque").submit(function(event){
    event.preventDefault();
    console.log($(this).serialize());
    
    waitingDialog.show('Carregando...');
    
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: this.action,
        data: $(this).serialize(),
        success: function(data) {
            if (data.success === true) {
                console.log(data);
                showAlert('success', data.msg);
                setTimeout(function(){ 
                    window.location = urlBase + 'transferencia-estoque/gerenciador';
                }, 1000);
            }else{
                showAlert('warning', data.msg);
            }
            waitingDialog.hide();
        }, error: function(err){
            waitingDialog.hide();
            showAlert('warning', 'Erro ao salvar transferencia: ' + err.statusText);
        }
    });
});


function formatRepo(repo) {
    if (repo.loading) return repo.text;

    var markup = "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__meta'>" +
        "<div class='select2-result-repository__title'>" +
            repo.text +
        "</div>" +
        "<div class='select2-result-repository__description'>Código: "+ repo.codigo +"  |  Estoque Atual: " + repo.qtde + " " + repo.unid_medida + "</div>" +
        "</div>" +
        "</div>";

    return markup;
}

function formatRepoSelection(repo) {
    return repo.text;
}

$("#add-material").click(function () {
    var codigoMaterial = $("#select-materiais").val(),
        qtde = $("#quantidade").val(),
        materiais = getMateriais(),
        adicionar = true;

    if(codigoMaterial == 0 || qtde == 0 || qtde == ''){
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

        if(materiais[i].material_id == codigoMaterial){
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

    if (codigoMaterial > 0 && qtde > 0) {
        materiais.forEach(function (item, index) {
            if (item.material_id == codigoMaterial && item.deletar == false) {
                adicionar = false;
            }
        });

        if (adicionar == true) {
            addMaterial(materiais, 0, codigoMaterial, qtde, false);
        }
    }
});

function addMaterial(materiais, id, codigoMaterial, qtde, deletar) {
    var almoxarifadoOrigem = $("#almoxarifado-origem").val();
    var obraOrigem = $("#obra-origem").val();
    var obradestino = $("#obra-destino").val();

    $.ajax({
        type: "POST",
        dataType: 'json',
        url: urlBase + "transferencia-estoque/selecionar-material",
        data: {
            alx: almoxarifadoOrigem,
            obr_o: obraOrigem,
            obr_d: obradestino,
            mat: codigoMaterial,
            qtd: qtde
        },
        success: function (data) {
            if (data && data.success == true) {
                console.log(data.itens);
                
                data.itens.forEach(function(element) {

                    materiais.push({
                        material_id: element.material_id,
                        obra_id: element.obra_id,
                        qtde: element.qtde,
                        deletar: deletar
                    });

                    setMateriais(materiais);

                    $("#table-body-materiais").append('<tr>' +
                                                        '<td>' + element.numero_obra + '</td>' +
                                                        '<td>' + element.material_descricao + '</td>' +
                                                        '<td>' + element.qtde + '</td>' +
                                                        '<td>' + element.unidade_medida + '</td>' +
                                                        '<td>' + 
                                                            '<button type="button" class="btn btn-danger btn-xs" onclick="deletarMaterial(this, ' + element.material_id + ', '+ element.obra_id +');">' +
                                                                '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>'+ 
                                                            '</button>' + 
                                                        '</td>' +
                                                    '</tr>');

                    $('#select-materiais').val(null).trigger("change");
                    $('#quantidade').val(null);

                    console.log('Material Adicionado');
                });



            } else {
                $.confirm({
                    title: 'Opss!',
                    content: 'Não há quantidade suficiente desse material.',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        close: {
                            text: 'Ok',
                            btnClass: 'btn-red',
                            action: function () {}
                        }
                    }
                });
            }
        },
        error: function(err) {
            $.confirm({
                title: 'Erro!',
                content: 'Erro ao obter material.',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    close: {
                        text: 'Ok',
                        btnClass: 'btn-red',
                        action: function () {
                            console.log(err);
                        }
                    }
                }
            });
        }
    });
}

function getMateriais()
{
    var materiais = $("#materiais-values").val();
    if(materiais)
    {
        return JSON.parse(materiais);
    }else{
        return [];
    }
}

function setMateriais(materiais)
{
    console.log(materiais);
    $("#materiais-values").val(JSON.stringify(materiais));
}

function deletarMaterial(element, codigoMaterial, codigoObra)
{
    var materiais = getMateriais();

    materiais.forEach(function(item, index, object) {
        if(item.material_id == codigoMaterial && item.obra_id == codigoObra)
        {
            if(item.id > 0)
            {
                item.deletar = true;
            }else{
                object.splice(index, 1);
            }
            
            $(element).closest("tr").remove();
        }
    });

    setMateriais(materiais);
}

function listaDetalhes(id){
    window.location.replace(urlBase + "transferencia-estoque/detalhes/" + id);
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

$('#filter_obra_origem, #filter_obra_destino' ).change(function(e){
    var origem = $('#filter_obra_origem').val();
    var destino = $('#filter_obra_destino').val();

    if(origem > 0 && destino > 0){
        if(origem == destino){
            showAlert('warning','Obra origem e Obra destino não podem ser iguais');
            $(this).val(0).change();
        }
    }

});

$('#btn-pdf').on('click', function(event){
    window.open(urlBase + "transferencia-estoque/gerenciador/exportar-pdf?" + $("#form").serialize());
});

$('#btn-excel').on('click', function(event){
    $.ajax({
        cache: false,
        type: "GET",
        //dataType: 'json',
        url: urlBase + "transferencia-estoque/gerenciador/exportar-excel",
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


$('#filter_clear').on('click', function(event){
    location.replace(urlBase + 'transferencia-estoque/gerenciador');
});