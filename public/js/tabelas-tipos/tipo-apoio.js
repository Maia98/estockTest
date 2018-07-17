
$("#content-modal-tipo-apoio").on("click", "#fechar-tipo-apoio", function() {
    $('#modal-form-tipo-apoio').modal('toggle');
} );

/*$('#fechar').on('click', function(){
	console.log('Click');
    $('#modal-form-fab').modal('toggle');
});*/

$("#content-modal-tipo-apoio").on("submit", "#form-tipo-apoio",function(event){
    event.preventDefault();
    waitingDialog.show('Carregando...');
    //desabilitar quando for enviado a requisicao   
    document.getElementById("salvar-funcao").disabled = true;
    console.log('xxx');
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: urlBase + "sistema/tipo-apoio/store",
        data: $("#form-tipo-apoio").serialize(),
        success: function(data){
            if (data.success === true) {
                showAlertModal('success', data.msg);
                setTimeout(function(){ 
                    $('#modal-form-tipo-apoio').modal('toggle');
                     if (typeof tipoApoioNew !== 'undefined') {
                         tipoApoioNew.push({id: data.result.id, nome: data.result.nome});
                    }else{
                        location.reload();
                    }  
                }, 1000);
               
            }else{
                document.getElementById("salvar-funcao").disabled = false;
                showAlertModal('warning', data.msg);
            }
            
            waitingDialog.hide();
        }
    });
});	

function inserir(){
	$.get(urlBase + "sistema/tipo-apoio/create", function(resposta){
        if(resposta != 'undefined' && resposta.success === false){
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-tipo-apoio").html(resposta);
            $('#modal-form-tipo-apoio').modal('show');
        }
	});
}

function editar(id){
	$.get(urlBase + "sistema/tipo-apoio/edit/" + id, function(resposta){
        if(resposta != 'undefined' && resposta.success === false){
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-tipo-apoio").html(resposta);
            $('#modal-form-tipo-apoio').modal('show');
        }
	});
}

function deletar(id){
	$.get(urlBase + "sistema/tipo-apoio/delete/" + id, function(resposta){
        if(resposta != 'undefined' && resposta.success === false){
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-tipo-apoio").html(resposta);
            $('#modal-form-tipo-apoio').modal('show');
        }
	});
}