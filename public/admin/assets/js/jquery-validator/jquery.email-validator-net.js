(function ( $ ) {
	var baseUrl = "https://api.email-validator.net/api/verify"

	$.validateEmail = function(apiKey){
		var apiKey = apiKey
		$.fn.validateEmail = function(cb) {
			var email = this.val();
			url = encodeURI(baseUrl + "?EmailAddress=" + email + "&APIKey=" + apiKey);
			// console.log("url = "+url);
			$.get(url, $.proxy(function (res) {
				// console.log(this);
				id = '#'+$(this).attr('id');
				// console.log(res.status);
				$(id).removeClass('is-valid');
				$(id).removeClass('is-invalid');
				$('.email_div ').find( ".valid-feedback" ).remove();
				$('.email_div ').find( ".invalid-feedback" ).remove();
				if (/2[0-9]{2}/g.test(res.status)) {
					$(id).css('border-color', '#28a745');
					$(id).addClass('is-valid');
					$(id).after('<div class="valid-feedback"> Looks good!</div>');

					res['simpleStatus'] = "VALID"
				} else if (/3[0-9]{2}/g.test(res.status)) {
					$(id).css('border-color', '#28a745');
					$(id).addClass('is-valid');
					$(id).after('<div class="valid-feedback"> Looks good!</div>');

					res['simpleStatus'] = "SUSPECT"
				} else if (/4[0-9]{2}/g.test(res.status)) {
					// $(id).css('border-color', 'red');
					$(id).css('border-color', '#dc3545');
					$(id).addClass('is-invalid');
					$(id).after('<div class="invalid-feedback"> Error! Email Address doesn\'t exist</div>');

					res['simpleStatus'] = "INVALID"
				} else if (/1[0-9]{2}/g.test(res.status)) {
					// $(id).css('border-color', 'black');
					$(id).css('border-color', '#dc3545');
					$(id).addClass('is-invalid');
					$(id).after('<div class="invalid-feedback"> Error!  Email Address doesn\'t exist</div>');

					res['simpleStatus'] = "INDETERMINATE"
				}
				cb(res)
			}, this));
			return this;
		};
	}
}( jQuery ));
