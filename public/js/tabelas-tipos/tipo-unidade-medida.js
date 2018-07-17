$(document).ready(function() {

	$("#content-modal-tipo-unidade-medida").on("click", "#fechar-tipo-unidade-medida", function() {
        $('#modal-form-tipo-unidade-medida').modal('toggle');
	} );


	$("#content-modal-tipo-unidade-medida").on("submit", "#form-tipo-unidade-medida",function(event){
        event.preventDefault();
        waitingDialog.show('Carregando...');
        //desabilitar quando for enviado a requisição   
        document.getElementById("salvar-tipo-unidade-medida").disabled = true;
        
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: urlBase + "sistema/tipo-unidade-medida/store",
            data: $("#form-tipo-unidade-medida").serialize(),
            success: function(data){
                if (data.success === true) {
                    showAlertModal('success', data.msg, true);
                    setTimeout(function(){ 
                        $('#modal-form-tipo-unidade-medida').modal('toggle');
                        if (typeof unidadeNew !== 'undefined'){
                            unidadeNew.push({id: data.result.id, codigo: data.result.codigo});
                        }else{
                            location.reload();
                        }
                    }, 1000);
                   
                }else{
                    document.getElementById("salvar-tipo-unidade-medida").disabled = false;
                    showAlertModal('warning', data.msg, true);
                }
                
                waitingDialog.hide();
            }
        });
    });
});	


function inserir(){
	$.get(urlBase + "sistema/tipo-unidade-medida/create", function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else{
            $("#content-modal-tipo-unidade-medida").html(resposta);
            $('#modal-form-tipo-unidade-medida').modal('show')
        }
	});
}

function editar(id){
	$.get(urlBase + "sistema/tipo-unidade-medida/edit/" + id, function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else{
            $("#content-modal-tipo-unidade-medida").html(resposta);
            $('#modal-form-tipo-unidade-medida').modal('show')
        }
	});
}

function deletar(id){
	$.get(urlBase + "sistema/tipo-unidade-medida/delete/" + id, function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else{
            $("#content-modal-tipo-unidade-medida").html(resposta);
            $('#modal-form-tipo-unidade-medida').modal('show')
        }
	});
}