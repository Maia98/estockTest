$(document).ready(function() {
    $("#content-modal").on("click", "#fechar", function() {
        $('#modal-form').modal('toggle');
    });

    $("#content-modal").on("submit", "#form-usuario",function(event){
        event.preventDefault();
        waitingDialog.show('Salvando...');
       
        document.getElementById("salvar").disabled = true;
        
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: urlBase + "usuarios/store",
            data: $("#form-usuario").serialize(),
            success: function(data){
                if (data.success === true) {
                    showAlertModal('success', data.msg);
                    setTimeout(function(){ 
                        $('#modal-form').modal('toggle');
                        location.reload();
                    }, 1000);
                }else{
                    document.getElementById("salvar").disabled = false;
                    showAlertModal('warning', data.msg);
                }
                waitingDialog.hide();
            }, error: function(err){
                console.log(err);
            }
        });
    });

    $("#content-modal").on("click", "#add-funcao", function() 
    {   
        var idFuncao = $("#funcao-option").val(), textFuncao = $("#funcao-option :selected").text(), funcoes = getFuncoes(), adicionar = true; 

        if(idFuncao > 0)
        {
            funcoes.forEach(function(item, index) {
                if(item.funcao == idFuncao && item.deletar == false)
                {
                    showAlertModal('warning', "Função já existente na lista.");
                    adicionar = false;
                }
            });

            if(adicionar == true)
            {
                addFuncao(funcoes, 0, idFuncao, textFuncao, false);
            }

            $("#funcao-option").val(0).change();
        }
        else{
            showAlertModal('warning', "Função não selecionada.");
        }
    });

}); 

function inserir(){
    $.get(urlBase + "usuarios/create", function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else{
            $("#content-modal").html(resposta.result);
            $('#modal-form').modal('show');
        }
    });
}

function editar(id){
    $.get(urlBase + "usuarios/edit/" + id, function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal").html(resposta);
            $('#modal-form').modal('show');
        }
    });
}

function addFuncao(funcoes, id, idFuncao, textFuncao, deletar)
{
    funcoes.push({ id: id, funcao: idFuncao, deletar: deletar });
    setFuncao(funcoes);
    $("#table-body-funcoes").append('<tr><td>'+ textFuncao +'</td><td style="width: 45px;"><button type="button" class="btn btn-danger btn-xs" onclick="deletarFuncao(this, '+idFuncao+');"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></td></tr>');
}

function getFuncoes()
{
    var funcoes = $("#funcoes-values").val();
    if(funcoes)
    {
        return JSON.parse(funcoes);
    }else{
        return [];
    }
}

function setFuncao(funcoes)
{
    $("#funcoes-values").val(JSON.stringify(funcoes));
}

function loadFuncoes()
{
    var idUser = $("#id-user").val();

    if(idUser > 0)
    {
        waitingDialog.show('Carregando funções do usuário...');

        $.ajax({
            type: "GET",
            url: urlBase + "usuarios/get-funcoes/" + idUser,
            data: {},
            success: function(data){
                if(data)
                {
                    console.log(data);
                    data.forEach(function(item, index) {
                        addFuncao(getFuncoes(), item.id, item.role_id,  item.description, false);
                    });
                }
                
                waitingDialog.hide();
            }, error: function(){
                waitingDialog.hide();
                showAlert('danger', 'Erro ao carregar Funções.');
            }
        });
    }
}

function deletarFuncao(element, idFuncao)
{
    var funcoes = getFuncoes();

    funcoes.forEach(function(item, index, object) {
        if(item.funcao == idFuncao)
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

    setFuncao(funcoes);
}

$("#change-pass-form").submit(function(event){
    event.preventDefault();
    waitingDialog.show('Redefinindo Senha...');

    document.getElementById("salvar-change-pass").disabled = true;

    $.ajax({
        type: "POST",
        dataType: 'json',
        url: urlBase + "usuarios/change/password",
        data: $("#change-pass-form").serialize(),
        success: function(data){
            if (data.success === true) {
                showAlert('success', data.msg);
                setTimeout(function(){
                    $('#modal-form').modal('toggle');
                    location.replace(urlBase);
                }, 1000);
            }else{
                document.getElementById("salvar-change-pass").disabled = false;
                showAlert('warning', data.msg);
            }
            waitingDialog.hide();
        }, error: function(err){
            console.log(err);
        }
    });
});