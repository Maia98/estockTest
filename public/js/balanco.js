$('#btn-pdf').on('click', function(event){
    var id = $(this).attr("name");
    window.open(urlBase+"/obra/balanco/exportar-pdf/"+id);
});

$('#btn-excel').on('click', function(event){
    var id = $(this).attr('name');
    $.ajax({
        cache: false,
        type: "GET",
        //dataType: 'json',
        url: urlBase + "obra/balanco/exportar-excel/"+id,
        data: $("#form-filter").serialize(),
        success: function(response, request){
            if(response.success === true){
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

$('#table-balanco-materiais tbody tr').on('click', function (e) {

    var id = $(this).find('td').html();
    var obra_id =  $('input:hidden[name=obra_id]').val();

    $.ajax({
        type: "GET",
        url: urlBase + "estoque/show",
        data: {id: id, almoxarifado_id: 0, regional_id: 0 , obra_id: obra_id},
        success: function(data){
            if(data != 'undefined' && data.success === false){
                showAlert('warning', data.msg);
                $('#style-2').animate({scrollTop: 0}, 1000, 'linear');
            }else{
                $("#content-modal-materiais").html(data);
                $('#modal-form-materiais').modal('show');
            }
        }
    });
});


