$('select').select2();

if($("#filter_regional").val() != 0){
    getAlmoxarifado();
}

$('#data_termino').on('change',function(){
    var data_inicio  = $('#data_inicio').val();
    var data_termino = $('#data_termino').val();

    if(data_termino < data_inicio){
        $.confirm({
            title   : 'Data',
            content : 'Data término é menor que a data início',
            type    : 'red',
            buttons :{
                ok  :{
                    text     : 'OK',
                    btnClass : 'btn-danger',
                    action   : function(){}
                }
            }

        });

        $('#data_termino').val('');
    }
    
});

$('#data_inicio').on('change',function(){
    var data_termino = $('#data_termino').val();
    var data_inicio  = $('#data_inicio').val();

    if(data_termino != ''){

        if(data_inicio > data_termino){
            $.confirm({
                title   : 'Data',
                content : 'Data Início é maior que a data término',
                type    : 'red',
                buttons :{
                    ok  :{
                        text     : 'OK',
                        btnClass : 'btn-danger',
                        action   : function(){}
                    }
                }

            });

            $('#data_inicio').val('');
        }

    }
    
});

$('#filtrar').click(function(){
    var data_inicio = $('#data_inicio').val();
    var data_final  = $('#data_termino').val();
    var msg         = '';

    if(data_inicio == '' && data_final == ''){
        msg = "As datas término e início não foram preenchidas.";
    }else if(data_inicio != '' && data_final == ''){
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

$('#btn-excel').on('click', function(event){

    $.ajax({
        cache: false,
        type: "GET",
        url: urlBase + "estoque/exportar-excel",
        data: $("#form-filter").serialize(),
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

$('#btn-pdf').on('click', function(event){
    window.open(urlBase + "estoque/exportar-pdf?" + $("#form-filter").serialize());
});


$("#content-modal-materiais").on("submit", "#form-materiais",function(event){
    event.preventDefault();
    waitingDialog.show('Carregando...');
    //desabilitar quando for enviado a requisicao   
    document.getElementById("salvar-funcao-materiais").disabled = true;
    
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: urlBase + "sistema/materiais/store",
        data: $("#form-materiais").serialize(),
        success: function(data){
            if (data.success === true) {
                console.log(data);
                showAlertModal('success', data.msg);
                setTimeout(function(){ 
                    $('#modal-form-materiais').modal('toggle');
                    if (typeof materiaisNew !== 'undefined') {
                        funcionarioNew.push({id: data.result.id, nome: data.result.nome, supervisor: data.result.supervisor, fiscal: data.result.fiscal, encarregado: data.result.encarregado});
                    }else{
                        location.reload();
                    }  
                }, 1000);
            }else{
                document.getElementById("salvar-funcao-materiais").disabled = false;
                showAlertModal('warning', data.msg);
            }
            waitingDialog.hide();
        }
    });
});

$("#filter_regional").on("change", function(e) {
    getAlmoxarifado();    
});

function getAlmoxarifado(){
    var id_regional = $("#filter_regional").val();
    var _token = '{{csrf_token()}}';
    waitingDialog.show('Carregando...');
    $.ajax({
        type: "GET",
        data: {_token: _token, local_id: id_regional},
        url: urlBase + "/estoque/getAlmoxarifado",
        dataType: 'json',
        success: function(data) {
            
            var $campo = $("#filter_almoxarifado");
            $campo.empty();
            $campo.append('<option value="0">Selecione</option>');
            
            $.each(data, function(index, row) {
                $campo.append('<option value='+ row.id +'>'+ row.nome +'</option>');
                document.getElementById("filter_regional").disabled = false;
            });
            
            waitingDialog.hide();
        }
    });
}

function detalhes(id){

    var almoxarifado_id = $('#filter_almoxarifado').find('option:selected').val();
    var regional_id = $('#filter_regional').find('option:selected').val();

    $.ajax({
        type: "GET",
        //dataType: 'json',
        url: urlBase + "estoque/show",
        data: {id: id, almoxarifado_id: almoxarifado_id, regional_id: regional_id },
        success: function(data){
            if(data != 'undefined' && data.success === false){
                showAlert('warning', data.msg);
            }else{
                $("#content-modal-materiais").html(data);
                $('#modal-form-materiais').modal('show');
            }
        }
    });

   /* $.get(urlBase + "/estoque/show/" + id, function(resposta){
   });*/
}
