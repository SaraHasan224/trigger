@extends('layouts.admin')
@section('stylesheets')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset("admin/assets/vendors/datatables/datatables.bundle.css") }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset("admin/assets/vendors/iconfonts/mdi/css/materialdesignicons.css") }}">
@endsection
@section('styles')
    <style>
        /* For Firefox */
        input[type='number'] {
            -moz-appearance:textfield;
        }
        /* Webkit browsers like Safari and Chrome */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .btn {
            padding: .84rem 1.14rem;
            font-size: .81rem;
        }
        .btn i, .fc-button i {
            font-size: 1rem;
            margin-top: 3px;
        }
        .add_button{
            border-radius: 50%;
            margin-top: -7px;
        }

        .btn.btn-sm {
            padding: .5rem 0.6rem;
            font-size: .54rem;
        }
        /*.btn.btb*/
        .add_current_button {
            margin-bottom: 10px;
        }

        .header-fixed .t-header {
            z-index: 99 !important;
        }
        .custom-head label{
            margin-left: 31px;
            font-weight: 600;
            text-decoration: underline;
            font-size: 20px;
            letter-spacing: 0.05rem;
        }
        .custom-margin .form-control{
            margin-bottom:5px;
        }
        .custom-margin label{
            font-weight: 600;
            font-size: 16px;
            letter-spacing: 0.05rem;
        }
        .custom-margin2 .form-control{
            margin-bottom:5px;
        }
        .custom-margin2 label{
            font-weight: 300;
            letter-spacing: 0.0rem;
            margin-bottom: 0.0rem;
            color: #000;
        }
        .input-group-prepend{
            margin-left: 5px;
        }
        .input-group-prepend label{
            margin-left: 5px;
        }
        .input-control:focus{
            border:#000 1px solid;
        }
        .input-group-num {
            background-color: #f6f7f9;
            color: #101010;
            border-color: #f2f4f9;
            padding: 3px 10px;
            font-size: 13px;
        }
        /*.modal-open .modal {*/
        /*background-color: rgba(0,0,0,0.7) !important;*/
        /*background-color: rgba(255,255,255,0.3) !important;*/
        /*}*/

    </style>
@endsection
@section('contents')
    <div class="viewport-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb has-arrow">
                <li class="breadcrumb-item">
                    <a href="{{ route("admin-dashboard") }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:;">Workbench</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">New Person Search</li>
            </ol>
        </nav>
    </div>
    <div class="content-viewport">
        @include("admin/includes/alerts")
            <div class="row">
                <div class="col-12">
                    <div class="item-wrapper">
                        {!! Form::open([ 'url' => route('personal-save'), 'id' => 'addressform']) !!}
                            <!-- <div class="content-viewport">
                                <div class="grid">
                                    <div class="grid-body"> -->
                                        <div class="row">
                                            <div class="col-lg-12 equel-grid">
                                                <div class="grid">
                                                    <div class="grid-header">
                                                        <div class="title"><i class="mdi mdi-account-search"></i>&nbsp; Search Input </div>
                                                        <div class="actions">
                                                            <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                                                <button type="button" class="btn btn-success WorkbenchModel"
                                                                        data-toggle="modal"
                                                                        data-target="#WorkbenchModel"> Modal
                                                                </button>
                                                                <button type="button"  onClick="location.href='{{ route('personal-result',5) }}'"
                                                                        class="btn btn-danger btn-lg has-icon">Result
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Personal Workbench -->
                                                    <div class="custom-head">
                                                        <label>Personal Workbench </label>
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
                                                                                {!! Form::text('first_name', old("first_name"),['placeholder' => 'First Name','class' =>'form-control form-control-sm defaultconfig-3', 'maxlength' => '30']) !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-offset-1 col-md-3">
                                                                            <div class="form-group">
                                                                                {!! Form::text('middle_name', old("middle_name"),['placeholder' => 'Middle Name','class' =>'form-control form-control-sm defaultconfig-3', 'maxlength' => '30']) !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-offset-1 col-md-3">
                                                                            <div class="form-group">
                                                                                {!! Form::text('last_name', old("last_name"),['placeholder' => 'Last Name','class' => 'form-control form-control-sm defaultconfig-3','maxlength' => '30']) !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <!-- {{--Alias--}} -->
                                                                <!--
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                            <label> Alias: </label>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                {!! Form::text('a_first_name[]', old("a_first_name"),['placeholder' => 'First Name','class' =>'form-control form-control-sm defaultconfig-3', 'maxlength' => '30']) !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                {!! Form::text('a_middle_name[]', old("a_middle_name"),['placeholder' => 'Middle Name','class' =>'form-control form-control-sm defaultconfig-3', 'maxlength' => '30']) !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                {!! Form::text('a_last_name[]', old("a_last_name"),['placeholder' => 'Last Name','class' => 'form-control form-control-sm defaultconfig-3','maxlength' => '30']) !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <a href="javascript:void(0)"
                                                                            class="btn btn-primary btn-sm add_alias_button add_button"><i class="fa fa-plus-square"></i></a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="alias_addmore"></div>
                                                                -->
                                                                <!-- {{--Birth Date--}} -->
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                            <label> <i class="mdi mdi-cake"></i> Birth Date: </label>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <div class="demo-wrapper">
                                                                                    <div id="datepicker-popup" class="input-group date datepicker">
                                                                                        {!! Form::text('birth_date', old("birth_date"),['placeholder' => 'Date of Birth','class' => 'form-control form-control-sm', 'id'=>'datetimepicker4']) !!}
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
                                                                                {!! Form::text('p_email', old("p_email"),['placeholder' => 'Email Address','class' =>'form-control form-control-sm p_email', 'id' => 'p_email_0']) !!}
                                                                            </div>
                                                                        </div>
                                                                        {{--<div class="col-md-1">--}}
                                                                            {{--<a href="javascript:void(0)"--}}
                                                                            {{--class="btn btn-primary btn-sm add_email_button add_button"><i class="fa fa-plus-square"></i></a>--}}
                                                                        {{--</div>--}}
                                                                    </div>
                                                                    <div class="email_addmore email_div"></div>
                                                                <!-- {{--Social--}} -->
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                            <label> <i class="fa fa-globe"></i> Social
                                                                                Media Links: </label>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                {!! Form::text('social[username][]', old("username"),['placeholder' => 'Username','class' => 'form-control form-control-sm']) !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                {!! Form::text('social[url][]', old("social_url"),['placeholder' => 'Site Link','class' => 'form-control form-control-sm']) !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                {!! Form::select('social[site][]', $social, old("site"),['class' => 'form-control form-control-sm']) !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <a href="javascript:void(0)"
                                                                            class="btn btn-primary btn-sm add_social_button add_button"><i class="fa fa-plus-square"></i></a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="social_addmore"></div>
                                                                <!-- {{--Current Address and Location--}} -->
                                                                    <div class="row form_stradd">
                                                                        <div class="col-md-2">
                                                                            <label> <i class="fa fa-map-marker"></i> Current Address: </label>
                                                                        </div>
                                                                        <div class="col-md-6" id="current_address">
                                                                            <div class="form-group mb-3">
                                                                                {!! Form::text('street_address', old("street_address"), ['placeholder' => 'Street Address','class' => 'address form-control form-control-sm', 'id' => 'validationServer03 address']) !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="input-group mb-3">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon1"><img src="{{ asset('admin/country-flag/us.png')}}"> </span>
                                                                                </div>
                                                                                {!! Form::text('business_country', "US", ['class' => 'form-control', 'id' => 'SideID4', 'disabled' => 'disabled', 'id' => 'countrycode']) !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row form_stradd">
                                                                        <div class="col-md-2"></div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                {!! Form::text('state', old("state"), ['placeholder' => 'State','class' => 'p_state form-control form-control-sm']) !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                {!! Form::text('city', old("city"), ['placeholder' => 'City','class' => 'form-control form-control-sm', 'id' => 'city']) !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                {!! Form::number('zip', old("zip"), ['placeholder' => 'ZIP','class' => 'form-control form-control-sm p_zip', 'maxlength' => '10', 'id' => 'p_zip defaultconfig-3']) !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <!--<div class="row">
                                                                        <div class="col-md-1">
                                                                            <a href="javascript:void(0)" class="btn btn-primary btn-sm add_current_button add_button"><i class="fa fa-plus-square"></i></a>
                                                                        </div>
                                                                    </div> -->
                                                                    <div class="address_addmore"></div>
                                                                <!-- {{--Phone Number--}} -->
                                                                    <div class="row" id="phone_group">
                                                                        <div class="col-md-2">
                                                                            <label> <i class="fa fa-phone-square"></i>
                                                                                Phone Number: </label>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="input-group mb-3">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-num" id="basic-addon1">+1</span>
                                                                                </div>
                                                                                {!! Form::tel('phone_number[]', old("phone_number0"),['placeholder' => '(000) 123-4567','class' =>'form-control form-control-sm enable-mask phone-mask phone', 'id' => 'phone_0', 'maxlength' => '16'])!!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="input-group mb-3">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-num" id="basic-addon1">+1</span>
                                                                                </div>
                                                                                {!! Form::text('phone_number[]', old("phone_number1"),['placeholder' => '(000) 123-4567','class' =>'form-control form-control-sm enable-mask phone-mask phone', 'id' => 'phone_1', 'maxlength' => '16']) !!}
                                                                            <!--<div class="input-group-append">
                                                                                    <div class="input-group-text"><i class="mdi mdi-phone"></i></div>
                                                                                </div>-->
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="input-group mb-3">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-num" id="basic-addon1">+1</span>
                                                                                </div>
                                                                                {!! Form::text('phone_number[]', old("phone_number2"),['placeholder' => '(000) 123-4567','class' =>'form-control form-control-sm enable-mask phone-mask phone', 'id' => 'phone_2', 'maxlength' => '16']) !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" name="phone_code" id="phone_code" value="1"/>
                                                                    <input type="hidden" name="phone_locale" id="phone_locale" value="en_US"/>

                                                                <!-- {{--School--}} -->
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                            <label> <i class="mdi mdi-school"></i>
                                                                                School: </label>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                {!! Form::text('school_name[]', old("school_name"),['placeholder' => 'School Name','class' => 'form-control form-control-sm']) !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <a href="javascript:void(0)"
                                                                            class="btn btn-primary btn-sm add_school_button add_button"><i class="fa fa-plus-square"></i></a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="school_addmore"></div>
                                                                <!-- {{--Employer--}} -->
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                            <label> <i class="fa fa-suitcase"></i> Current Employer: </label>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                {!! Form::text('employer_name', old("employer_name"),['placeholder' => 'Company Name','class' => 'form-control form-control-sm']) !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                {!! Form::text('job_title', old("job_title"),['placeholder' => 'Job Title','class' =>'form-control form-control-sm']) !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="emp_addmore"></div>
                                                                <!-- {{--Current Spouse--}} -->
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                            <label><i class="mdi mdi-human-male-female"></i>
                                                                                Current Spouse: </label>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="form-group">
                                                                                {!! Form::text('spouse[first_name][]', old("sp_first_name"),['placeholder' => 'First Name','class' =>'form-control form-control-sm defaultconfig-3', 'maxlength' => '30']) !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="form-group">
                                                                                {!! Form::text('spouse[middle_name][]',old("sp_middle_name"), ['placeholder' => 'Middle Name','class' => 'form-control form-control-sm defaultconfig-3', 'maxlength' => '30']) !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="form-group">
                                                                                {!! Form::text('spouse[last_name][]', old("sp_last_name"),['placeholder' => 'Last Name','class' => 'form-control form-control-sm defaultconfig-3','maxlength' => '30']) !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="form-group">
                                                                                {!! Form::text('spouse[maiden_name][]',old("sp_maiden_name"), ['placeholder' => 'Maiden Name','class' => 'form-control form-control-sm defaultconfig-3', 'maxlength' => '30']) !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <a href="javascript:void(0)"
                                                                            class="btn btn-primary btn-sm add_spouse_button add_button"><i class="fa fa-plus-square"></i></a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="spouse_addmore"></div>
                                                                <!-- {{--Search Comments--}} -->
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                            <label><i class="fa fa-search"></i> Search Comments: </label>
                                                                        </div>
                                                                        <div class="col-md-10">
                                                                            <div class="form-group">
                                                                                {!! Form::text('comments', old("comments"), ['placeholder'=> 'Enter any comments you want to save within search','class' => 'form-control form-control-sm', 'maxlength' => '30']) !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Internal Command -->
                                                    <div class="custom-head">
                                                        <label>Internal Command </label>
                                                    </div>

                                                    <div class="grid-body" >
                                                        <div class="item-wrapper" >
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    {{--Schema--}}
                                                                    {{--<div class="row" style="display: none;">
                                                                        <div class="col-md-2">
                                                                            <label> <i class="fa fa-user"></i> Schema:</label>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                {!! Form::select('schema', $schema, old("schema"), ['class' => 'form-control form-control-sm my-select', 'id' => 'SideID2']) !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>--}}
                                                                    {{-- Source Options--}}
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                            <label style="font-weight: 900;">Source Options </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="grid-body">
                                                                        <div class="item-wrapper">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <label class="radio-label"
                                                                                           style="font-style: italic;">Sources : <span>check / uncheck</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                            {{-- Source Options Checkboxes--}}
                                                                            <div class="grid-body" >
                                                                                <div class="item-wrapper">
                                                                                    <div class="row">
                                                                                        @foreach($source_opt as $opt)
                                                                                            <div class="col-lg-3">
                                                                                                <div class="form-group">
                                                                                                    <div class="checkbox">
                                                                                                        <label>
                                                                                                            <input type="checkbox" name="opt[{{ $opt->identifier_name }}]" value="{{$opt->name}}" class="form-check-input" {{$opt->default != null ? 'checked' : ''}}> {{$opt->name}} <i class="input-frame"></i>
                                                                                                        </label>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            {{--
                                                                            <div class="item-wrapper" style="margin-top: 20px; display: none;">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-group">
                                                                                            <div class="form-inline">
                                                                                                <div class="radio mb-3">
                                                                                                    <label class="radio-label mr-4">
                                                                                                        <input name="sample" type="radio" checked="">Perform Cached Search <i class="input-frame"></i>
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div class="radio mb-3">
                                                                                                    <label class="radio-label">
                                                                                                        <input name="sample" type="radio">Perform Fast Search <i class="input-frame"></i>
                                                                                                    </label>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="item-wrapper" style=" display: none;">
                                                                                <!-- Product -->
                                                                                <div class="row">
                                                                                    <div class="col-md-2">
                                                                                        <label> Product: </label>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            {!! Form::select('product_type', $product_type, old("product_type"), ['class' => 'form-control form-control-sm']) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- Rate Set -->
                                                                                <div class="row">
                                                                                    <div class="col-md-2">
                                                                                        <label> Rate Set: </label>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            {!! Form::select('rate_set', $rate_set, old("rate_set"), ['class' => 'form-control form-control-sm']) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- Risk Characterstic Company -->
                                                                                <div class="row">
                                                                                    <div class="col-md-2">
                                                                                        <label> Risk Characterstic
                                                                                            Company: </label>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            {!! Form::select('risk_char_comp',$risk_char_comp, old("risk_char_comp"),['class' => 'form-control form-control-sm']) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <label>Enter one or more URLs (each on new line) to bypass searches and process just the URL provided: </label>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <textarea name="url_search" value="old('url_search')" class="form-control form-control-sm" id="inputType9" cols="12" rows="5"></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <label>Enter test content to bypass all searching and rate against just this content: </label>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <textarea name="test_content" value="old('test_content')" class="form-control form-control-sm" id="inputType9" cols="12" rows="5"></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                 <!-- Custom Search String Legend -->

                                                                                <div class="row">
                                                                                    <div class="col-md-4">
                                                                                        <div class="custom-margin">
                                                                                            <label>Custom Search String Legend </label>
                                                                                            {!! Form::text('custom_f_name', old("custom_f_name"),['placeholder' => '[first_name]','class' => 'form-control form-control-sm','maxlength' => '30']) !!}
                                                                                            {!! Form::text('custom_m_name', old("custom_m_name"),['placeholder' => '[middle_name]','class' => 'form-control form-control-sm','maxlength' => '30']) !!}
                                                                                            {!! Form::text('custom_l_name', old("custom_l_name"),['placeholder' => '[last_name]','class' => 'form-control form-control-sm','maxlength' => '30']) !!}
                                                                                            {!! Form::text('custom_dob', old("custom_dob"),['placeholder' => '[date_of_birth]','class' => 'form-control form-control-sm','maxlength' => '30']) !!}
                                                                                            {!! Form::text('custom_mail', old("custom_mail"),['placeholder' => '[email.0]','class' => 'form-control form-control-sm']) !!}
                                                                                            {!! Form::text('custom_num', old("custom_num"),['placeholder' => '[phone.0]','class' => 'form-control form-control-sm']) !!}
                                                                                            {!! Form::text('custom_u_name', old("custom_u_name"),['placeholder' => '[username.0.username]','class' => 'form-control form-control-sm']) !!}
                                                                                            {!! Form::text('custom_street', old("custom_street"),['placeholder' => '[current_address.street]','class' => 'form-control form-control-sm']) !!}
                                                                                            {!! Form::text('custom_city', old("custom_city"),['placeholder' => '[current_address.city]','class' => 'form-control form-control-sm']) !!}
                                                                                            {!! Form::text('custom_state', old("custom_state"),['placeholder' => '[current_address.state]','class' => 'form-control form-control-sm']) !!}
                                                                                            {!! Form::text('custom_zip', old("custom_zip"),['placeholder' => '[current_address.zip]','class' => 'form-control form-control-sm']) !!}
                                                                                            {!! Form::text('custom_ins_name', old("custom_ins_name"),['placeholder' => '[educational_institution.0.name]','class' => 'form-control form-control-sm']) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-8">

                                                                                        <div class="custom-margin2">
                                                                                            <label>Bing Address (use placeholder)</label>
                                                                                            {!! Form::text('custom_f_name_param', old("custom_f_name_param"),['placeholder' => '([current_address.street], [current_address.city],[current_address.state] [current_address.zip])','class' => 'form-control form-control-sm']) !!}
                                                                                            <label>Bing Contact (use placeholder)</label>
                                                                                            {!! Form::text('custom_m_name_param', old("custom_m_name_param"),['placeholder' => '("[username.0.username]") OR ("[email.0]") OR ("[phone.0]")','class' => 'form-control form-control-sm']) !!}
                                                                                            <label>Bing Name (use placeholder)</label>
                                                                                            {!! Form::text('custom_l_name_param', old("custom_l_name_param"),['placeholder' => '("[first_name][last_name]") | ("[last_name][first_name]")','class' => 'form-control form-control-sm']) !!}
                                                                                            <label>Bing Name Address (use placeholder)</label>
                                                                                            {!! Form::text('custom_dob_param', old("custom_dob_param"),['placeholder' => '("[first_name][last_name]")&("[current_address.street][current_address.city]")','class' => 'form-control form-control-sm']) !!}
                                                                                            <label>Bing Name Keyword (use placeholder)</label>
                                                                                            {!! Form::text('custom_mail_param', old("custom_mail_param"),['placeholder' => '("[first_name][last_name]")','class' => 'form-control form-control-sm']) !!}
                                                                                            <label>Google Custom Address 1 (use placeholder)</label>
                                                                                            {!! Form::text('custom_num_param', old("custom_num_param"),['placeholder' => '[current_address.street][current_address.city] ("[first_name][last_name]" OR "[first_name]*[last_name]") ','class' => 'form-control form-control-sm']) !!}
                                                                                            <label>Google Custom Contact (use placeholder)</label>
                                                                                            {!! Form::text('custom_u_name_param', old("custom_u_name_param"),['placeholder' => '"[email.0]" OR "[phone.0]"','class' => 'form-control form-control-sm']) !!}
                                                                                            <label>Google Custom Name (use placeholder)</label>
                                                                                            {!! Form::text('custom_street_param', old("custom_street_param"),['placeholder' => '"([first_name][middle_name][last_name]") OR ("[first_name]*[last_name]")','class' => 'form-control form-control-sm']) !!}
                                                                                            <label>Google Custom Username (use placeholder)</label>
                                                                                            {!! Form::text('custom_city_param', old("custom_city_param"),['placeholder' => '"[email.0]" OR "[username.0.username]"','class' => 'form-control form-control-sm']) !!}
                                                                                            <label>Piplv5 Full (use placeholder)</label>
                                                                                            {!! Form::text('custom_state_param', old("custom_state_param"),['placeholder' => 'minimum_probability=0&minimum_match=1&show_sources=all&live_feeds=&hide_sponsored=&use_https=true','class' => 'form-control form-control-sm']) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-group">
                                                                                            <div class="checkbox">
                                                                                                <label>
                                                                                                    <input type="checkbox" class="form-check-input"> By Pass Saving Subject <i class="input-frame"></i>
                                                                                                </label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            --}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                {{-- <div class="grid-body" style=" display: none;">
                                                        <div class="item-wrapper">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <!-- Report Options-->
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                            <label style="font-weight: 900;">Report Options </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="grid-body" style="border:2px solid #e8e8e8;">
                                                                        <div class="item-wrapper">
                                                                            <div class="item-wrapper">
                                                                                <div class="row">
                                                                                    <div class="col-md-2">
                                                                                        <div class="form-group">
                                                                                            {!! Form::text('product_type', 100, ['class' => 'form-control form-control-sm']) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-10">
                                                                                        <div class="form-group">
                                                                                            <label>Max low rated hits to include in result </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-2">
                                                                                        <div class="form-group">
                                                                                            {!! Form::text('product_type', 40, ['class' => 'form-control form-control-sm']) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-10">
                                                                                        <div class="form-group">
                                                                                            <label>Lowest rating to return (for external defaults to 40) </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-2">
                                                                                        <div class="form-group">
                                                                                            {!! Form::text('product_type', 1000, ['class' => 'form-control form-control-sm']) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-10">
                                                                                        <div class="form-group">
                                                                                            <label>Risk Keyword proximity for rating (defaults to 1000) </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="checkbox">
                                                                                            <label>
                                                                                                <input type="checkbox" class="form-check-input"> Generate LogDebug/Codetrace information <i class="input-frame"></i>
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="checkbox">
                                                                                            <label>
                                                                                                <input type="checkbox" class="form-check-input"> Strip Tags before comparing <i class="input-frame"></i>
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="checkbox">
                                                                                            <label>
                                                                                                <input type="checkbox" class="form-check-input"> Bypass Affinity <i class="input-frame"></i>
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="checkbox">
                                                                                            <label>
                                                                                                <input type="checkbox" class="form-check-input"> Bypass url cache <i class="input-frame"></i>
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="checkbox">
                                                                                            <label>
                                                                                                <input type="checkbox" class="form-check-input"> Bypass content cache <i class="input-frame"></i>
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="checkbox">
                                                                                            <label>
                                                                                                <input type="checkbox" class="form-check-input"> Create Data Scientist files <i class="input-frame"></i>
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="checkbox">
                                                                                            <label>
                                                                                                <input type="checkbox" class="form-check-input"> Test Data Science Indexes <i class="input-frame"></i>
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="checkbox">
                                                                                            <label>
                                                                                                <input type="checkbox" class="form-check-input"> Use Keep-alive feature for long running searches <i class="input-frame"></i>
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row">
                                                                                    <div class="col-md-10">
                                                                                        <div class="input-group mb-3">
                                                                                            <label>Set time Limit of</label><div class="input-group-prepend">{!! Form::text('product_type', 1000, ['class' => 'input-control input-control-sm col-md-3']) !!}<label>seconds</label></div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-10">
                                                                                        <div class="input-group mb-3">
                                                                                            <label>Set Search Source Time Limit of</label><div class="input-group-prepend">{!! Form::text('product_type', 1000, ['class' => 'input-control input-control-sm col-md-3']) !!}<label>seconds</label></div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-10">
                                                                                        <div class="input-group mb-3">
                                                                                            <label>Multi Curl Limit</label><div class="input-group-prepend">{!! Form::text('product_type', 1000, ['class' => 'input-control input-control-sm col-md-3']) !!}</div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-10">
                                                                                        <div class="input-group mb-3">
                                                                                            <label>Set Cache Override Date (ex. 2019-01-15) of</label><div class="input-group-prepend">{!! Form::text('product_type', old('product_type'), ['class' => 'input-control input-control-sm col-md-3']) !!}</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> --}}

                                                    <!-- Submit divison -->
                                                    <div class="row" style="margin-bottom:30px;">
                                                        <div class="col-lg-2 equel-grid">
                                                             &nbsp;  &nbsp;
                                                            <button type="button"
                                                                    onClick="location.href='{{ route('admin-dashboard') }}'"
                                                                    class="btn btn-danger btn-lg has-icon"><i class="fa fa-times"></i>Cancel
                                                            </button>
                                                        </div>
                                                        <div class="col-lg-8 equel-grid">&nbsp;</div>
                                                        <div class="col-lg-2 equel-grid">
                                                            <button type="submit" id="submit" class="btn btn-success btn-lg has-icon">
                                                                <i class="fa fa-search"></i>Search
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    <!-- </div>
                                </div>
                            </div> -->
                        {!! FORM::close() !!}
                    </div>
                </div>
            </div>
        </div>
    <div class="modal fade" id="WorkbenchModel" tabindex="-1" role="dialog" aria-labelledby="WorkbenchModel">
        <div class="modal-dialog  modal-lg" role="document" id="dail">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h4 class="modal-title text-white" id="WorkbenchModel">Searching for <span>John Pagliaro</span></h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <img src="{{asset('admin/search.gif')}}" style="width: 200px; height: 200px;"/>
                        <h4 class="text-black font-weight-medium mb-4">Searching Social Networks...</h4>
                    </div>
                    <div class="progress" style="height: 35px !important;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60"
                             aria-valuemin="0" aria-valuemax="100">Piple.com
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-link text-black component-flat"
                            data-dismiss="modal">Close
                    </button>
                    <button type="button" class="btn btn-success btn-sm">Done</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js_plugins')
    <script src="{{ asset('admin/assets/js/forms/form_elements.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/assets/js/forms/validation.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/assets/js/jquery-validator/jquery.address-validator-net.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/assets/js/jquery-validator/jquery.phone-validator-net.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/assets/js/jquery-validator/jquery.email-validator-net.js') }}" type="text/javascript"></script>
@endsection
@section('javascripts')
    <script>
/*
        $(document).ready(function() {
            // Init only once validation
            $.validateAddress("av-cf6de170ac7cb129b474fd262bd2d37a");
			$.validatePhone("pv-906e682fb2b260c5ec772b71db168f52");
			$.validateEmail("ev-658ca9f79fb5acb8dcbfa9eb33b5bfc0");

            // OnClick
			$(document).on("click", "#submit", function (event) {
                event.preventDefault();
				var email = $(".p_email");
				var phone = $(".phone");
                console.log(email);
				// Byteplant Email Validator
				for(var i=0;i<email.length;i++)
				{
					num = email[i].value;
					id = '#'+email[i].id;
//					console.log('Email Validator: id= '+id+' val= '+num);
					if(num.length > 0)
					{
						// Byteplant Email Validator Sent Request
						$(id).validateEmail(function (response) {

							// Byteplant Address Validator
//								console.log(response);
							$("#addressform").validateAddress(function (response) {
//								console.log(response);

                                // Byteplant Phone Validator start
								for(var i=0;i<phone.length;i++)
								{
									num = phone[i].value;
									id = '#'+phone[i].id;
									if(num.length > 0)
									{
										// Byteplant Phone Validator Sent Request
										$(id).validatePhone(function (response) {
//                                console.log(response);
										},  $("#countrycode").val())
									}
									if(i == phone.length-1){
										Callsubmit();
                                    }
								}

								//has class

								// Byteplant Phone Validator ends
							});
						});
					}
				}




            });

			function callSubmit(){
					console.log('access controller');
					var formData = new FormData($('#addressform')[0]);
					$.ajax({
						type: "POST",
						enctype: 'multipart/form-data',
						contentType: false,
						processData:false,
						cache:false,
						headers:
							{
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							},
						url: "route('personal-save')}}",
						data: formData,
						success: function (response) {
						},
						error: function(response){
						}
					});
            }
        });
*/
		//  Personal Workbench
		$(document).ready(function () {
			$(document).on("click", ".WorkbenchModel", function () {
				//				alert ("oi");
				$("div").removeClass("modal-backdrop");
            });
		});
		$(document).ready(function () {
			// Add More Alias Fields
			$('.alias_addmore').on('click', '.remove_addmore', function (e) {
				e.preventDefault();
				$(this).parent('div').parent('div').remove(); //Remove field html
			});
			$('.add_alias_button').click(function (e) {
				$('.alias_addmore').append('<div class="row">' +
					'<div class="col-md-2">&nbsp;</div>' +
					'<div class="col-md-3">' +
					    '<div class="form-group">' +
					        '{!! Form::text("a_first_name", old("a_first_name"), ['placeholder ' => 'First Name ',"class" => "form-control form-control-sm", "maxlength" => "30"]) !!}' +
					    '</div>' +
					'</div>' +
					'<div class="col-md-offset-1 col-md-3">' +
					    '<div class="form-group">' +
					        '{!! Form::text("a_middle_name", old("a_middle_name"), ['placeholder ' => 'Middle Name ',"class" => "form-control form-control-sm", "maxlength" => "30"]) !!}' +
					    '</div>' +
					'</div>' +
					'<div class="col-md-offset-1 col-md-3">' +
					    '<div class="form-group">' +
					        '{!! Form::text("a_last_name", old("a_last_name"), ['placeholder ' => 'Last Name ',"class" => "form-control form-control-sm", "maxlength" => "30"]) !!}' +
					    '</div>' +
					'</div>' +
					'<div class="col-md-offset-1 col-md-1">' +
					    '<a href="javascript:void(0)" class="btn btn-primary btn-sm remove_addmore add_button"><i class="fa fa-minus-circle"></i></a>' +
					'</div>' +
					'</div>');
			});
			// Add More Email Address Fields
			$('.email_addmore').on('click', '.remove_emailaddmore', function (e) {
				e.preventDefault();
				$(this).parent('div').parent('div').remove(); //Remove field html
			});
			var add_email_button_clicks = 0;
			$('.add_email_button').click(function (e) {
				console.log(++add_email_button_clicks);
				$('.email_addmore').append('<div class="row"><div class="col-md-2">&nbsp;</div>' +
					'<div class="col-md-4">' +
                        '<div class="form-group">' +
                            '{!! Form::text('p_email[]', old("email"), ['placeholder ' => 'Email Address ','class ' => 'p_email form-control form-control-sm ']) !!}' +
                        '</div>' +
					'</div>' +
					'<div class="col-md-1">' +
					    '<a href="javascript:void(0)" class="btn btn-primary btn-sm remove_emailaddmore add_button"><i class="fa fa-minus-circle"></i></a>' +
					'</div></div>').find('.p_email:last').attr('id', 'p_email_'+add_email_button_clicks);
			});
			// Add More Social Fields
			$('.social_addmore').on('click', '.remove_socialmore', function (e) {
				e.preventDefault();
				$(this).parent('div').parent('div').remove(); //Remove field html
			});
			$('.add_social_button').click(function (e) {
				$('.social_addmore').append('<div class="row">' +
					'<div class="col-md-2">&nbsp;</div>' +
					'<div class="col-md-3">' +
                        '<div class="form-group">' +
                            '{!! Form::text('social[username][]', old("username"), ['placeholder ' => 'Username ','class ' => 'form-control form-control-sm']) !!}' +
                        '</div>' +
					'</div>' +
					'<div class="col-md-3">' +
                        '<div class="form-group">' +
                            '{!! Form::text('social[url][]', old("social_url"), ['placeholder ' => 'Site Link ','class ' => 'form-control form-control-sm']) !!}' +
                        '</div>' +
					'</div>' +
					'<div class="col-md-3">' +
                        '<div class="form-group">' +
                            '{!! Form::select('social[site][]', $social, old("site"), ['class ' => 'form-control form-control-sm']) !!}' +
                        '</div>' +
					'</div>' +
					'<div class="col-md-offset-1 col-md-1">' +
					'    <a href="javascript:void(0)" class="btn btn-primary btn-sm remove_socialmore add_button"><i class="fa fa-minus-circle"></i></a>' +
					'</div>' +
					'</div>');
			});
			// Add More Current Address Fields
			$('.address_addmore').on('click', '.remove_currentmore', function (e) {
				e.preventDefault();
				$(this).parent('div').parent('div').parent('div').remove(); //Remove field html
			});
			$('.add_current_button').click(function (e) {
				$('.address_addmore').append('<div class="container"><div class="row">' +
					'<div class="col-md-2">' +
					    '<a href="javascript:void(0)" class="btn btn-primary btn-sm remove_currentmore add_button"><i class="fa fa-minus-circle"></i></a>' +
					'</div>' +
					'<div class="col-md-2">' +
                        '<div class="form-group">' +
                            '{!! Form::text('current_address ', old("current_address"), ['placeholder ' => 'Street Address ','class ' => 'form-control form-control-sm']) !!}' +
                        '</div>' +
					' </div>' +
					'<div class="col-md-2">' +
                        '<div class="form-group">' +
                            '{!! Form::select('p_country ', $countries, old("p_country"), ['class ' => 'form-control form-control-sm my-select ']) !!}' +
                        '</div>' +
					'</div>' +
					'<div class="col-md-2">' +
                        '<div class="form-group">' +
                            '{!! Form::text('state ', old("state"), ['placeholder ' => 'State ','class ' => 'form-control form-control-sm']) !!}' +
                        '</div>' +
					'</div>' +
					'<div class="col-md-2">' +
                        '<div class="form-group">' +
                            '{!! Form::text('city ', old("city"), ['placeholder ' => 'City ','class ' => 'form-control form-control-sm']) !!}' +
                        '</div>' +
					'</div>' +
					'<div class="col-md-2">' +
                        '<div class="form-group">' +
                            '{!! Form::text('zip ', old("zip"), ['placeholder ' => 'ZIP ','class ' => 'form-control form-control-sm', 'maxlength ' => '10 ', 'id' => 'zip']) !!}' +
                        '</div>' +
					'</div>' +
					'</div>');
			});
			// Add More School Fields
			$('.school_addmore').on('click', '.remove_schoolmore', function (e) {
				e.preventDefault();
				$(this).parent('div').parent('div').remove(); //Remove field html
			});
			$('.add_school_button').click(function (e) {
				$('.school_addmore').append('<div class="row">' +
					'<div class="col-md-2">&nbsp;</div>' +
					'<div class="col-md-3">' +
                        '<div class="form-group">' +
                            '{!! Form::text('emp_name ', old("emp_name"), ['placeholder ' => 'School Name ','class ' => 'form-control form-control-sm', 'maxlength ' => '30 ']) !!}' +
                        '</div>' +
					'</div>' +
					'<div class="col-md-offset-1 col-md-1">' +
					'    <a href="javascript:void(0)" class="btn btn-primary btn-sm remove_schoolmore add_button"><i class="fa fa-minus-circle"></i></a>' +
					'</div>' +
					'</div>');
			});
			// Add More Employee Fields
			$('.emp_addmore').on('click', '.remove_empmore', function (e) {
				e.preventDefault();
				$(this).parent('div').parent('div').remove(); //Remove field html
			});
			$('.add_emp_button').click(function (e) {
				$('.emp_addmore').append('<div class="row">' +
					'<div class="col-md-2">&nbsp;</div>' +
					'<div class="col-md-3">' +
                        '<div class="form-group">' +
                            '{!! Form::text('emp_name ', old("emp_name"), ['placeholder ' => 'Employee Name ','class ' => 'form-control form-control-sm', 'maxlength ' => '30 ']) !!}' +
                        '</div>' +
					'</div>' +
					'<div class="col-md-offset-1 col-md-1">' +
					'    <a href="javascript:void(0)" class="btn btn-primary btn-sm remove_empmore add_button"><i class="fa fa-minus-circle"></i></a>' +
					'</div>' +
					'</div>');
			});
			// Add More current Spouse Fields
			$('.spouse_addmore').on('click', '.remove_spousemore', function (e) {
				e.preventDefault();
				$(this).parent('div').parent('div').remove(); //Remove field html
			});
			$('.add_spouse_button').click(function (e) {
				$('.spouse_addmore').append('<div class="row">' +
					'<div class="col-md-2">&nbsp;</div>' +
					'<div class="col-md-2">' +
                        '<div class="form-group">' +
                            '{!! Form::text('spouse[first_name][] ', old("sp_first_name"), ['placeholder ' => 'First Name ','class ' => 'form-control form-control-sm', 'maxlength ' => '30 ']) !!}' +
                        '</div>' +
					'</div>' +
					'<div class="col-md-2">' +
                        '<div class="form-group">' +
                            '{!! Form::text('spouse[middle_name][] ', old("sp_middle_name"), ['placeholder ' => 'Middle Name ','class ' => 'form-control form-control-sm', 'maxlength ' => '30 ']) !!}' +
                        '</div>' +
					'</div>' +
					'<div class="col-md-2">' +
                        '<div class="form-group">' +
                            '{!! Form::text('spouse[last_name][] ', old("sp_last_name"), ['placeholder ' => 'Last Name ','class ' => 'form-control form-control-sm', 'maxlength ' => '30 ']) !!}' +
                        '</div>' +
					'</div>' +
					'<div class="col-md-2">' +
                        '<div class="form-group">' +
                            '{!! Form::text('spouse[maiden_name][] ', old("sp_maiden_name"), ['placeholder ' => 'Maiden Name ','class ' => 'form-control form-control-sm', 'maxlength ' => '30 ']) !!}' +
                        '</div>' +
					'</div>' +
					'<div class="col-md-1">' +
					    '<a href="javascript:void(0)" class="btn btn-primary btn-sm remove_spousemore add_button"><i class="fa fa-minus-circle"></i></a>' +
					'</div>' +
					'</div>');
			});
		});

    </script>

    <script>
		// $('#country').on('change', function () {
		// 	//			alert( this.value );
		// 	event.preventDefault();
		// 	$.ajax({
		// 		type: "POST",
		// 		headers: {
		// 			'X-CSRF-TOKEN': '{{ csrf_token() }}'
		// 		},
		// 		url: '{{ url("get-country-code") }}',
		// 		data: {
		// 			id: this.value
		// 		},
		// 		success: function (response) {
		// 			//					console.log('+'+response.phonecode);
		// 			$('#phone_code').val(response.phonecode);
		// 			$('#phone_locale').val(response.locale);
		// 		}
		// 	});
		// });

    </script>
@endsection
