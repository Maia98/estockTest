var tamanhoTelaHeight = $(window).height() - 150;

$('body').css({
    'overflow' : 'hidden',
    'overflow-x' : 'hidden',
    'overflow-y' : 'hidden'
});

$('.wrapper').css({
    'overflow' : 'hidden',
    'overflow-x' : 'hidden',
    'overflow-y' : 'hidden'
});

$('body').css({
    'height'   : tamanhoTelaHeight + 150,
    'overflow' : 'hidden'
});

$('.box').css({
    'height' : tamanhoTelaHeight + 60,
    'overflow'          : 'scroll',
    'overflow-x'        : 'hidden',
    'overflow-y'        : 'auto',
    '-webkit-scrollbar' : 'width : 5px;'
});

if((tamanhoTelaHeight + 70) < 300){
    $('body').removeAttr('class').attr('class','hold-transition skin-blue sidebar-mini');
    $('.sidebar').css({
        'max-height' : tamanhoTelaHeight + 70,
        'overflow'   : 'scroll',
        'overflow-x' : 'auto',
        'overflow-y' : 'auto'
    });
}else{
    $('body').removeAttr('class').attr('class','hold-transition skin-blue sidebar-mini sidebar-collapse');
    $('.sidebar').css({
        'max-height' : tamanhoTelaHeight + 150,
        'overflow'   : 'initial'
    });

    $('.main-footer').css({
        'width'      : '96.5%'
    });
}

$(window).resize(function(){

    var tamanhoTelaHeight = $(window).height() - 150;

    $('body').css({
        'height'   : tamanhoTelaHeight + 150,
        'overflow' : 'hidden'
    });

    $('.box').css({
        'height' : tamanhoTelaHeight + 60,
        'overflow'          : 'scroll',
        'overflow-x'        : 'hidden',
        'overflow-y'        : 'auto',
        '-webkit-scrollbar' : 'width : 5px;'
    });

    if((tamanhoTelaHeight + 70) < 300){
        $('body').removeAttr('class').attr('class','hold-transition skin-blue sidebar-mini');
        $('.sidebar').css({
            'max-height' : tamanhoTelaHeight + 70,
            'overflow'   : 'scroll',
            'overflow-x' : 'auto',
            'overflow-y' : 'auto'
        });

        $('.main-footer').css({
            'width'      : '100%'
        });

    }else{
        $('body').removeAttr('class').attr('class','hold-transition skin-blue sidebar-mini sidebar-collapse');
        $('.sidebar').css({
            'max-height' : tamanhoTelaHeight + 150,
            'overflow'   : 'initial'
        });

        $('.main-footer').css({
            'width'      : '96.5%'
        });
    }
});


