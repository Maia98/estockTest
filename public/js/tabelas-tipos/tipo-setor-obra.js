$("#content-modal-tipo-setor-obra").on("click", "#fechar-tipo-setor-obra", function() {
    $('#modal-form-tipo-setor-obra').modal('toggle');
} );

/*$('#fechar').on('click', function(){
	console.log('Click');
    $('#modal-form-tipo-setor-obra').modal('toggle');
});*/

$("#content-modal-tipo-setor-obra").on("submit", "#form-tipo-setor-obra",function(event){
    event.preventDefault();
    waitingDialog.show('Carregando...');
    //desabilitar quando for enviado a requisicao   
    document.getElementById("salvar-funcao-tipo-setor-obra").disabled = true;
    
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: urlBase + "sistema/tipo-setor-obra/store",
        data: $("#form-tipo-setor-obra").serialize(),
        success: function(data){
            if (data.success === true) {
                showAlertModal('success', data.msg);
                setTimeout(function(){ 
                    $('#modal-form-tipo-setor-obra').modal('toggle');
                     if (typeof tipoSetorObraNew !== 'undefined') {
                        tipoSetorObraNew.push({id: data.result.id, nome: data.result.descricao});
                    }else{
                        location.reload();
                    }  
                }, 1000);
               
            }else{
                document.getElementById("salvar-funcao-tipo-setor-obra").disabled = false;
                showAlertModal('warning', data.msg);
            }
            
            waitingDialog.hide();
        }
    });
});


function inserir(){
	$.get(urlBase + "sistema/tipo-setor-obra/create", function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else{
            $("#content-modal-tipo-setor-obra").html(resposta);
            $('#modal-form-tipo-setor-obra').modal('show')
        }
	});
}

function editar(id){
	$.get(urlBase + "sistema/tipo-setor-obra/edit/" + id, function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else{
            $("#content-modal-tipo-setor-obra").html(resposta);
            $('#modal-form-tipo-setor-obra').modal('show')
        }
	});
}

function deletar(id){
	$.get(urlBase + "sistema/tipo-setor-obra/delete/" + id, function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else{
            $("#content-modal-tipo-setor-obra").html(resposta);
            $('#modal-form-tipo-setor-obra').modal('show')
        }
	});
}