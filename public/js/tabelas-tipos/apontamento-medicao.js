
$("#content-modal-apontamento-medicao").on("click", "#fechar-apontamento-medicao", function() {
    $('#modal-form-apontamento-medicao').modal('toggle');
} );


$("#content-modal-apontamento-medicao").on("submit", "#form-apontamento-medicao",function(event){
    event.preventDefault();
    waitingDialog.show('Carregando...');
    document.getElementById("salvar-apontamento-medicao").disabled = true;

    $.ajax({
        type: "POST",
        dataType: 'json',
        url: urlBase + "sistema/apontamento-medicao/store",
        data: $("#form-apontamento-medicao").serialize(),
        success: function(data){
            if (data.success === true) {
                showAlertModal('success', data.msg);
                setTimeout(function(){ 
                    $('#modal-form-apontamento-medicao').modal('toggle');

                    if (typeof apontamentoMedicaoNew !== 'undefined') {
                         apontamentoMedicaoNew.push({id: data.result.id, nome: data.result.nome});
                    }else{
                        location.reload();
                    }

                }, 1000);
               
            }else{
                document.getElementById("salvar-apontamento-medicao").disabled = false;
                showAlertModal('warning', data.msg);
            }
            
            waitingDialog.hide();
        }
    });
});	

function inserir(){
	$.get(urlBase + "sistema/apontamento-medicao/create", function(resposta){
        if(resposta != 'undefined' && resposta.success === false){
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-apontamento-medicao").html(resposta);
            $('#modal-form-apontamento-medicao').modal('show');
        }
	});
}

function editar(id){
	$.get(urlBase + "sistema/apontamento-medicao/edit/" + id, function(resposta){
        if(resposta != 'undefined' && resposta.success === false){
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-apontamento-medicao").html(resposta);
            $('#modal-form-apontamento-medicao').modal('show');
        }
	});
}

function deletar(id){
	$.get(urlBase + "sistema/apontamento-medicao/delete/" + id, function(resposta){
        if(resposta != 'undefined' && resposta.success === false){
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-apontamento-medicao").html(resposta);
            $('#modal-form-apontamento-medicao').modal('show');
        }
	});
}