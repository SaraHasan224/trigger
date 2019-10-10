(function ($) {
    'use strict';

    $(".enable-mask.date-mask").mask('00/00/0000');
    $(".enable-mask.time-mask").mask('00:00:00');
    $(".enable-mask.phone-mask").mask('(000) 000-0000');
    $(".enable-mask.ip_address-mask").mask('0ZZ.0ZZ.0ZZ.0ZZ', {
        translation: {
            'Z': {
                pattern: /[0-9]/,
                optional: true
            }
        }
    });

    $('#defaultconfig').maxlength({
        warningClass: "badge mt-1 badge-success",
        limitReachedClass: "badge mt-1 badge-danger"
    });

    $('#defaultconfig-2').maxlength({
        alwaysShow: true,
        threshold: 20,
        warningClass: "badge mt-1 badge-success",
        limitReachedClass: "badge mt-1 badge-danger"
    });

    $('#defaultconfig-3').maxlength({
        alwaysShow: true,
        threshold: 10,
        warningClass: "badge mt-1 badge-success",
        limitReachedClass: "badge mt-1 badge-danger",
        separator: ' of ',
        preText: 'You have ',
        postText: ' chars remaining.',
        validate: true
    });

	$('.defaultconfig-3').maxlength({
		alwaysShow: true,
		threshold: 30,
		warningClass: "badge mt-1 badge-success",
		limitReachedClass: "badge mt-1 badge-danger",
		separator: ' of ',
		preText: 'You have ',
		postText: ' chars remaining.',
		validate: true
	});

    $('#maxlength-textarea').maxlength({
        alwaysShow: true,
        warningClass: "badge mt-1 badge-success",
        limitReachedClass: "badge mt-1 badge-danger"
    });
})(jQuery);