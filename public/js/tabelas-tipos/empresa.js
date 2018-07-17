$(document).ready(function() {

    $('#cnpj').inputmask({'mask': "99.999.999/9999-99", greedy: false, reverse: true, autoUnmask: true});
    $('#cep').inputmask({'mask': "99999-999", greedy: false, reverse: true, autoUnmask: true});
    $('#telefone').inputmask({'mask': "(99) 9999-9999", greedy: false, reverse: true, autoUnmask: true});
    $('#celular').inputmask({'mask': "(99) 99999-9999", greedy: false, reverse: true, autoUnmask: true});
   
});	

