$("#content-modal-tipo-prioridade").on("click", "#fechar-tipo-prioridade", function() {
    $('#modal-form-tipo-prioridade').modal('toggle');
} );

/*$('#fechar').on('click', function(){
	console.log('Click');
    $('#modal-form-tipo-prioridade').modal('toggle');
});*/

$("#content-modal-tipo-prioridade").on("submit", "#form-tipo-prioridade",function(event){
    event.preventDefault();
    waitingDialog.show('Carregando...');
    //desabilitar quando for enviado a requisicao   
    document.getElementById("salvar-tipo-prioridade").disabled = true;
    
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: urlBase + "sistema/tipo-prioridade/store",
        data: $("#form-tipo-prioridade").serialize(),
        success: function(data){
            if (data.success === true) {
                showAlertModal('success', data.msg);
                setTimeout(function(){ 
                    $('#modal-form-tipo-prioridade').modal('toggle');
                        if (typeof tipoPrioridadeNew !== 'undefined') {
                            tipoPrioridadeNew.push({id: data.result.id, nome: data.result.nome});
                        }else{
                            location.reload();
                        }  
                }, 1000);
               
            }else{
                document.getElementById("salvar-tipo-prioridade").disabled = false;
                showAlertModal('warning', data.msg);
            }
            
            waitingDialog.hide();
        }
    });
});

function inserir(){
	$.get(urlBase + "sistema/tipo-prioridade/create", function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else{
            $("#content-modal-tipo-prioridade").html(resposta);
            $('#modal-form-tipo-prioridade').modal('show')
        }
	});
}

function editar(id){
	$.get(urlBase + "sistema/tipo-prioridade/edit/" + id, function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else{
            $("#content-modal-tipo-prioridade").html(resposta);
            $('#modal-form-tipo-prioridade').modal('show')
        }
	});
}

function deletar(id){
	$.get(urlBase + "sistema/tipo-prioridade/delete/" + id, function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else{
            $("#content-modal-tipo-prioridade").html(resposta);
            $('#modal-form-tipo-prioridade').modal('show')
        }
	});
}