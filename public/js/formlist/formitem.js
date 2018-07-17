function createItem(id){

    $.get(urlBase + "sistema/item/create/",{id: id}, function(resposta){

        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);

        }else {

            $("#content-modal-item").html(resposta);
            $('#modal-form-item').modal('show');
            showItens(id);
        }
    });
}

function insertItem() {

    var valueinput = $("#value").val();
    var extra = $("#extra").val();
    var lista_id = $('#lista_id').val();

    $.post(urlBase + 'sistema/item/store/', {lista_id: lista_id,value: valueinput, extra: extra }, function (resposta) {
        createItem(lista_id);
    });

}

function editItem(){
    var valueinput = $("#value").val();
    var extra = $("#extra").val();
    var item_id = $('#iditem').val();

    var lista_id = $('#lista_id').val();

    $.post(urlBase + 'sistema/item/store/', {id: item_id, value: valueinput, extra: extra, lista_id: lista_id }, function (resposta) {
        createItem(lista_id);
    });
}

function showItens(id)
{

    //var idlist = JSON.stringify(id);

    $.ajax({
        type: 'GET',
        url: urlBase + 'sistema/item/show/'+id,
        dataType: 'json',
        success:function (json) {
                console.log(json);

            for (var x in json.itens) {
                $("#table-body-itens").append("<tr><td>"+json.itens[x].value+"</td><td>"+json.itens[x].extra+"</td><td style='width: 45px;'>"+
                    "<button type='button' class='btn btn-primary btn-xs' onclick='editarItem("+json.itens[x].id+")'>"+
                    " <i class='glyphicon glyphicon-pencil'></i>&nbsp;</button>"+
                    "<button type='button' class='btn btn-danger btn-xs' onclick='modalDelete("+json.itens[x].id+")' ><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></button>" +
                    "</td></tr>'");
            }

        },
        error:function () {
            return false;
        }
    });

    /*$.get(urlBase + "sistema/item/show", function(resposta){

      });*/

}
function deletarItem(id) {

    var lista_id = $('#lista_id').val();

    $.ajax({
        type: 'POST',
        url: urlBase + 'sistema/item/destroy',
        dataType: 'json',
        data: {lista_id: lista_id, id: id},
        success:function () {

            $("#modal-form-itemdelete").modal('hide');
            $("#content-modal-itemdelete").modal('hide');
            createItem(lista_id);
        },
        error:function () {
            return false;
        }
    });
}



function editarItem(id){

    var iditem = JSON.stringify(id);
    $.ajax({
        type: 'GET',
        url: urlBase + 'sistema/item/edit/'+iditem,
        success:function (resposta) {

            if (resposta != 'undefined' && resposta.success === false) {
                showAlert('warning', resposta.msg);

            }else {
                $("#content-modal-item").html(resposta);
                $('#modal-form-item').modal('show');
            }

        },
        error:function () {
            return false;
        }
    });
}
function addItem() {
    var valueinput = $("#value").val();
    var extra = $("#extra").val();


        $("#table-body-itens").append("<tr><td>" + valueinput + "</td><td>" + extra + "</td><td style='width: 45px;'>" +
            "<button type='button' class='btn btn-danger btn-xs' onclick='deletarItem()' ><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></button>" +
            "</td></tr>'");

}

function modalDelete(id) {

    $.get(urlBase + "sistema/item/delete/" + id, function(resposta){
        if (resposta != 'undefined' && resposta.success === false) {
            showAlert('warning', resposta.msg);
        }else {
            $("#content-modal-itemdelete").html(resposta);
            $('#modal-form-itemdelete').modal('show');
        }
    });
}

