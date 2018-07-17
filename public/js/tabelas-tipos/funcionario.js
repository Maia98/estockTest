$("#content-modal-funcionario").on("click", "#fechar-funcionario", function() {
    $('#modal-form-funcionario').modal('toggle');
} );

/*$('#fechar').on('click', function(){
	console.log('Click');
    $('#modal-form-funcionario').modal('toggle');
});*/

$("#content-modal-funcionario").on("submit", "#form-funcionario",function(event){
    event.preventDefault();
    waitingDialog.show('Carregando...');
    //desabilitar quando for enviado a requisicao   
    document.getElementById("salvar-funcao-funcionario").disabled = true;
    
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: urlBase + "sistema/funcionario/store",
        data: $("#form-funcionario").serialize(),
        success: function(data){
            if (data.success === true) {
                console.log(data);
                showAlertModal('success', data.msg,true);
                setTimeout(function(){ 
                    $('#modal-form-funcionario').modal('toggle');
                    if (typeof funcionarioNew !== 'undefined') {
                        funcionarioNew.push({id: data.result.id, nome: data.result.nome, sobrenome: data.result.sobrenome,supervisor: data.result.supervisor, fiscal: data.result.fiscal, encarregado: data.result.encarregado, conferente: data.result.conferente});
                    }else{
                        location.reload();
                    }  
                }, 1000);
            }else{
                document.getElementById("salvar-funcao-funcionario").disabled = false;
                showAlertModal('warning', data.msg,true);
            }
            waitingDialog.hide();
        }
    });
});

function inserir(){
    $.get(urlBase + "sistema/funcionario/create", function(resposta){
        if(resposta != 'undefined' && resposta.success === false){
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-funcionario").html(resposta);
            $('#modal-form-funcionario').modal('show');
            $('#cpf').inputmask({'mask': "999.999.999-99", greedy: false, reverse: true, autoUnmask: true});
        }
	});
}

function editar(id){
	$.get(urlBase + "sistema/funcionario/edit/" + id, function(resposta){
        if(resposta != 'undefined' && resposta.success === false){
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-funcionario").html(resposta);
            $('#modal-form-funcionario').modal('show');
            $('#cpf').inputmask({'mask': "999.999.999-99", greedy: false, reverse: true, autoUnmask: true});
        }
	});
}

function deletar(id){
	$.get(urlBase + "sistema/funcionario/delete/" + id, function(resposta){
        if(resposta != 'undefined' && resposta.success === false){
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-funcionario").html(resposta);
            $('#modal-form-funcionario').modal('show');
        }
	});
}

/*function cpf(valor){
    return valor.inputmask({'mask': "###.###.###-##", greedy: false, reverse: true, autoUnmask: true});
}*/