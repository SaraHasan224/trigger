(function ($) {

    $(".alert.dismissible-alert").append('<i class="alert-close mdi mdi-close"></i>');
    $(".alert.dismissible-alert .alert-close").on("click", function () {
        $(this).parent().slideToggle();
    });

    function toggleAlertNotificationTop() {
        $("body").append('\
            <div class="alert-notification-wrapper top">\
                <div class="alert-notification dismissible-alert">\
                    <p><b>Welcome !&nbsp;</b>Bernice Ingram</p>\
                    <i class="alert-close mdi mdi-close"></i>\
                </div>\
            </div>\
        ');
        $(".alert-notification-wrapper .dismissible-alert .alert-close").on("click", function () {
            $(this).parentsUntil(".alert-notification-wrapper").slideToggle();
        });
    }

    function toggleAlertNotificationBottom() {
        $("body").append('\
            <div class="alert-notification-wrapper bottom">\
                <div class="alert-notification dismissible-alert">\
                    <p><b>Welcome !&nbsp;</b>Bernice Ingram</p>\
                    <i class="alert-close mdi mdi-close"></i>\
                </div>\
            </div>\
        ');
        $(".alert-notification-wrapper .dismissible-alert .alert-close").on("click", function () {
            $(this).parentsUntil(".alert-notification-wrapper").slideToggle();
        });
    }

    $("#alert-notification-toggler-top").click("on", function () {
        toggleAlertNotificationTop();
    });

    $("#alert-notification-toggler-bottom").click("on", function () {
        toggleAlertNotificationBottom();
    });


    showInfoToast = function () {
        'use strict';
        resetToastPosition();
        $.toast({
            text: "Hi There, What's up!",
            icon: 'info',
            allowToastClose: false,
            heading: 'Lou Watson',
            position: 'top-right',
            loader: true,
            loaderBg: '#00e093'
        })
    };

    showSuccessToast = function () {
        'use strict';
        resetToastPosition();
        $.toast({
            text: "Hi There, What's up!",
            icon: 'success',
            allowToastClose: false,
            heading: 'Lou Watson',
            position: 'top-right',
            loader: true,
            loaderBg: '#00ba7a'
        })
    };

    showWarningToast = function () {
        'use strict';
        resetToastPosition();
        $.toast({
            text: "Hi There, What's up!",
            icon: 'warning',
            allowToastClose: false,
            heading: 'Lou Watson',
            position: 'top-right',
            loader: true,
            loaderBg: '#ed673c'
        })
    };

    showErrorToast = function () {
        'use strict';
        resetToastPosition();
        $.toast({
            text: "Hi There, What's up!",
            icon: 'error',
            allowToastClose: false,
            heading: 'Lou Watson',
            position: 'top-right',
            loader: true,
            loaderBg: '#ff3941'
        })
    };




    showToastPosition = function (position) {
        'use strict';
        resetToastPosition();
        $.toast({
            text: "Hi There, What's up!",
            icon: 'info',
            allowToastClose: false,
            heading: 'Lou Watson',
            position: String(position),
            loader: true,
            loaderBg: '#00e093'
        })

    }

    showToastInCustomPosition = function () {
        'use strict';
        resetToastPosition();
        $.toast({
            heading: 'Custom positioning',
            text: 'Specify the custom position object or use one of the predefined ones',
            icon: 'info',
            position: {
                left: 500,
                bottom: 20
            },
            stack: false,
            loaderBg: '#00e093'
        })
    }

    resetToastPosition = function () {
        $('.jq-toast-wrap').removeClass('bottom-left bottom-right top-left top-right mid-center'); // to remove previous position class
        $(".jq-toast-wrap").css({
            "top": "",
            "left": "",
            "bottom": "",
            "right": ""
        }); //to remove previous position style
    }
})(jQuery);