@extends('layouts.admin')
@section('contents')
  <div class="viewport-header">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb has-arrow">
        <li class="breadcrumb-item">
          <a href="{{ route("admin-dashboard") }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="javascript:;">Administrator</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Edit Record</li>
      </ol>
    </nav>
  </div>
  <div class="content-viewport">
    @include("admin/includes/alerts")
    {!! Form::open([ 'url' => route('record-update', ["id" => $Record->id])]) !!}
    <div class="row">
      <div class="col-lg-12 equel-grid">
        <div class="grid">
          <div class="grid-header">
            <div class="title"><i class="mdi mdi-account-search"></i>&nbsp; Edit Record </div>
            <div class="actions">
              <div class="btn-group btn-group-sm" role="group" aria-label="...">
                <button type="submit" class="btn btn-success has-icon"><i class="fa fa-save"></i>Save</button>
                <button type="button" onClick="location.href='{{ route("user-list") }}'" class="btn btn-danger has-icon"><i class="fa fa-times"></i>Cancel</button>
              </div>
            </div>
          </div>
          <div class="grid-body">
            <div class="item-wrapper"  style="border:2px solid #e8e8e8; padding:20px;">
              <div class="row">
                <div class="col-lg-12">
                <!-- {{--Name--}} -->
                  <div class="row">
                    <div class="col-md-2">
                      <label> <i class="fa fa-user"></i> Name:
                      </label>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        {!! Form::text('first_name', old("first_name",$Record->first_name),['placeholder' => 'First Name','class' =>'form-control form-control-sm defaultconfig-3', 'maxlength' => '30']) !!}
                      </div>
                    </div>
                    <div class="col-md-offset-1 col-md-3">
                      <div class="form-group">
                        {!! Form::text('middle_name', old("middle_name",$Record->middle_name),['placeholder' => 'Middle Name','class' =>'form-control form-control-sm defaultconfig-3', 'maxlength' => '30']) !!}
                      </div>
                    </div>
                    <div class="col-md-offset-1 col-md-3">
                      <div class="form-group">
                        {!! Form::text('last_name', old("last_name",$Record->last_name),['placeholder' => 'Last Name','class' => 'form-control form-control-sm defaultconfig-3','maxlength' => '30']) !!}
                      </div>
                    </div>
                  </div>
                <!-- {{--Birth Date--}} -->
                  <div class="row">
                    <div class="col-md-2">
                      <label> <i class="mdi mdi-cake"></i> Birth Date: </label>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <div class="demo-wrapper">
                          <div class="input-group mb-3">
                            {!! Form::text('dob', old("dob",$Record->dob),['placeholder' => 'Date of Birth','class' => 'form-control form-control-sm', 'id'=>'datetimepicker4']) !!}
                             <span class="input-group-addon input-group-append">
                                <span class="mdi mdi-calendar input-group-text"></span>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <!-- {{--Email Address--}} -->
                  <div class="row email_div">
                    <div class="col-md-2">
                      <label> <i class="fa fa-inbox"></i> Email Address: </label>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        {!! Form::text('email', old("email",$Record->email),['placeholder' => 'Email Address','class' =>'form-control form-control-sm p_email', 'id' => 'p_email_0']) !!}
                      </div>
                    </div>
                      <div class="col-md-2">
                        <label> <i class="fa fa-phone-square"></i>
                          Phone Number: </label>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          {!! Form::tel('phone_no', old("phone_no",$Record->phone_no),['placeholder' => 'Enter Phone Number','class' =>'form-control form-control-sm ', 'maxlength' => '16'])!!}
                        </div>
                      </div>
                  </div>
                <!-- {{--Current Address and Location--}} -->
                  <div class="row form_stradd">
                    <div class="col-md-2">
                      <label> <i class="fa fa-map-marker"></i> Current Address: </label>
                    </div>
                    <div class="col-md-6" id="current_address">
                      <div class="form-group mb-3">
                        {!! Form::text('current_street', old("current_street",$Record->current_street), ['placeholder' => 'Current Street Address','class' => 'address form-control form-control-sm', 'id' => 'validationServer03 address']) !!}
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1"><img src="{{ asset('admin/country-flag/us.png')}}"> </span>
                        </div>
                        {!! Form::text('business_country', 'US', ['class' => 'form-control', 'id' => 'SideID4', 'disabled' => 'disabled', 'id' => 'countrycode']) !!}
                      </div>
                    </div>
                  </div>
                  <div class="row form_stradd">
                    <div class="col-md-2"></div>
                    <div class="col-md-3">
                      <div class="form-group">
                        {!! Form::text('current_state', old("current_city",$Record->current_city), ['placeholder' => 'Current State','class' => 'p_state form-control form-control-sm']) !!}
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        {!! Form::text('current_city', old("current_state",$Record->current_state), ['placeholder' => 'Current City','class' => 'form-control form-control-sm', 'id' => 'city']) !!}
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        {!! Form::number('current_zip', old("current_zip",$Record->current_zip), ['placeholder' => 'Current ZIP','class' => 'form-control form-control-sm p_zip', 'maxlength' => '10', 'id' => 'p_zip defaultconfig-3']) !!}
                      </div>
                    </div>
                  </div>
                <!-- {{--Old Address and Location--}} -->
                  <div class="row form_stradd">
                    <div class="col-md-2">
                      <label> <i class="fa fa-map-marker"></i> Old Address: </label>
                    </div>
                    <div class="col-md-6" id="current_address">
                      <div class="form-group mb-3">
                        {!! Form::text('old_street', old("old_street",$Record->old_street), ['placeholder' => 'Old Street Address','class' => 'address form-control form-control-sm', 'id' => 'validationServer03 address']) !!}
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1"><img src="{{ asset('admin/country-flag/us.png')}}"> </span>
                        </div>
                        {!! Form::text('business_country', 'US', ['class' => 'form-control', 'id' => 'SideID4', 'disabled' => 'disabled', 'id' => 'countrycode']) !!}
                      </div>
                    </div>
                  </div>
                  <div class="row form_stradd">
                    <div class="col-md-2"></div>
                    <div class="col-md-3">
                      <div class="form-group">
                        {!! Form::text('old_city', old("old_city",$Record->old_city), ['placeholder' => 'Old State','class' => 'p_state form-control form-control-sm']) !!}
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        {!! Form::text('old_state', old("old_state",$Record->old_state), ['placeholder' => 'Old City','class' => 'form-control form-control-sm', 'id' => 'city']) !!}
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        {!! Form::number('old_zip', old("old_zip",$Record->old_zip), ['placeholder' => 'Old ZIP','class' => 'form-control form-control-sm p_zip', 'maxlength' => '10', 'id' => 'p_zip defaultconfig-3']) !!}
                      </div>
                    </div>
                  </div>
                <!-- {{--Employer--}} -->
                  <div class="row">
                    <div class="col-md-2">
                      <label> <i class="fa fa-suitcase"></i> Current Employer: </label>
                    </div>
                    <div class="col-md-5">
                      <div class="form-group">
                        {!! Form::text('current_emp', old("current_emp",$Record->current_emp),['placeholder' => 'Current Employer Name','class' => 'form-control form-control-sm']) !!}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                  <!-- {{--policy_number--}} -->
                    <div class="col-md-2">
                      <label> <i class="fa fa-question-circle"></i> Policy Number: </label>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        {!! Form::text('policy_number', old("policy_number",$Record->policy_number),['placeholder' => 'Policy Number','class' => 'form-control form-control-sm']) !!}
                      </div>
                    </div>
                    {{--line_of_business--}}
                    <div class="col-md-2">
                      <label> <i class="fa fa-building"></i> Line of Business: </label>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        {!! Form::text('line_of_business', old("line_of_business",$Record->line_of_business),['placeholder' => 'Line of Business','class' => 'form-control form-control-sm']) !!}
                      </div>
                    </div>
                  </div>


                  <div class="row">
                  <!-- {{--Claim Number--}} -->
                    <div class="col-md-2">
                      <label> <i class="fa fa-reorder"></i> Claim Number: </label>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        {!! Form::text('claim_number', old("claim_number",$Record->claim_number),['placeholder' => 'Claim Number','class' => 'form-control form-control-sm']) !!}
                      </div>
                    </div>
                    {{--Loss Date--}}
                    <div class="col-md-2">
                      <label> <i class="fa fa-money"></i> Loss Date: </label>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        {!! Form::text('loss_date', old("loss_date",$Record->loss_date),['placeholder' => 'Line of Business','class' => 'form-control form-control-sm']) !!}
                      </div>
                    </div>
                  </div>

                <!-- {{--Claim Description--}} -->
                  <div class="row">
                    <div class="col-md-2">
                      <label> <i class="fa fa-address-card-o"></i> Claim Description: </label>
                    </div>
                    <div class="col-md-10">
                      <div class="form-group">
                        {!! Form::textarea('claim_desc', old("claim_number",$Record->claim_number),['placeholder' => 'Claim Description','class' => 'form-control form-control-sm']) !!}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
    {!! FORM::close() !!}
  </div>
@endsection
@section('js_plugins')
  <script src="{{ url("public/vendor/laravel-filemanager/js/lfm.js") }}"></script>
  <script src="{{ url("public/admin/assets/js/forms/validation.js") }}"></script>
  <script>
//	  $("#datetimepicker4").mask('00/00/0000');
  </script>
@endsection