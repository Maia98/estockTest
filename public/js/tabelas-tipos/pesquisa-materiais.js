$('#filtrar').click(function(){
    var data_inicio = $('#data_inicial').val();
    var data_final  = $('#data_final').val();
    var msg         = '';

    if(data_inicio != '' && data_final == ''){
        msg = "A data término não foi preenchida";
    }else if(data_inicio == '' && data_final != ''){
        msg = "A data início não foi preenchida";
    }

    if(msg != ''){
        $.confirm({
            title   : 'Data',
            content : msg,
            type    : 'red',
            buttons :{
                ok  :{

                    text     : 'OK',
                    btnClass : 'btn-danger',
                    action   : function(){}
                }
            }

        });
        return false;
    }

});

$("#data_final").focusout(function(e) {
    var data_inicio = $('#data_inicial').val();
    var data_final = $('#data_final').val();
    var dateToday = getDateAtual();


    if(data_inicio == ''){
        $.confirm({
            title: 'Data Término',
            content:'Data Início não selecionada.',
            type: 'red',
            animation: 'bottom',
            buttons:{
                ok:{
                    text: 'Fechar',
                    btnClass: 'btn-danger',
                    action: function(){
                        $('#data_final').val(" ");
                    }
                }
            }
        });
    }

    if(data_inicio > data_final){
        $.confirm({
            title: 'Data Início',
            content:'Data Início não pode ser maior que a data Término.',
            type: 'red',
            animation: 'bottom',
            buttons:{
                ok:{
                    text: 'Fechar',
                    btnClass: 'btn-danger',
                    action: function(){
                        $('#data_inicial').val(" ");
                        $('#data_final').val(" ");
                    }
                }
            }
        });
    }

    if( data_final > dateToday && data_inicio != ''){
        $.confirm({
            title: 'Data Término',
            content:'Data Término é maior que data atual.',
            type: 'red',
            animation: 'bottom',
            buttons:{
                ok:{
                    text: 'Fechar',
                    btnClass: 'btn-danger',
                    action: function(){
                        $('#data_final').val(dateToday);
                    }
                }
            }
        });
    }
    else{
        $('#data_final').val();
    }
});
$('#data_inicial').on('change', function(){
    var data_inicio = $('#data_inicial').val();
    var dateToday = getDateAtual();

    if(data_inicio > dateToday){
        $.confirm({
            title: 'Data Início',
            content:'Data Início é maior que data atual.',
            type: 'red',
            animation: 'bottom',
            buttons:{
                ok:{
                    text: 'Fechar',
                    btnClass: 'btn-danger',
                    action: function(){
                        $('#data_inicial').val(dateToday);
                    }
                }
            }
        });
    }
    else{
        $('#data_inicial').val();
    }

});

function getDateAtual(){
    var date = new Date();
    var today;
    if( date.getDate() > 9 && (date.getMonth()+1) >9) {
        today = date.getFullYear()+'-'+(date.getMonth()+1)+'-'+ date.getDate();
    }
    else if((date.getMonth()+1) >9 && (date.getMonth()+1) <=9){
        today = date.getFullYear()+'-'+(date.getMonth()+1)+'-'+ '0'+ date.getDate();
    }
    else if (date.getDate() > 9 && (date.getMonth()+1) <= 9){
        today = date.getFullYear()+'-'+'0'+(date.getMonth()+1)+'-'+ date.getDate();
    }
    else{
        today = date.getFullYear()+'-'+'0'+(date.getMonth()+1)+'-'+'0'+ date.getDate();
    }
    return today;
}

$('#btn-pdf').on('click', function(event){
    window.open(urlBase + "estoque/pesquisa/exportar-pdf?" + $("#form").serialize());
});

$('#btn-excel').on('click', function(event){
    $.ajax({
        cache: false,
        type: "GET",
        url: urlBase + "estoque/pesquisa/exportar-excel",
        data: $("#form").serialize(),
        success: function(response, request){
            if(response.success === true){
                var a = document.createElement("a");
                a.href = response.file;
                a.download = response.name;
                document.body.appendChild(a);
                a.click();
                a.remove();
            }else {
                showAlert('warning',response.msg);
            }
        }
    });
});