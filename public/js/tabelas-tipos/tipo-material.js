var unidadeNew = [];
var detalhesMaterial = [];
var buttonActive;

$('.valor_unitario').priceFormat({
    prefix: '',
    centsSeparator: ',',
    thousandsSeparator: '.'
});


$("#content-modal-tipo-material").on("click", "#fechar-tipo-material", function() {
    $('#modal-form-tipo-material').modal('toggle');
} );

$("#content-modal-tipo-material").on("submit", "#form-tipo-material",function(event){
    event.preventDefault();
    waitingDialog.show('Carregando...');   
    document.getElementById("salvar-tipo-material").disabled = true;
    
    $('#valor_material').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });
    
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: urlBase + "sistema/tipo-material/store",
        data: $("#form-tipo-material").serialize(),
        success: function(data){
            if (data.success === true) {
                showAlertModal('success', data.msg, true);
                setTimeout(function(){ 
                    $('#modal-form-tipo-material').modal('toggle');
                    if (typeof tipoMaterialNew !== 'undefined'){
                        tipoMaterialNew.push({id: data.result.id, codigo: data.result.codigo, descricao: data.result.codigo+' - '+data.result.descricao});
                    }else{
                        location.reload();
                    }
                }, 1000);
            }else{
                document.getElementById("salvar-tipo-material").disabled = false;
                showAlertModal('warning', data.msg, true);
            }
            
            waitingDialog.hide();
        }
    });
});


function somenteNumero(obj, e) {
    var tecla = (window.event) ? e.keyCode : e.which;
    if (tecla == 8 || tecla == 0)
        return true;
    if (tecla < 48 || tecla > 57)
        return false;
}

function somenteDouble(obj, e) {
    var tecla = (window.event) ? e.keyCode : e.which;    
    if(tecla == 43 || tecla == 45 || tecla == 101 || tecla == 69 ) {
        return false;   
    }
}

function inserir(elm, codigoMaterial, descricaoMaterial){

    //Quando for adicionar os materiais na lista de conferir por planilha de excel.
    if(codigoMaterial && descricaoMaterial){
        buttonActive = $(elm).closest("tr").find("td:lt(5) button");
        buttonActive.addClass('active');

        detalhesMaterial.push({'codigo_material': codigoMaterial, 'descricao_original': descricaoMaterial});
    }

    $.get(urlBase + "sistema/tipo-material/create", function(resposta){
        if(resposta != 'undefined' && resposta.success === false){
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-tipo-material").html(resposta);
            //Utilizado para quando clicar fora do modal não fechar.
            $('#modal-form-tipo-material').modal({backdrop: 'static', keyboard: false});

            $('#constante_material').priceFormat({
                prefix: '',
                centsSeparator: ',',
                thousandsSeparator: '.'
            });

            $('#valor_material').priceFormat({
                prefix: 'R$',
                centsSeparator: ',',
                thousandsSeparator: '.'
            });
        }
    });
}

function editar(id){
    $.get(urlBase + "sistema/tipo-material/edit/" + id, function(resposta){
        if(resposta != 'undefined' && resposta.success === false){
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-tipo-material").html(resposta);
            $('#modal-form-tipo-material').modal('show');

            $('#constante_material').priceFormat({
                prefix: '',
                centsSeparator: ',',
                thousandsSeparator: '.'
            });

            $('#valor_material').priceFormat({
                prefix: 'R$',
                centsSeparator: ',',
                thousandsSeparator: '.'
            });
        }
    });
}

function deletar(id){
     $.get(urlBase + "sistema/tipo-material/delete/" + id, function(resposta){
         if(resposta != 'undefined' && resposta.success === false){
             showAlert('warning', resposta.msg);
         }else {
             $("#content-modal-tipo-material").html(resposta);
             $('#modal-form-tipo-material').modal('show');
         }

    });
}

function createUnidade(){
    $.get(urlBase + "sistema/tipo-unidade-medida/create", function(resposta){
        $("#content-modal-tipo-unidade-medida").html(resposta);
        //Utilizado para quando clicar fora do modal não fechar.
        $('#modal-form-tipo-unidade-medida').modal({backdrop: 'static', keyboard: false});
    });
}

$('#modal-form-tipo-unidade-medida').on('hidden.bs.modal', function (e) { 
    if(unidadeNew.length > 0){
        $("#unidades").append('<option value='+unidadeNew[0].id+'>'+unidadeNew[0].codigo+'</option>');
        $('#unidades').val(unidadeNew[0].id).change();
        unidadeNew = [];
    }
});

$('#modal-form-tipo-material').on('shown.bs.modal', function (e) {

    if(detalhesMaterial.length > 0){
        document.getElementById("codigo").readOnly = true;
        document.getElementById("descricao").readOnly = true;
        $('#codigo').val(detalhesMaterial[0].codigo_material);
        $('#descricao').val(detalhesMaterial[0].descricao_original);
        detalhesMaterial = [];
    }
});