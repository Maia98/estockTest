$("#content-modal-status-medicao").on("click", "#fechar-status-medicao", function() {
    $('#modal-form-status-medicao').modal('toggle');
});


$("#content-modal-status-medicao").on("submit", "#form-status-medicao",function(event){
    event.preventDefault();
    waitingDialog.show('Carregando...');
    //desabilitar quando for enviado a requisicao   
    document.getElementById("salvar-status-medicao").disabled = true;
    
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: urlBase + "sistema/tipo-status-medicao/store",
        data: $("#form-status-medicao").serialize(),
        success: function(data){
            if (data.success === true) {
                showAlertModal('success', data.msg);
                setTimeout(function(){ 
                    $('#modal-form-status-medicao').modal('toggle');
                    
                    if (typeof statusNew !== 'undefined') {
                        statusNew.push({id: data.result.id, nome: data.result.nome});
                    }else{
                        location.reload();
                    }
                }, 1000);
               
            }else{
                document.getElementById("salvar-status-medicao").disabled = false;
                showAlertModal('warning', data.msg);
            }
            
            waitingDialog.hide();
        }
    });
});

function inserir(){
		$.get(urlBase + "sistema/tipo-status-medicao/create", function(resposta){
            if (resposta != 'undefined' && resposta.success === false) {
                showAlert('warning', resposta.msg);
            }else{
                $("#content-modal-status-medicao").html(resposta);
                $('#modal-form-status-medicao').modal('show')
            }
		});
	}

function editar(id){
		$.get(urlBase + "sistema/tipo-status-medicao/edit/" + id, function(resposta){
            if (resposta != 'undefined' && resposta.success === false) {
                showAlert('warning', resposta.msg);
            }else{
                $("#content-modal-status-medicao").html(resposta);
                $('#modal-form-status-medicao').modal('show')
            }
		});
	}

	function deletar(id){
		$.get(urlBase + "sistema/tipo-status-medicao/delete/" + id, function(resposta){
            if (resposta != 'undefined' && resposta.success === false) {
                showAlert('warning', resposta.msg);
            }else{
                $("#content-modal-status-medicao").html(resposta);
                $('#modal-form-status-medicao').modal('show')
            }
		});
	}