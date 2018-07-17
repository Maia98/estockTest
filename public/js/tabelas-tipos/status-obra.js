$("#content-modal-status-obra").on("click", "#fechar-status-obra", function() {
    $('#modal-form-status-obra').modal('toggle');
} );

$("#content-modal-status-obra").on("submit", "#form-status-obra",function(event){
    event.preventDefault();
    waitingDialog.show('Carregando...');
    //desabilitar quando for enviado a requisicao   
    document.getElementById("salvar-status-obra").disabled = true;
    
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: urlBase + "sistema/status-obra/store",
        data: $("#form-status-obra").serialize(),
        success: function(data){
            if (data.success === true) {
                showAlertModal('success', data.msg);
                setTimeout(function(){ 
                    $('#modal-form-status-obra').modal('toggle');
                    if (typeof statusObraNew !== 'undefined') {
                        
                        statusObraNew.push({id: data.result.id, nome: data.result.nome});
                    
                    }else{
                        location.reload();
                    }
                }, 1000);
               
            }else{
                document.getElementById("salvar-status-obra").disabled = false;
                showAlertModal('warning', data.msg);
            }
            
            waitingDialog.hide();
        }
    });
});

function inserir(){
	$.get(urlBase + "sistema/status-obra/create", function(resposta){
        if(resposta != 'undefined' && resposta.success === false){
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-status-obra").html(resposta);
            $('#modal-form-status-obra').modal('show');
        }
	});
}

function editar(id){
	$.get(urlBase + "sistema/status-obra/edit/" + id, function(resposta){
        if(resposta != 'undefined' && resposta.success === false){
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-status-obra").html(resposta);
            $('#modal-form-status-obra').modal('show');
        }
	});
}

function deletar(id){
	$.get(urlBase + "sistema/status-obra/delete/" + id, function(resposta){
        if(resposta != 'undefined' && resposta.success === false){
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-status-obra").html(resposta);
            $('#modal-form-status-obra').modal('show');
        }
	});
}