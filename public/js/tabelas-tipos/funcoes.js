$(document).ready(function() {

    $("#content-modal-funcao").on("click", "#fechar", function() {
        $('#modal-form-funcao').modal('toggle');
    });

    $("#content-modal-funcao").on("submit", "#form-funcoes",function(event){
        event.preventDefault();
        waitingDialog.show('Salvando...');
       
        document.getElementById("salvar").disabled = true;
        
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: urlBase + "sistema/funcoes/store",
            data: $("#form-funcoes").serialize(),
            success: function(data){
                if (data.success === true) {
                    showAlertModal('success', data.msg);
                    setTimeout(function(){ 
                        $('#modal-form-funcao').modal('toggle');
                        location.reload();
                    }, 3000);
                }else{
                    document.getElementById("salvar").disabled = false;
                    showAlertModal('warning', data.msg);
                }
                waitingDialog.hide();
            }
        });
    });

    $("#content-modal-funcao").on("click", "#add-permissao", function() 
    {   
        var idPermissao = $("#permissao-option").val(), textPermissao = $("#permissao-option :selected").text(), permissoes = getPermissoes(), adicionar = true; 

        if(idPermissao > 0)
        {
            permissoes.forEach(function(item, index) {
                if(item.permissao == idPermissao && item.deletar == false)
                {
                    showAlertModal('warning', "Permissão já existente na lista.");
                    adicionar = false;
                }
            });

            if(adicionar == true)
            {
                addPermissao(permissoes, 0, idPermissao, textPermissao,  false);
            }

            $("#permissao-option").val(0).change();
        }
        else{
            showAlertModal('warning', "Permissão não selecionada.");
        }
    });

}); 

function inserir(){
    $.get(urlBase + "sistema/funcoes/create", function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else{
            $("#content-modal-funcao").html(resposta);
            $('#modal-form-funcao').modal('show');
        }
    });
}

function editar(id){
    $.get(urlBase + "sistema/funcoes/edit/" + id, function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else{
            $("#content-modal-funcao").html(resposta);
            $('#modal-form-funcao').modal('show');
        }
    });
}

function deletar(id){
    $.get(urlBase + "sistema/funcoes/delete/" + id, function(resposta){
        $("#content-modal-funcao").html(resposta);
        $('#modal-form-funcao').modal('show');
    });
}

function addPermissao(permissoes, id, idPermissao, textPermissao, deletar)
{
    permissoes.push({ id: id, permissao: idPermissao, deletar: deletar });
    setPermissao(permissoes);

    $("#table-body-permissoes").append('<tr><td>'+ textPermissao +'</td><td style="width: 45px;"><button type="button" class="btn btn-danger btn-xs" onclick="deletarPermissao(this, '+idPermissao+');"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></td></tr>');
}


function getPermissoes()
{
    var permissoes = $("#permissoes-values").val();
    if(permissoes)
    {
        return JSON.parse(permissoes);
    }else{
        return [];
    }
}

function setPermissao(permissoes)
{
    $("#permissoes-values").val(JSON.stringify(permissoes));
}

function deletarPermissao(element, idPermissao)
{
    var permissoes = getPermissoes();

    permissoes.forEach(function(item, index, object) {
        if(item.permissao == idPermissao)
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

    setPermissao(permissoes);
}

function loadPermissoes()
{
    var idRole = $("#id-role").val();

    if(idRole > 0)
    {
        waitingDialog.show('Carregando Permissões...');

        $.ajax({
            type: "GET",
            url: urlBase + "sistema/funcoes/get-permissoes/" + idRole,
            data: {},
            success: function(data){
                if(data)
                {
                    data.forEach(function(item, index) {
                        addPermissao(getPermissoes(), item.id, item.permission_id,  item.description, false);
                    });
                }
                
                waitingDialog.hide();
            }, error: function(){
                showAlert('danger', 'Erro ao carregar Permissões.');
            }
        });
    }
}