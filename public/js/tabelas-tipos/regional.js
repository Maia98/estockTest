$("#content-modal-regional").on("click", "#fechar", function() {
    $('#modal-form-regional').modal('toggle');
} );

/*$('#fechar').on('click', function(){
	console.log('Click');
    $('#modal-form-fab').modal('toggle');
});*/

$("#content-modal-regional").on("submit", "#form-regional",function(event){
    event.preventDefault();
    waitingDialog.show('Carregando...');
    //desabilitar quando for enviado a requisicao   
    document.getElementById("salvar-funcao-regional").disabled = true;
    
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: urlBase + "sistema/regional/store",
        data: $("#form-regional").serialize(),
        success: function(data){
            if (data.success === true) {
                showAlertModal('success', data.msg, false, true);
                setTimeout(function(){ 
                    $('#modal-form-regional').modal('toggle');
                    if (typeof regionalNew !== 'undefined') {
                        regionalNew.push({id: data.result.id, nome: data.result.descricao});
                    }else{
                        location.reload();
                    }
                }, 1000);
               
            }else{
                document.getElementById("salvar-funcao-regional").disabled = false;
                showAlertModal('warning', data.msg, false, true);
            }
            
            waitingDialog.hide();
        }
    });
});


function inserir(){
	$.get(urlBase + "sistema/regional/create", function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-regional").html(resposta);
            $('#modal-form-regional').modal('show');
        }
	});
}

function editar(id){
	$.get(urlBase + "sistema/regional/edit/" + id, function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-regional").html(resposta);
            $('#modal-form-regional').modal('show');
        }
	});
}

function deletar(id){
	$.get(urlBase +"sistema/regional/delete/" + id, function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-regional").html(resposta);
            $('#modal-form-regional').modal('show');
        }
	});
}
