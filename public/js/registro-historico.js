$('#btn-pdf').on('click', function(event){
    var id = $(this).attr("name");
    window.open(urlBase+"/obra/show-historico/exportar-pdf/"+id+"?"+$('#form').serialize());
});

$('#btn-excel').on('click', function(event){
    var id = $(this).attr('name');
    $.ajax({
        cache: false,
        type: "GET",
        //dataType: 'json',
        url: urlBase + "obra/show-historico/exportar-excel/"+id+"?"+$('#form').serialize(),
        data: $("#form").serialize(),
        success: function(response, request){
            if(response.success){
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