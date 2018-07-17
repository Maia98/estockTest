function showAlert(type, message) {
    $('#alert').removeClass().addClass('alert-' + type).html(message).fadeIn();
    document.getElementById("alert").innerHTML = '<i class="fa fa-fw fa-close" style="float: right; margin: 3px 5px;" onclick="closeAlert()"></i>' + message;
    setTimeout("closeAlert()", 4000); // 5 segundos
    $('body').animate({scrollTop: 0}, 1000, 'linear');
}

function showAlertModal(type, message, subModal=false, subModalChild=false) {

    if(subModal){
      $('#alert-modal2').removeClass().addClass('alert-' + type).html(message).fadeIn();
      document.getElementById("alert-modal2").innerHTML = '<i class="fa fa-fw fa-close" style="float: right; margin-right: 5px;" onclick="closeAlertModal()"></i>'+ message;
      setTimeout("closeAlertModal(true, false)", 4000); 
    }else if(subModalChild){
      $('#alert-modal3').removeClass().addClass('alert-' + type).html(message).fadeIn();
      document.getElementById("alert-modal3").innerHTML = '<i class="fa fa-fw fa-close" style="float: right; margin-right: 5px;" onclick="closeAlertModal()"></i>'+ message;
      setTimeout("closeAlertModal(false, true)", 4000); 
    }else{
      $('#alert-modal').removeClass().addClass('alert-' + type).html(message).fadeIn();
      document.getElementById("alert-modal").innerHTML = '<i class="fa fa-fw fa-close" style="float: right; margin-right: 5px;" onclick="closeAlertModal()"></i>'+ message;
    setTimeout("closeAlertModal()", 4000); // 5 segundos
    }
}

function closeAlert() {
    $('#alert').fadeOut();
}

function closeAlertModal(subModal=false, subModalChild=false) {
  if(subModal){
    $('#alert-modal2').fadeOut();
  }else if(subModalChild){
    $('#alert-modal3').fadeOut();
  }else{
    $('#alert-modal').fadeOut();
  }
}

function closeAlertIndex() {
    $('#alert-index').fadeOut();
}

function abrirImagemFullScreen(indice, tipo, id) {

    waitingDialog.show('Procurando Imagens...');

    var pswpElement = document.querySelectorAll('.pswp')[0];

    var srcs = [];
    var imagensView = [];

    $.ajax({
        type: "GET",
        url: urlBase + tipo + "/imagens/" + id,
        async: false,
        success: function (data) {
            srcs = data;
        }
    });

    srcs.forEach(function (path) {
        imagensView.push({src: path, w: 1600, h: 1400});
    });


    var options = {
        index: indice
    };

    waitingDialog.hide();
    // Initializes and opens PhotoSwipe
    var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, imagensView, options);
    gallery.init();
}

function onTopModal(){
  $('.modal-body').animate({scrollTop: 0}, 1000, 'linear');
}

var waitingDialog = waitingDialog || (function ($) {
    'use strict';

  // Creating modal dialog's DOM
  var $dialog = $(
    '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
    '<div class="modal-dialog modal-m">' +
    '<div class="modal-content">' +
      '<div class="modal-header"><h3 style="margin:0;"></h3></div>' +
      '<div class="modal-body">' +
        '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
      '</div>' +
    '</div></div></div>');

  return {
    /**
     * Opens our dialog
     * @param message Custom message
     * @param options Custom options:
     *          options.dialogSize - bootstrap postfix for dialog size, e.g. "sm", "m";
     *          options.progressType - bootstrap postfix for progress bar type, e.g. "success", "warning".
     */
    show: function (message, options) {
      // Assigning defaults
      if (typeof options === 'undefined') {
        options = {};
      }
      if (typeof message === 'undefined') {
        message = 'Carregando...';
      }
      var settings = $.extend({
        dialogSize: 'm',
        progressType: '',
        onHide: null // This callback runs after the dialog was hidden
      }, options);

      // Configuring dialog
      $dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
      $dialog.find('.progress-bar').attr('class', 'progress-bar');
      if (settings.progressType) {
        $dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
      }
      $dialog.find('h3').text(message);
      // Adding callbacks
      if (typeof settings.onHide === 'function') {
        $dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) {
          settings.onHide.call($dialog);
        });
      }
      // Opening dialog
      $dialog.modal();
    },
    /**
     * Closes dialog
     */
    hide: function () {
      $dialog.modal('hide');
    }
  };

})(jQuery);

