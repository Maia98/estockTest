function inserir(){

    $.get(urlBase + "sistema/form/create", function(resposta){
        
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-form").html(resposta);
            $('#modal-form-form').modal('show');
        }
    });
}

function editar(id){
  
   
   //$.get(urlBase +"sistema/form/edit/"+id, function(){});
    $.ajax({
       type: 'GET',
       url: urlBase + "sistema/form/edit/" + id,
       success: function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-form").html(resposta);
            $('#modal-form-form').modal('show');
        }
       },
       error: function(){
            return false;
       }
    });
}

function deletar(id){
    $.get(urlBase + "sistema/form/delete/" + id, function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-form").html(resposta);
            $('#modal-form-form').modal('show');
        }
    });
}


