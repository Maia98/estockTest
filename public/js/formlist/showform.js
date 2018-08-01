
function showForm(id){
    
    $.get(urlBase + "sistema/showform/show/"+id, function(resposta){
        
        if (resposta != 'undefined' && resposta.success === false) {
       
        }else {
            alert('passou');
        }
    });
}