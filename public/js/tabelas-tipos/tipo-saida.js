$("#content-modal-tipo-saida").on("click", "#fechar", function() {
    $('#modal-form-tipo-saida').modal('toggle');
} );


$("#content-modal-tipo-saida").on("submit", "#form-tipo-saida",function(event){
    event.preventDefault();
    waitingDialog.show('Carregando...');
    //desabilitar quando for enviado a requisicao   
    document.getElementById("salvar-tipo-saida").disabled = true;
    
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: urlBase + "sistema/tipo-saida/store",
        data: $("#form-tipo-saida").serialize(),
        success: function(data){
            if (data.success === true) {                
                showAlertModal('success', data.msg);
                setTimeout(function(){ 
                    $('#modal-form-tipo-saida').modal('toggle');
                    if (typeof tipoSaidaNew !== 'undefined') {
                         tipoSaidaNew.push({id: data.result.id, nome: data.result.nome});
                    }else{
                        location.reload();
                    } 
                }, 1000);   
            }else{
                document.getElementById("salvar-tipo-saida").disabled = false;
                showAlertModal('warning', data.msg);
            }      
            waitingDialog.hide();
        }
    });
});


function inserir(){
    $.get(urlBase + "sistema/tipo-saida/create", function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else{
            $("#content-modal-tipo-saida").html(resposta);
            $('#modal-form-tipo-saida').modal('show')
        }
    });
}

function editar(id){
    $.get(urlBase + "sistema/tipo-saida/edit/" + id, function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else{
            $("#content-modal-tipo-saida").html(resposta);
            $('#modal-form-tipo-saida').modal('show')
        }
    });
}

    function deletar(id){
    $.get(urlBase + "sistema/tipo-saida/delete/" + id, function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else{
            $("#content-modal-tipo-saida").html(resposta);
            $('#modal-form-tipo-saida').modal('show')
        }
    });
}