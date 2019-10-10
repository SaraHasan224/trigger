@extends('layouts.admin')
@section('styles')
  <style>
    .grid-divider {
      position: relative;
      padding: 0;
    }
    .grid-divider>[class*='col-'] {
      position: static;
    }
    .grid-divider>[class*='col-']:nth-child(n+2):before {
      content: "";
      border-left: 1px solid #DDD;
      position: absolute;
      top: 0;
      bottom: 0;
    }
    .col-padding {
      padding: 0 15px;
    }
    .equel-grid {
      width: 100%;
      min-width: 100%;
    }
    .collapse_head {
      font-weight: 800;
      font-size: 15px;
    }
    .collapse_body {
      font-weight: 300;
    }
  </style>
@endsection
@section("contents")
  <div class="viewport-header">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb has-arrow">
        <li class="breadcrumb-item">
          <a href="{{ route("admin-dashboard") }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="javascript:;">Administrator</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">My Profile</li>
      </ol>
    </nav>
  </div>
  <div class="content-viewport">
    @include("admin/includes/alerts")
    <div class="row">
      <div class="col-lg-6">
        <div class="equel-grid">
          <div class="grid">
          <div class="grid-header">
            <div class="title">My Profile</div>
          </div>
          <div class="grid-body">
            <div class="item-wrapper">
              {!! Form::open([ 'url' => route("update-profile-admin")]) !!}
              <div class="form-group">
                <label for="name"> Name: </label>
                {!! Form::text('name', old("name", auth()->user()->name), ['id' => 'name', 'class' => 'form-control', 'maxlength' => '30']) !!}
              </div>
              <div class="form-group">
                <label for="email"> E-mail Address: </label>
                {!! Form::text('email', old('email', auth()->user()->email), ['id' => 'email', 'class' => 'form-control', 'maxlength' => '255']) !!}
              </div>
              <div class="form-group">
                <label for="phone">Phone: </label>
                {!! Form::text('phone', old('phone', auth()->user()->phone), ['id' => 'phone', 'class' => 'form-control', 'maxlength' => '20']) !!}
              </div>
              <div class="form-group">
                <label>Profile Picture: </label>
                <div class="input-group">
                  <input id="thumbnail" class="form-control" type="text" name="user_image" value="{{ old("user_image", auth()->user()->user_image) }}" readonly>
                  <div class="input-group-append">
                    <button class="btn btn-danger btn-remove-image" type="button" data-input="thumbnail" data-preview="holder"><i class="fa fa-times"></i></button>
                    <button class="btn btn-primary lfm-image" type="button" data-input="thumbnail" data-preview="holder">Choose</button>
                  </div>
                </div>
                <img id="holder"{{ (old("user_image", auth()->user()->user_image) != "" ? ' src='.url(old("user_image", auth()->user()->user_image)) : "") }} class="img-fluid img-holder">
              </div>
              <button type="submit" class="btn btn-sm btn-primary">Update Profile</button>
              {!! FORM::close() !!}
            </div>

          </div>
        </div>
        </div>
      </div>
      <div class="col-lg-6">
        {{--  Credit Card Information --}}
        <div class="equel-grid">
          <div class="grid">
            <div class="grid-header collapsed" data-toggle="collapse" href="#credit-7-1" aria-expanded="false" aria-controls="credit-7-1">
              <div class="title">Credit Card Information</div>
              <div class="actions">
                <div class="btn-group btn-group-sm" role="group" aria-label="...">
                  <button type="button" class="collapsed btn btn-primary" data-toggle="collapse" href="#credit-collapse-7-1" aria-expanded="false" aria-controls="credit-collapse-7-1"></i>Edit</button>
                </div>
              </div>
            </div>
            <div class="grid-body collapse" role="tab" id="credit-collapse-7-1">
              <div class="item-wrapper">
                {!! Form::open([ 'url' => route("update-cc-info")]) !!}
                <div class="form-group">
                  <label for="name"> Credit Card Account Holder Number: </label>
                  {!! Form::text('cc_name', old("cc_name", (!empty($user_list->cc_name) ? $user_list->cc_name : '')), ['id' => 'cc_name', 'class' => 'form-control', 'maxlength' => '199']) !!}
                </div>
                <div class="form-group">
                  <label for="name"> Credit Card Number: </label>
                  {!! Form::text('cc_num', old("cc_num", (!empty($user_list->cc_num) ? $user_list->cc_num : '')), ['class' => 'form-control', 'maxlength' => '19']) !!}
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="email"> Expiry Date: </label>
                    {!! Form::text('cc_exp', old('cc_exp', (!empty($user_list->cc_exp) ? $user_list->cc_exp : '')), ['id' => 'cc_exp', 'class' => 'form-control', 'maxlength' => '5']) !!}
                  </div>
                  <div class="form-group col-md-6">
                    <label for="phone">Card Verification Value (CVV): </label>
                    {!! Form::text('c_cvv', old('c_cvv', (!empty($user_list->c_cvv) ? $user_list->c_cvv : '')), ['id' => 'cvv', 'class' => 'form-control', 'maxlength' => '3']) !!}
                  </div>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Update Credit Card Number</button>
                {!! FORM::close() !!}
              </div>
            </div>
            <div class="grid-body collapse" role="tab" id="credit-7-1">
              <div class="item-wrapper">
                <div class="form-group">
                  <label class="collapse_head"> Credit Card Account Holder Number: </label>
                  <label class="collapse_body"> {{!empty($user_list->cc_name) ? $user_list->cc_name : ''}} </label>
                </div>
                <div class="form-group">
                  <label class="collapse_head"> Credit Card Number: </label>
                  <label class="collapse_body" id = 'cc_num'> {{!empty($user_list->cc_num) ? $user_list->cc_num : ''}} </label>
                </div>
                <div class="form-group">
                  <label class="collapse_head"> Expiry Date: </label>
                  <label class="collapse_body"> {{!empty($user_list->cc_exp) ? $user_list->cc_exp : ''}} </label>
                </div>
                <div class="form-group">
                  <label class="collapse_head">Card Verification Value (CVV): </label>
                  <label class="collapse_body"> {{!empty($user_list->c_cvv) ? $user_list->c_cvv : ''}} </label>
                </div>
              </div>
            </div>
          </div>
        </div>
        {{--  Debit Card Information --}}
        <div class="equel-grid">
          <div class="grid">
            <div class="grid-header collapsed" data-toggle="collapse" href="#debit-7-1" aria-expanded="false" aria-controls="debit-7-1">
              <div class="title">Debit Card Information</div>
              <div class="actions">
                <div class="btn-group btn-group-sm" role="group" aria-label="...">
                  <button type="button" class="collapsed btn btn-primary" data-toggle="collapse" href="#debit-collapse-7-1" aria-expanded="false" aria-controls="debit-collapse-7-1"></i>Edit</button>
                </div>
              </div>
            </div>
            <div class="grid-body collapse" role="tab" id="debit-collapse-7-1">
              <div class="item-wrapper">
                {!! Form::open([ 'url' => route("update-dc-info")]) !!}
                <div class="form-group">
                  <label for="dc_name"> Debit Card Account Holder Name: </label>
                  {!! Form::text('dc_name', old("dc_name", (!empty($user_list->dc_name) ? $user_list->dc_name : '')), ['id' => 'dc_name', 'class' => 'form-control', 'maxlength' => '199']) !!}
                </div>
                <div class="form-group">
                  <label for="dc_num"> Debit Card Number: </label>
                  {!! Form::text('dc_num', old("dc_num", (!empty($user_list->dc_num) ? $user_list->dc_num : '')), ['class' => 'form-control', 'maxlength' => '19']) !!}
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="dc_exp"> Expiry Date: </label>
                    {!! Form::text('dc_exp', old('dc_exp', (!empty($user_list->dc_exp) ? $user_list->dc_exp : '')), ['id' => 'dc_exp', 'class' => 'form-control', 'maxlength' => '5']) !!}
                  </div>
                  <div class="form-group col-md-6">
                    <label for="d_cvv">Card Verification Value (CVV): </label>
                    {!! Form::text('d_cvv', old('d_cvv', (!empty($user_list->d_cvv) ? $user_list->d_cvv : '')), ['id' => 'd_cvv', 'class' => 'form-control', 'maxlength' => '3']) !!}
                  </div>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Update Debit Card Number</button>
                {!! FORM::close() !!}
              </div>
            </div>
            <div class="grid-body collapse" role="tab" id="debit-7-1">
              <div class="item-wrapper">
                <div class="form-group">
                  <label class="collapse_head"> Debit Card Account Holder Number: </label>
                  <label class="collapse_body"> {{!empty($user_list->dc_name) ? $user_list->dc_name : ''}} </label>
                </div>
                <div class="form-group">
                  <label class="collapse_head"> Debit Card Number: </label>
                  <label class="collapse_body" id = 'dc_num'> {{!empty($user_list->dc_num) ? $user_list->dc_num : ''}} </label>
                </div>
                <div class="form-group">
                  <label class="collapse_head"> Expiry Date: </label>
                  <label class="collapse_body"> {{!empty($user_list->dc_exp) ? $user_list->dc_exp : ''}} </label>
                </div>
                <div class="form-group">
                  <label class="collapse_head">Card Verification Value (CVV): </label>
                  <label class="collapse_body"> {{!empty($user_list->d_cvv) ? $user_list->d_cvv : ''}} </label>
                </div>
              </div>
            </div>
          </div>
        </div>
        {{--  Bank Account Information --}}
        <div class="equel-grid">
          <div class="grid">
            <div class="grid-header collapsed" data-toggle="collapse" href="#bank-7-1" aria-expanded="false" aria-controls="bank-7-1">
              <div class="title">Bank Account</div>
              <div class="actions">
                <div class="btn-group btn-group-sm" role="group" aria-label="...">
                  <button type="button" class="collapsed btn btn-primary" data-toggle="collapse" href="#bank-collapse-7-1" aria-expanded="false" aria-controls="bank-collapse-7-1"></i>Edit</button>
                </div>
              </div>
            </div>
            <div class="grid-body collapse" role="tab" id="bank-collapse-7-1">
              <div class="item-wrapper">
                {!! Form::open([ 'url' => route("update-bank-info")]) !!}
                <div class="form-group">
                  <label for="name"> Account Holder Name: </label>
                  {!! Form::text('holder_name', old("holder_name", (!empty($user_list->holder_name) ? $user_list->holder_name : '')), ['id' => 'holder_name', 'class' => 'form-control', 'maxlength' => '199']) !!}
                </div>
                <div class="form-group">
                  <label for="email"> Account Number: </label>
                  {!! Form::text('acc_num', old('acc_num',  (!empty($user_list->acc_num) ? $user_list->acc_num : '')), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                  <label for="phone">IBAN Number (Optional): </label>
                  {!! Form::text('iban_num', old('iban_num',  (!empty($user_list->iban_num) ? $user_list->iban_num : '')), ['class' => 'form-control']) !!}
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="phone">Bank Name: </label>
                    {!! Form::text('bank_name', old('bank_name',  (!empty($user_list->bank_name) ? $user_list->bank_name : '')), ['id' => 'bank_name', 'class' => 'form-control']) !!}
                  </div>
                  <div class="form-group col-md-6">
                    <label for="email"> Bank Code: </label>
                    {!! Form::text('bank_code', old('bank_code',  (!empty($user_list->bank_code) ? $user_list->bank_code : '')), ['id' => 'bank_code', 'class' => 'form-control']) !!}
                  </div>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Update Bank Information</button>
                {!! FORM::close() !!}
              </div>
            </div>
            <div class="grid-body collapse" role="tab" id="bank-7-1">
              <div class="item-wrapper">
                <div class="form-group">
                  <label class="collapse_head"> Account Holder Name: </label>
                  <label class="collapse_body"> {{!empty($user_list->holder_name) ? $user_list->holder_name : ''}} </label>
                </div>
                <div class="form-group">
                  <label class="collapse_head"> IBAN Number (Optional): </label>
                  <label class="collapse_body" id = 'iban_num'> {{!empty($user_list->iban_num) ? $user_list->iban_num : ''}} </label>
                </div>
                <div class="form-group">
                  <label class="collapse_head"> Account Number: </label>
                  <label class="collapse_body" id="acc_num"> {{!empty($user_list->acc_num) ? $user_list->acc_num : ''}} </label>
                </div>
                <div class="form-group">
                  <label class="collapse_head"> Bank Name: </label>
                  <label class="collapse_body"> {{!empty($user_list->bank_name) ? $user_list->bank_name : ''}} </label>
                </div>
                <div class="form-group">
                  <label class="collapse_head">Bank Code: </label>
                  <label class="collapse_body"> {{!empty($user_list->bank_code) ? $user_list->bank_code : ''}} </label>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('js_plugins')
  <script src="{{ url("public/vendor/laravel-filemanager/js/lfm.js") }}"></script>
  <script src="{{ url("public/admin/assets/js/forms/validation.js") }}"></script>

  <script>

	  $(document).ready(function(){
		  $('#credit-collapse-7-1').click(function(){
			  $('#credit-7-1').empty();
		  });
		  $('#debit-collapse-7-1').click(function(){
			  $('#debit-7-1').empty();
		  });
		  $('#bank-collapse-7-1').click(function(){
			  $('#bank-7-1').empty();
		  });
		  $('#credit-7-1').click(function(){
			  $('#credit-collapse-7-1').empty();
		  });
		  $('#debit-7-1').click(function(){
			  $('#debit-collapse-7-1').empty();
		  });
		  $('#bank-7-1').click(function(){
			  $('#bank-collapse-7-1').empty();
		  });

		  // we call the function
		  var acc_num = $('#acc_num').html();
		  var iban_num = $('#iban_num').html();

		  acc_num_masked_obj = maskify(acc_num);
		  $('#acc_num').html(acc_num_masked_obj);

		  iban_num_masked_obj = maskify(iban_num);
		  $('#iban_num').html(iban_num_masked_obj);


		  var debit_card = $('#dc_num').html();
		  var credit_card = $('#cc_num').html();
		  function maskify(cc) {
			  var maskedString = "";
			  for(var i = 0; i < cc.length - 3; i++) {
//				  maskedString += "#";
				  if (i == 4 || i == 9 || i == 14)
                  {
					  maskedString += "-";
                  }else{
					  maskedString += "#";
                  }
			  }

			  for(var j = 3; j >= 1; j--) {
				  var lastCharacter = cc.charAt(cc.length - j);
				  var lastNums = lastCharacter;
				  maskedString += lastNums;
			  }
			  return maskedString;
		  }
		  if(debit_card.length != 0 && debit_card != "")
		  {
			  d_masked_obj = maskify(debit_card);
			  $('#dc_num').html(d_masked_obj);

		  }
		  else{
			  $("#dc_num").mask('0000-0000-0000-0000');
		  }
		  if(credit_card.length != 0 && credit_card != "")
		  {
			  c_masked_obj = maskify(credit_card);
			  $('#cc_num').html(c_masked_obj);

		  }
		  else{
			  $("#cc_num").mask('0000-0000-0000-0000');
		  }
	  });
	  $("#dc_exp").mask('00/00');
	  $("#cc_exp").mask('00/00');

	  $("#d_cvv").mask('000');
	  $("#c_cvv").mask('000');

	  $("#cc_num").mask('0000-0000-0000-0000');

  </script>
@endsection