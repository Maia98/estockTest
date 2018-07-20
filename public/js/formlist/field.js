
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
