$(document).ready(function() {
    
    $("#content-modal-permissao").on("click", "#fechar", function() {
        $('#modal-form-permissao').modal('toggle');
    });

    $("#content-modal-permissao").on("submit", "#form-permissoes",function(event){
        event.preventDefault();
        waitingDialog.show('Salvando...');
       
        document.getElementById("salvar").disabled = true;
        
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: urlBase + "sistema/permissoes/store",
            data: $("#form-permissoes").serialize(),
            success: function(data){
                if (data.success === true) {
                    showAlertModal('success', data.msg);
                    setTimeout(function(){ 
                        $('#modal-form-permissao').modal('toggle');
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
}); 

function inserir(){
    $.get(urlBase + "sistema/permissoes/create", function(resposta){
        $("#content-modal-permissao").html(resposta);
        $('#modal-form-permissao').modal('show');        
    });
}

function editar(id){
    $.get(urlBase + "sistema/permissoes/edit/" + id, function(resposta){
        $("#content-modal-permissao").html(resposta);
        $('#modal-form-permissao').modal('show');
    });
}

function deletar(id, descricao){

    $.confirm({
        title: 'Excluir Permissões',
        content: 'Deseja realmente excluir a permissão <strong>' + descricao + '</strong>?',
        buttons: {
            removerEntrevista: {
                btnClass: 'btn-red',
                text: 'Sim',
                action: function () {
                    console.log(_token);
                    $.ajax({
                        type: "POST",
                        url: urlBase + "sistema/permissoes/destroy",
                        data: {_token: _token, id: id},
                        success: function(data){
                            if (data.success == true) {
                                showAlert('success', data.msg);
                                setTimeout(function(){ location.reload(); }, 1000);
                            }else{
                                showAlert('warning', data.msg);
                            }
                            
                            waitingDialog.hide();
                        }, error: function(){
                            showAlert('danger', 'Erro ao excluir.');
                        }
                    });
                }
            },
            cancel: {
                text: 'Não',
                action: function() {return true;}
            }
        }
    });
}