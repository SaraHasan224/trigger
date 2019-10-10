(function ( $ ) {
	var baseUrl = "https://api.phone-validator.net/api/v2/verify"

	$.validatePhone = function(apiKey, countryCode, mode, locale){
		var apiKey = apiKey
		var countryCode = countryCode||"de"
		var mode = mode||"extensive"
		var locale = locale||"en-US"
		$.fn.validatePhone = function(cb, country, mode2, locale2) {
			countryCode = country||countryCode
			var mode = mode2||mode
			var locale = locale2||locale
			var phone = this.val();
			// console.log(baseUrl + "?PhoneNumber=" +encodeURI(phone) + "&CountryCode=" + countryCode + "&Mode=" + mode + "&APIKey=" + apiKey,);
			$.get(baseUrl + "?PhoneNumber=" + phone + "&CountryCode=" + countryCode + "&Mode=" + mode + "&APIKey=" + apiKey,
				$.proxy(function (res) {
					$("#phone_group").find(id).first().find('input').removeClass('is-valid');
					$("#phone_group").find(id).first().find('input').removeClass('is-invalid');
					$("#phone_group").find( ".valid-feedback" ).remove();
					$("#phone_group").find( ".invalid-feedback" ).remove();
					$( ".valid-feedback" ).remove();
					$( ".invalid-feedback" ).remove();
					if (res.status == "VALID_CONFIRMED") {
						this.css('border-color', '#28a745');
						this.addClass('is-valid');
						this.after('<div class="valid-feedback"> Looks good! VC</div>');
					} else if (res.status == "VALID_UNCONFIRMED") {
						this.css('border-color', '#28a745');
						this.addClass('is-valid');
						this.after('<div class="valid-feedback"> Looks good! VNC</div>');
					} else if (res.status == "INVALID") {
						this.css('border-color', '#dc3545');
						this.after('<div class="invalid-feedback">  Please provide a correct phone number. ! </div>');
						this.addClass('is-invalid');
					} else {
						this.css('border-color', 'black');
					}
					cb(res)
				}, this));
			return this;
		};
	}
}( jQuery ));
