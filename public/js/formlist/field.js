
function insert(id){
   
    $.get(urlBase + "sistema/form/createField/"+id, function(resposta){
        
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
            
        }else {
           
            $("#content-modal-field").html(resposta);
            $('#modal-form-field').modal('show');
        }
    });
 
}

function salvar(){
   

        var label = $("#label").val();
        var name = $("#name").val();
        var form_id = $('#form_id').val();
        var type = $('#type').val();
        var required = $('#required').val();
        var private = $('#private').val();
        var id = $('#id').val();
        /*alert(' | '+label+' | '+name+' | '+form_id+' | '+type+' | '+required+' | '+private);
        exit();*/
        $.post(urlBase + 'sistema/form/storeField/', {form_id: form_id, label: label, name: name,
        type: type, required: required, private: private, id:id }, function (resposta) {
        });
    
}
<<<<<<< HEAD

function editarField(id){
  
    //$.get(urlBase +"sistema/form/edit/"+id, function(){});
     $.ajax({
        type: 'GET',
        url: urlBase + "sistema/form/editField/" + id,
        success: function(resposta){
         if (resposta != 'undefined' && resposta.success === false) {
             showAlert('warning', resposta.msg);
         }else {
             $("#content-modal-field").html(resposta);
             $('#modal-form-field').modal('show');
         }
        },
        error: function(){
             return false;
        }
     });
 }

 function deletarField(id){
    $.get(urlBase + "sistema/form/deleteField/" + id, function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-field").html(resposta);
            $('#modal-form-field').modal('show');
        }
    });
}


//CONGIGFIELD
function configField(id){

   
    $.get(urlBase + "sistema/form/createFieldConfig/"+id, function(resposta){
        
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
            
        }else {     
            $("#content-modal-confField").html(resposta);
            $('#modal-form-confField').modal('show');
        }
    });
}

 
=======
>>>>>>> 223099c3207da1a58ef67ead72aee7a7e4c69007
