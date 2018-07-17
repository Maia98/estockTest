$('#btn-pdf').on('click', function(event){
    window.open(urlBase + "saida-estoque/lista/exportar-pdf?" + $("#form").serialize());
});

$('#btn-excel').on('click', function(event){
    // event.preventDefault();
    // // waitingDialog.show('Carregando...');
    $.ajax({
        cache: false,
        type: "GET",
        //dataType: 'json',
        url: urlBase + "saida-estoque/lista/exportar-excel",
        data: $("#form").serialize(),
        success: function(response, request){
            if(response.success === true) {
                var a = document.createElement("a");
                a.href = response.file;
                a.download = response.name;
                document.body.appendChild(a);
                a.click();
                a.remove();
            }else{
                showAlert('warning', response.msg);
            }
        }
    });
});

function addObs(id)
{
    $.get(urlBase + "saida-estoque/add-obs/" + id, function(resposta){
        $("#content-modal-obs").html(resposta);
        $('#modal-form-obs').modal('show');
    });
}