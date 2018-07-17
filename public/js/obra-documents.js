$(document).ready(function() {

    var array_imgs = [];

    $("#form-store-documents").on("submit",function(event){
       event.preventDefault();
       waitingDialog.show('Carregando...');
       //desabilitar quando for enviado a requisicao
       document.getElementById("salvar-documents-obra").disabled = true;

        var formData = new FormData();
        for(i =0; i < array_imgs.length; i++){
            formData.append('files[]', array_imgs[i]);
        }
        formData.append('id', $("#obra_id").val());

       $.ajax({
           type: "POST",
           //dataType: 'json',
           url: urlBase + "obra/store-documents",
           data: formData,
           cache: false,
           contentType: false,
           processData: false,
           success: function(data){
               if (data.success === true) {
                   showAlertModal('success', data.msg);
                   setTimeout(function(){
                       location.reload();
                   }, 1000);

               }else{
                   document.getElementById("salvar-documents-obra").disabled = false;
                   showAlertModal('warning', data.msg);
               }
               waitingDialog.hide();
           }

       });
   });

    $('body').on('change', '#arquivo',function (event) {
        waitingDialog.show('Carregando...');
        var fileInput  = document.querySelector("#arquivo");
        var files      = fileInput.files;
        var filesCount = files.length;
        var i          = 0;

        while ( i < filesCount){
            var ext = files.item(i).name.substring(files.item(i).name.lastIndexOf('.') + 1).toLowerCase();
            var name = files.item(i).name.substring(0,files.item(i).name.lastIndexOf('.'));
            if(name.length > 10){
                name = name.substring(0,10)+"...";
            }
            previewFile(files.item(i), ext, i, name);
            i++;
        }
        waitingDialog.hide();
        $("#arquivo").val('');
    });

    function previewFile(file, extension, index, name) {
        var reader = new FileReader();
        reader.onloadend = function () {
            if(extension == "jpg" || extension == "jpeg" || extension == "png"){
                array_imgs.push(file);
                $('#upload_files').append("<div class='image-preview' name='"+index+"'><span class='fa fa-times delete-thumb' name='"+index+"'></span><img src='"+reader.result+"' name='"+index+"' /><span class='name-thumb'>"+name+"</span></div>");
            }else if(extension == "docx" || extension == "doc" || extension == "pdf" || extension == "xls" || extension == "xlsx"){
                array_imgs.push(file);
                $('#upload_files').append("<div class='image-preview' name='"+index+"'><span class='fa fa-times delete-thumb' name='"+index+"'></span><center><img src='"+urlBase+"img/"+extension+".png' style='max-width: 74%;'/></center><span class='name-thumb'>"+name+"</span></div>");
            }
        }
        if (file) {
            reader.readAsDataURL(file);
        }
    }

    $('#upload_files').on('click', '.delete-thumb', function () {
        var index = $(this).attr('name');
        array_imgs.pop(index-1);
        $('.preview-thumb .image-preview[name='+(index)+']').fadeOut(200);
    });
});



function documentDownload(id, numObra, path) {
    waitingDialog.show('Carregando...');
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: urlBase + "obra/download-documents",
        data: {id: id, obra: numObra, ext: path},
        success: function(response){
            if (response.success === true) {
                var a = document.createElement("a");
                a.href = response.file;
                a.download = response.name;
                document.body.appendChild(a);
                a.click();
                a.remove();
            }else{
                showAlertModal('warning', response.msg);
            }
            waitingDialog.hide();
        }

    });
}

function documentDelete(id, numObra) {
    $.confirm({
        title: 'Excluir Documento!',
        type: 'red',
        animation: 'bottom',
        content: 'Deseja Realmente o Documento ?',
        buttons: {
            confirm: {
                text: 'Sim',
                btnClass: 'btn-red',
                action: function(){
                    waitingDialog.show('Carregando...');
                    $.ajax({
                        type: "POST",
                        dataType: 'json',
                        url: urlBase + "obra/delete-documents",
                        data: {id: id, obra: numObra},
                        success: function(data){
                            if (data.success === true) {
                                showAlertModal('success', data.msg);
                                setTimeout(function(){
                                    location.reload();
                                }, 1000);
                            }else{
                                showAlertModal('warning', data.msg);
                            }
                            waitingDialog.hide();
                        }

                    });
                }
            },

            cancel: {
                text: 'Não',
                action: function(){

                }}
        }
    });
}