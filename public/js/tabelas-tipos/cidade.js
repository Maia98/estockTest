var regionalNew = [];

$("#content-modal-cidade").on("click", "#fechar-cidade", function() {
    $('#modal-form-cidade').modal('toggle');
} );

$("#content-modal-cidade").on("submit", "#form-cidade",function(event){
    event.preventDefault();
    waitingDialog.show('Carregando...');
    //desabilitar quando for enviado a requisicao   
    document.getElementById("salvar-cidade").disabled = true;
    
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: urlBase + "sistema/cidade/store",
        data: $("#form-cidade").serialize(),
        success: function(data){
            if (data.success === true) {
                showAlertModal('success', data.msg, true);
                console.log(data);
                setTimeout(function(){ 
                    $('#modal-form-cidade').modal('toggle');
                    if (typeof cidadeNew !== 'undefined') {
                        cidadeNew.push({id: data.result.id, nome: data.result.nome});
                    }else{
                        location.reload();
                    }
                }, 1000);
               
            }else{
                document.getElementById("salvar-cidade").disabled = false;
                showAlertModal('warning', data.msg, true);
            }
            
            waitingDialog.hide();
        }
    });
});


function inserir(){
	$.get(urlBase + "sistema/cidade/create", function(resposta){
	    if(resposta != 'undefined' && resposta.success === false){
	        showAlert('warning', resposta.msg);
        }else{
            $("#content-modal-cidade").html(resposta);
            $('#modal-form-cidade').modal('show');
        }
	});
}

function editar(id){
	$.get(urlBase + "sistema/cidade/edit/" + id, function(resposta){
        if(resposta != 'undefined' && resposta.success === false){
            showAlert('warning', resposta.msg);
        }else{
            $("#content-modal-cidade").html(resposta);
            $('#modal-form-cidade').modal('show');
        }
	});
}

function deletar(id){
	$.get(urlBase + "sistema/cidade/delete/" + id, function(resposta){
        if(resposta != 'undefined' && resposta.success === false){
            showAlert('warning', resposta.msg);
        }else{
            $("#content-modal-cidade").html(resposta);
            $('#modal-form-cidade').modal('show');
        }
	});
}

function createRegional(){
    $.get(urlBase + "sistema/regional/create", function(resposta){
        $("#content-modal-regional").html(resposta);
        $('#modal-form-regional').modal('show')
    });
}

$('#modal-form-regional').on('hidden.bs.modal', function (e) { 
    $('#alert-modal3').remove();
    if(regionalNew.length > 0){
        $("#regional_id").append('<option value='+regionalNew[0].id+'>'+regionalNew[0].nome+'</option>');
        $("#regional_id").val(regionalNew[0].id);
        regionalNew = [];
    }
});