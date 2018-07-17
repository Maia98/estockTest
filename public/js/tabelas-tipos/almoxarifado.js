 var cidadeNew = [];

 $("#content-modal-almoxarifado").on("click", "#fechar-almoxarifado", function() {
    $('#modal-form-almoxarifado').modal('toggle');
} );

/*$('#fechar').on('click', function(){
	console.log('Click');
    $('#modal-form-almoxarifado').modal('toggle');
});*/

$("#content-modal-almoxarifado").on("submit", "#form-almoxarifado",function(event){
    event.preventDefault();
    waitingDialog.show('Carregando...');
    //desabilitar quando for enviado a requisicao   
    document.getElementById("salvar-almoxarifado").disabled = true;
    
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: urlBase + "sistema/almoxarifado/store",
        data: $("#form-almoxarifado").serialize(),
        success: function(data){
            if (data.success === true) {
                console.log(data);
                showAlertModal('success', data.msg);
                setTimeout(function(){ 
                    $('#modal-form-almoxarifado').modal('toggle');
                    if (typeof almoxarifadoNew !== 'undefined') {
                        console.log(data.result);
                        almoxarifadoNew.push({id: data.result.id, nome: data.result.nome});
                    }else{
                        location.reload();
                    }  
                }, 1000);
            }else{
                document.getElementById("salvar-almoxarifado").disabled = false;
                showAlertModal('warning', data.msg);
            }
            waitingDialog.hide();
        }
    });
});

function inserir(){
	$.get(urlBase + "sistema/almoxarifado/create", function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-almoxarifado").html(resposta);
            $('#modal-form-almoxarifado').modal('show');
        }
	});
}

function editar(id){
	$.get(urlBase + "sistema/almoxarifado/edit/" + id, function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-almoxarifado").html(resposta);
            $('#modal-form-almoxarifado').modal('show');
        }
	});
}

function deletar(id){
	$.get(urlBase + "sistema/almoxarifado/delete/" + id, function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-almoxarifado").html(resposta);
            $('#modal-form-almoxarifado').modal('show');
        }
	});
}

function createCidade(){
    $.get(urlBase + "sistema/cidade/create", function(resposta){
        $("#content-modal-cidade").html(resposta);
        $('#modal-form-cidade').modal('show')
    });
}

$('#modal-form-cidade').on('hidden.bs.modal', function (e) { 
    
    if(cidadeNew.length > 0){
        $("#cidades").append('<option value='+cidadeNew[0].id+'>'+cidadeNew[0].nome+'</option>');
        $("#cidades").val(cidadeNew[0].id);
        cidadeNew = [];
    }
});