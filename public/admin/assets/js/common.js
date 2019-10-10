$(document).ready(function () {
    $(".btn-logout").click(function (e) {
        e.preventDefault();
        $("#frmLogout").submit();
    });

    if ($.fn.filemanager) {
        $('.lfm-image').filemanager('images', {prefix: Globals.url + '/filemanager'});
        $('.lfm-file').filemanager('files', {prefix: Globals.url + '/filemanager'});
    }

    $(document).on("click", '.btn-remove-image', function () {
        $("#"+$(this).data("input")).val('');
        $("#"+$(this).data("preview")).removeAttr("src");
    });
    $(document).on("click", '.btn-remove-file', function () {
        $("#"+$(this).data("input")).val('');
        $("#"+$(this).data("preview")).html('');
    });
    if ($.fn.select2 && $(".my-select").length > 0) {
        $(".my-select").select2();
    }
});

function message_box(modal_label, modal_content, type, ok_callback, cancel_callback) {
    $('#MessageModalLabel').html(modal_label);
    $('#MessageModal .modal-body h5').html(modal_content);
    if (type == "confirm") {
        $("#MessageModal .modal-footer").html('<button type="button" id="btnModalMsgOK" data-dismiss="modal" class="btn btn-info"><i class="fa fa-check"></i> OK</button><button type="button" class="btn btn-warning" data-dismiss="modal" id="btnModalMsgCancel"><i class="fa fa-times"></i> Cancel</button>');
    } else {
        $("#MessageModal .modal-footer").html('<button type="button" data-dismiss="modal" class="btn btn-info" id="btnModalMsgOK"><i class="fa fa-check"></i> OK</button>');
    }

    $("#MessageModal").modal({
        backdrop: 'static',
        keyboard: false
    });

    if(ok_callback != null) {
        $("#btnModalMsgOK").click(ok_callback);
    }
    if(cancel_callback != null) {
        $("#btnModalMsgCancel").click(cancel_callback);
    }
}