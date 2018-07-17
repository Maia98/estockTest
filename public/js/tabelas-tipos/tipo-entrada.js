$("#content-modal-tipo-entrada").on("click", "#fechar-tipo-entrada", function() {
    $('#modal-form-tipo-entrada').modal('toggle');
} );


$("#content-modal-tipo-entrada").on("submit", "#form-tipo-entrada",function(event){
    event.preventDefault();
    waitingDialog.show('Carregando...');
    //desabilitar quando for enviado a requisicao   
    document.getElementById("salvar-tipo-entrada").disabled = true;
    
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: urlBase + "sistema/tipo-entrada/store",
        data: $("#form-tipo-entrada").serialize(),
        success: function(data){
            if (data.success === true) {                
                showAlertModal('success', data.msg);
                setTimeout(function(){ 
                    $('#modal-form-tipo-entrada').modal('toggle');
                    if (typeof tipoEntradaNew !== 'undefined') {
                         tipoEntradaNew.push({id: data.result.id, nome: data.result.nome});
                    }else{
                        location.reload();
                    } 
                }, 1000);   
            }else{
                document.getElementById("salvar-tipo-entrada").disabled = false;
                showAlertModal('warning', data.msg);
            }      
            waitingDialog.hide();
        }
    });
});

function inserir(){
    $.get(urlBase + "sistema/tipo-entrada/create", function(resposta){
        if(resposta != 'undefined' && resposta.success === false){
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-tipo-entrada").html(resposta);
            $('#modal-form-tipo-entrada').modal('show');
        }
    });
}

function editar(id){
    $.get(urlBase + "sistema/tipo-entrada/edit/" + id, function(resposta){
        if(resposta != 'undefined' && resposta.success === false){
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-tipo-entrada").html(resposta);
            $('#modal-form-tipo-entrada').modal('show');
        }
    });
}

function deletar(id){
    $.get(urlBase + "sistema/tipo-entrada/delete/" + id, function(resposta){
        if(resposta != 'undefined' && resposta.success === false){
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-tipo-entrada").html(resposta);
            $('#modal-form-tipo-entrada').modal('show');
        }
    });
}