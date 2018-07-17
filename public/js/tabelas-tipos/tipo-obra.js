$("#content-modal-tipo-obra").on("click", "#fechar-tipo-obra", function() {
    $('#modal-form-tipo-obra').modal('toggle');
} );

/*$('#fechar').on('click', function(){
	console.log('Click');
    $('#modal-form-tipo-obra').modal('toggle');
});*/

$("#content-modal-tipo-obra").on("submit", "#form-tipo-obra",function(event){
    event.preventDefault();
    waitingDialog.show('Carregando...');
    //desabilitar quando for enviado a requisicao   
    document.getElementById("salvar-tipo-obra").disabled = true;
    
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: urlBase + "sistema/tipo-obra/store",
        data: $("#form-tipo-obra").serialize(),
        success: function(data){
            if (data.success === true) {
                showAlertModal('success', data.msg);
                setTimeout(function(){ 
                    $('#modal-form-tipo-obra').modal('toggle');
                    
                    if (typeof tipoObraNew !== 'undefined') {
                        tipoObraNew.push({id: data.result.id, descricao: data.result.descricao});
                    }else{
                        location.reload();
                    }
                }, 1000);
               
            }else{
                document.getElementById("salvar-tipo-obra").disabled = false;
                showAlertModal('warning', data.msg);
            }
            
            waitingDialog.hide();
        }
    });
});


function inserir(){
    $.get(urlBase + "sistema/tipo-obra/create", function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else{
            $("#content-modal-tipo-obra").html(resposta);
            $('#modal-form-tipo-obra').modal('show')
        }
    });
}

function editar(id){
    $.get(urlBase + "sistema/tipo-obra/edit/" + id, function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else{
            $("#content-modal-tipo-obra").html(resposta);
            $('#modal-form-tipo-obra').modal('show')
        }
    });
}

function deletar(id){
    $.get(urlBase + "sistema/tipo-obra/delete/" + id, function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else{
            $("#content-modal-tipo-obra").html(resposta);
            $('#modal-form-tipo-obra').modal('show')
        }
    });
}