(function ( $ ) {
    var baseUrl = "https://api.address-validator.net/api/verify"

    $.validateAddress = function(apiKey){
      var apiKey = 'av-cf6de170ac7cb129b474fd262bd2d37a';
      $.fn.validateAddress = function(cb) {
        var address = $(".address").val();
		var city =   $("#city").val();
		var p_zip =   $(".p_zip").val();
		var countrycode =   $("#countrycode").val();
        // console.log(baseUrl + "?StreetAddress="+encodeURI(address)+"&City="+city+"&PostalCode="+p_zip+"&CountryCode="+countrycode+"&APIKey=" + apiKey);
		if(address.length > 0 && city.length > 0 && p_zip.length > 0 && countrycode.length > 0){
			$.ajax({
				type: "GET",
				url: baseUrl + "?StreetAddress="+encodeURI(address)+"&City="+city+"&PostalCode="+p_zip+"&CountryCode="+countrycode+"&APIKey=" + apiKey,
				success: function (response) {
					// console.log(response);
					$(".address").removeClass('is-valid');
					$(".address").removeClass('is-invalid');
					$("#current_address").find( ".valid-feedback" ).remove();
					$("#current_address").find( ".invalid-feedback" ).remove();
					if (response.status == "VALID") {
						// this.children("input").css('border', '1px solid green');
						$(".city").val(response.city);
						$(".p_state").val(response.state);
						$("#current_address").find('.form-group').first().append('<div class="valid-feedback"> Looks good! </div>');
						$("#current_address").find('.form-group').first().find('input').addClass('is-valid');
					} else if (response.status == "SUSPECT") {
						$(".address").val(response.addressline1);
						$(".city").val(response.city);
						$(".p_state").val(response.state);
						$("#current_address").find('.form-group').first().append('<div class="valid-feedback"> Looks good! </div>');
						$("#current_address").find('.form-group').first().find('input').addClass('is-valid');

						$("#current_address").css('border-color', '1px solid orange');

					} else if (response.status == "INVALID") {
						$("#current_address").find('.form-group').first().append('<div class="invalid-feedback"> Please provide a valid street address. </div>');
						$("#current_address").find('.form-group').first().find('input').addClass('is-invalid');
					} else {
						$("#current_address").find('.form-group').first().append('<div class="invalid-feedback"> Please provide a valid street address. </div>');
						$("#current_address").find('.form-group').first().find('input').addClass('is-invalid');
					}
				},
				error: function(response){
				}
			});
		}
        return this;
      };
    }
  }( jQuery ));
