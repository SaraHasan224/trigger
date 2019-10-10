@extends('layouts.admin')
@section('stylesheets')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ asset("admin/assets/vendors/datatables/datatables.bundle.css") }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset("admin/assets/vendors/iconfonts/mdi/css/materialdesignicons.css") }}">
<script type="text/javascript" src="//code.jquery.com/jquery-2.1.3.js"></script>
@endsection
@section('styles')
<style>
    .add_button {
        border-radius: 50px;
        width: 5px;
        height: 40px;
        margin-top: -5px;
    }

    .add_current_button {
        margin-bottom: 10px;
    }

    .header-fixed .t-header {
        z-index: 99 !important;
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
            <li class="breadcrumb-item active" aria-current="page">Claim Search</li>
        </ol>
    </nav>
</div>
<div class="content-viewport">
    @include("admin/includes/alerts")
    <div class="row">
        <div class="col-12">
            <div class="item-wrapper">
                {!! Form::open([ 'url' => route('personal-save')]) !!}
                <div class="row">
                    <div class="col-lg-12 equel-grid">
                        <div class="grid">
                            <div class="grid-header">
                                <div class="title"><i class="mdi mdi-account-search"></i>&nbsp;Claim Search
                                </div>
                                <div class="actions">
                                    <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                            <button type="submit" class="btn btn-success has-icon">
                                                <i class="fa fa-search"></i>Search
                                            </button>
                                            <button type="button"
                                                onClick="location.href='{{ route('admin-dashboard') }}'"
                                                class="btn btn-danger has-icon"><i class="fa fa-times"></i>Cancel
                                            </button>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-body">
                                <div class="item-wrapper">
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
                                                        {!! Form::text('first_name', old("first_name"),
                                                        ['placeholder' => 'First Name','class' =>
                                                        'form-control', 'maxlength' => '30']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-offset-1 col-md-3">
                                                    <div class="form-group">
                                                        {!! Form::text('middle_name', old("middle_name"),
                                                        ['placeholder' => 'Middle Name','class' =>
                                                        'form-control', 'maxlength' => '30']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-offset-1 col-md-3">
                                                    <div class="form-group">
                                                        {!! Form::text('last_name', old("last_name"),
                                                        ['placeholder' => 'Last Name','class' => 'form-control',
                                                        'maxlength' => '30']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- {{--Email Address--}} -->
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label> <i class="fa fa-inbox"></i> Email
                                                        Address: </label>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        {!! Form::text('p_email[]', old("p_email"),
                                                        ['placeholder' => 'Email Address','class' =>
                                                        'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        {!! Form::text('p_email[]', old("p_email"),
                                                        ['placeholder' => 'Email Address','class' =>
                                                        'form-control']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- {{--Current Address and Location--}} -->
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label> <i class="fa fa-map-marker"></i>
                                                        Current Address: </label>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        {!! Form::text('current_address',
                                                        old("current_address"), ['placeholder' => 'Street
                                                        Address','class' => 'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        {!! Form::select('p_country', $countries,
                                                        old("p_country"), ['class' => 'form-control',
                                                        'id'=>'country']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        {!! Form::text('p_state', old("p_state"), ['placeholder'
                                                        => 'State','class' => 'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        {!! Form::text('p_city', old("p_city"), ['placeholder'
                                                        => 'City','class' => 'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        {!! Form::text('p_zip', old("p_zip"), ['placeholder' =>
                                                        'ZIP','class' => 'form-control', 'maxlength' => '10'])
                                                        !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- {{--Phone Number--}} -->
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label> <i class="fa fa-phone-square"></i>
                                                        Phone Number: </label>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        {!! Form::tel('phone_number[]', old("phone_number0"),
                                                        ['placeholder' => 'Phone Number','class' =>
                                                        'form-control', 'id' => 'phone', 'maxlength' => '30'])
                                                        !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        {!! Form::text('phone_number[]', old("phone_number1"),
                                                        ['placeholder' => 'Phone Number','class' =>
                                                        'form-control', 'id' => 'phone_2', 'maxlength' => '30'])
                                                        !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        {!! Form::text('phone_number[]', old("phone_number2"),
                                                        ['placeholder' => 'Phone Number','class' =>
                                                        'form-control', 'id' => 'phone_3', 'maxlength' => '30'])
                                                        !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="phone_code" id="phone_code" value="" />
                                            <input type="hidden" name="phone_locale" id="phone_locale" value="" />
                                            
                                            <!-- {{--Social--}} -->
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label> <i class="fa fa-globe"></i> Social
                                                        Media Links: </label>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        {!! Form::text('username[]', old("username"),
                                                        ['placeholder' => 'Username','class' => 'form-control'])
                                                        !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        {!! Form::text('social_url[]', old("social_url"),
                                                        ['placeholder' => 'Site Link','class' =>
                                                        'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        {!! Form::select('site[]', $social, old("site"),
                                                        ['class' => 'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-default add_social_button add_button"><i
                                                            class="fa fa-plus-square"></i></a>
                                                </div>
                                            </div>
                                            <div class="social_addmore"></div>
                                            <!-- {{--Birth Date--}} -->
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label> <i class="mdi mdi-cake"></i> Birth
                                                        Date: </label>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        {!! Form::text('birth_date', old("birth_date"),
                                                        ['placeholder' => 'Date of Birth','class' =>
                                                        'form-control']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- {{--Employer--}} -->
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label> <i class="fa fa-suitcase"></i>
                                                        Current Employer: </label>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        {!! Form::text('emp_cmp_name', old("emp_cmp_name"),
                                                        ['placeholder' => 'Company Name','class' =>
                                                        'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        {!! Form::text('job_title', old("job_title"),
                                                        ['placeholder' => 'Job Title','class' =>
                                                        'form-control']) !!}
                                                    </div>
                                                </div>
                                                <!--    <div class="col-md-1">
                                                                            <a href="javascript:void(0)"
                                                                               class="btn btn-default add_emp_button add_button"><i
                                                                                        class="fa fa-plus-square"></i></a>
                                                                        </div> -->
                                            </div>
                                            <div class="emp_addmore"></div>
                                            <!-- {{--Claim Information--}} -->
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label><i class="fa fa-search"></i> Claim Information: </label>
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="form-group">
                                                        {!! Form::text('search', old("search"), ['placeholder'=> 'Enter any comments you want to save within search','class' => 'form-control', 'maxlength' => '30'])!!}
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- {{--Other Information--}} -->
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label><i class="fa fa-search"></i> Other Information: </label>
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="form-group">
                                                        {!! Form::text('search', old("search"), ['placeholder'=> 'Enter any comments you want to save within search','class' => 'form-control', 'maxlength' => '30']) !!}
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
                <div class="row" style="display:none;">
                    <div class="col-lg-12 equel-grid">
                        <div class="grid">
                            <div class="grid-header">
                                <div class="title"><i class="fa fa-cogs"></i>&nbsp;Internal
                                    Controls
                                </div>
                            </div>
                            <div class="grid-body">
                                <div class="item-wrapper">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            {{--Schema--}}
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label> <i class="fa fa-user"></i> Schema:
                                                    </label>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        {!! Form::select('schema', $countries,old("business_country"), ['class' => 'form-control my-select', 'id' => 'SideID1']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Source Options--}}
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label style="font-weight: 900;">Source
                                                        Options </label>
                                                </div>
                                            </div>
                                            <div class="grid-body" style="border:2px solid #e8e8e8;">
                                                <div class="item-wrapper">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label class="radio-label"
                                                                style="font-style: italic;">Sources
                                                                : <span>check / uncheck</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    {{-- Source Options Checkboxes--}}
                                                    <div class="grid-body" style="border:2px solid #e8e8e8;">
                                                        <div class="item-wrapper">
                                                            <div class="row">
                                                                <div class="col-lg-2">
                                                                    <div class="form-group">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox"
                                                                                    class="form-check-input">
                                                                                Default <i class="input-frame"></i>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <div class="form-group">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox"
                                                                                    class="form-check-input" checked="">
                                                                                Checked <i class="input-frame"></i>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <div class="form-group">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox"
                                                                                    class="form-check-input">
                                                                                Default <i class="input-frame"></i>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <div class="form-group">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox"
                                                                                    class="form-check-input" checked="">
                                                                                Checked <i class="input-frame"></i>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <div class="form-group">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox"
                                                                                    class="form-check-input">
                                                                                Default <i class="input-frame"></i>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <div class="form-group">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox"
                                                                                    class="form-check-input" checked="">
                                                                                Checked <i class="input-frame"></i>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-2">
                                                                    <div class="form-group">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox"
                                                                                    class="form-check-input">
                                                                                Default <i class="input-frame"></i>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <div class="form-group">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox"
                                                                                    class="form-check-input" checked="">
                                                                                Checked <i class="input-frame"></i>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <div class="form-group">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox"
                                                                                    class="form-check-input">
                                                                                Default <i class="input-frame"></i>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <div class="form-group">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox"
                                                                                    class="form-check-input" checked="">
                                                                                Checked <i class="input-frame"></i>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <div class="form-group">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox"
                                                                                    class="form-check-input">
                                                                                Default <i class="input-frame"></i>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <div class="form-group">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox"
                                                                                    class="form-check-input" checked="">
                                                                                Checked <i class="input-frame"></i>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-2">
                                                                    <div class="form-group">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox"
                                                                                    class="form-check-input">
                                                                                Default <i class="input-frame"></i>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <div class="form-group">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox"
                                                                                    class="form-check-input" checked="">
                                                                                Checked <i class="input-frame"></i>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <div class="form-group">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox"
                                                                                    class="form-check-input">
                                                                                Default <i class="input-frame"></i>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <div class="form-group">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox"
                                                                                    class="form-check-input" checked="">
                                                                                Checked <i class="input-frame"></i>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <div class="form-group">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox"
                                                                                    class="form-check-input">
                                                                                Default <i class="input-frame"></i>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <div class="form-group">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox"
                                                                                    class="form-check-input" checked="">
                                                                                Checked <i class="input-frame"></i>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="item-wrapper">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input type="checkbox"
                                                                                class="form-check-input">
                                                                            Perform Cached
                                                                            Search <i class="input-frame"></i>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input type="checkbox"
                                                                                class="form-check-input">
                                                                            Perform Fast Search
                                                                            <i class="input-frame"></i>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="item-wrapper">
                                                        <!-- Product -->
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label> Product: </label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    {!! Form::select('product_type',
                                                                    $product_type, old("product_type"), ['class'
                                                                    => 'form-control']) !!}
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
                                                                    {!! Form::select('rate_set', $rate_set,
                                                                    old("rate_set"), ['class' =>
                                                                    'form-control']) !!}
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
                                                                    {!! Form::select('risk_char_comp',
                                                                    $risk_char_comp, old("risk_char_comp"),
                                                                    ['class' => 'form-control']) !!}
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
                        </div>
                    </div>
                </div>
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
                    <img src="{{asset('admin/search.gif')}}" style="width: 200px; height: 200px;" />
                    <h4 class="text-black font-weight-medium mb-4">Searching Social Networks...</h4>
                </div>
                <div class="progress" style="height: 35px !important;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60"
                        aria-valuemin="0" aria-valuemax="100">Piple.com</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-link text-black component-flat"
                    data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-sm">Done</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js_plugins')
@endsection
@section('javascripts')
<script language="javascript">
    Globals["urlList"] = '{{ route("user-get-list") }}';
    Globals["urlUpdateStatus"] = '{{ route("user-update-status") }}';
    Globals["disableOrderColumns"] = [0, 8];
    Globals["dtDom"] = "lfrtip";
    Globals["defaultOrderColumns"] = [
        [1, "asc"]
    ];

</script>
<script>
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
                '    <div class="form-group">' +
                '               {!! Form::text("a_first_name", old("a_first_name"), ['
                placeholder ' => '
                First Name ',"class" => "form-control", "maxlength" => "30"]) !!}' +
                '    </div>' +
                '</div>' +
                '<div class="col-md-offset-1 col-md-3">' +
                '    <div class="form-group">' +
                '               {!! Form::text("a_middle_name", old("a_middle_name"), ['
                placeholder ' => '
                Middle Name ',"class" => "form-control", "maxlength" => "30"]) !!}' +
                '    </div>' +
                '</div>' +
                '<div class="col-md-offset-1 col-md-3">' +
                '    <div class="form-group">' +
                '                {!! Form::text("a_last_name", old("a_last_name"), ['
                placeholder ' => '
                Last Name ',"class" => "form-control", "maxlength" => "30"]) !!}' +
                '    </div>' +
                '</div>' +
                '<div class="col-md-offset-1 col-md-1">' +
                '    <a href="javascript:void(0)" class="btn btn-default remove_addmore add_button"><i class="fa fa-minus-circle"></i></a>' +
                '</div>' +
                '</div>');
        });
        // Add More Email Address Fields
        $('.email_addmore').on('click', '.remove_emailaddmore', function (e) {
            e.preventDefault();
            $(this).parent('div').parent('div').remove(); //Remove field html
        });
        $('.add_email_button').click(function (e) {
            $('.email_addmore').append('<div class="row"><div class="col-md-2">&nbsp;</div>' +
                '<div class="col-md-4">' +
                '<div class="form-group">' +
                '{!! Form::text('
                p_email[]
                ', old("email"), ['
                placeholder ' => '
                Email Address ','
                class ' => '
                form - control ']) !!}' +
                '</div>' +
                '</div>' +
                '<div class="col-md-1">' +
                '<a href="javascript:void(0)" class="btn btn-default remove_emailaddmore add_button"><i class="fa fa-minus-circle"></i></a>' +
                '</div></div>');
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
                '{!! Form::text('
                username[]
                ', old("username"), ['
                placeholder ' => '
                Username ','
                class ' => '
                form - control ']) !!}' +
                '</div>' +
                '</div>' +
                '<div class="col-md-3">' +
                '<div class="form-group">' +
                '{!! Form::text('
                social_url[]
                ', old("social_url"), ['
                placeholder ' => '
                Site Link ','
                class ' => '
                form - control ']) !!}' +
                '</div>' +
                '</div>' +
                '<div class="col-md-3">' +
                '<div class="form-group">' +
                '{!! Form::select('
                site[]
                ', $social, old("site"), ['
                class ' => '
                form - control ']) !!}' +
                '</div>' +
                '</div>' +
                '<div class="col-md-offset-1 col-md-1">' +
                '    <a href="javascript:void(0)" class="btn btn-default remove_socialmore add_button"><i class="fa fa-minus-circle"></i></a>' +
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
                '<a href="javascript:void(0)" class="btn btn-default remove_currentmore add_button"><i class="fa fa-minus-circle"></i></a>' +
                '</div>' +
                '<div class="col-md-2">' +
                '<div class="form-group">' +
                '{!! Form::text('
                current_address ', old("current_address"), ['
                placeholder ' => '
                Street Address ','
                class ' => '
                form - control ']) !!}' +
                '</div>' +
                ' </div>' +
                '<div class="col-md-2">' +
                '<div class="form-group">' +
                '{!! Form::select('
                p_country ', $countries, old("p_country"), ['
                class ' => '
                form - control my - select ']) !!}' +
                '</div>' +
                '</div>' +
                '<div class="col-md-2">' +
                '<div class="form-group">' +
                '{!! Form::text('
                state ', old("state"), ['
                placeholder ' => '
                State ','
                class ' => '
                form - control ']) !!}' +
                '</div>' +
                '</div>' +
                '<div class="col-md-2">' +
                '<div class="form-group">' +
                '{!! Form::text('
                city ', old("city"), ['
                placeholder ' => '
                City ','
                class ' => '
                form - control ']) !!}' +
                '</div>' +
                '</div>' +
                '<div class="col-md-2">' +
                '<div class="form-group">' +
                '{!! Form::text('
                zip ', old("zip"), ['
                placeholder ' => '
                ZIP ','
                class ' => '
                form - control ', '
                maxlength ' => '
                10 ']) !!}' +
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
                '{!! Form::text('
                emp_name ', old("emp_name"), ['
                placeholder ' => '
                School Name ','
                class ' => '
                form - control ', '
                maxlength ' => '
                30 ']) !!}' +
                '</div>' +
                '</div>' +
                '<div class="col-md-offset-1 col-md-1">' +
                '    <a href="javascript:void(0)" class="btn btn-default remove_schoolmore add_button"><i class="fa fa-minus-circle"></i></a>' +
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
                '{!! Form::text('
                emp_name ', old("emp_name"), ['
                placeholder ' => '
                Employee Name ','
                class ' => '
                form - control ', '
                maxlength ' => '
                30 ']) !!}' +
                '</div>' +
                '</div>' +
                '<div class="col-md-offset-1 col-md-1">' +
                '    <a href="javascript:void(0)" class="btn btn-default remove_empmore add_button"><i class="fa fa-minus-circle"></i></a>' +
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
                '{!! Form::text('
                name ', old("name"), ['
                placeholder ' => '
                First Name ','
                class ' => '
                form - control ', '
                maxlength ' => '
                30 ']) !!}' +
                '</div>' +
                '</div>' +
                '<div class="col-md-2">' +
                '<div class="form-group">' +
                '{!! Form::text('
                name ', old("name"), ['
                placeholder ' => '
                Middle Name ','
                class ' => '
                form - control ', '
                maxlength ' => '
                30 ']) !!}' +
                '</div>' +
                '</div>' +
                '<div class="col-md-2">' +
                '<div class="form-group">' +
                '{!! Form::text('
                name ', old("name"), ['
                placeholder ' => '
                Last Name ','
                class ' => '
                form - control ', '
                maxlength ' => '
                30 ']) !!}' +
                '</div>' +
                '</div>' +
                '<div class="col-md-2">' +
                '<div class="form-group">' +
                '{!! Form::text('
                name ', old("name"), ['
                placeholder ' => '
                Maiden Name ','
                class ' => '
                form - control ', '
                maxlength ' => '
                30 ']) !!}' +
                '</div>' +
                '</div>' +
                '<div class="col-md-1">' +
                '<a href="javascript:void(0)" class="btn btn-default remove_spousemore add_button"><i class="fa fa-minus-circle"></i></a>' +
                '</div>' +
                '</div>');
        });
    });

</script>

<script>
    //  Bussiness Workbench
    $(document).ready(function () {
        // Add Business Principle Field
        $('.business_principle_append').on('click', '.remove_business_principle_append', function (e) {
            e.preventDefault();
            $(this).parent('div').parent('div').remove(); //Remove field html
        });
        $('.add_business_principle_button').click(function (e) {
            $('.business_principle_append').append('<div class="row">' +
                '<div class="col-md-2">&nbsp;</div>' +
                '<div class="col-md-8">' +
                '<div class="form-group">' +
                '{!! Form::text('
                business_principle ', old("business_principle"), ['
                placeholder ' => '
                Principle ','
                class ' => '
                form - control ']) !!}' +
                '</div>' +
                '</div>' +
                '<div class="col-md-offset-1 col-md-1">' +
                '    <a href="javascript:void(0)" class="btn btn-default remove_business_principle_append add_button"><i class="fa fa-minus-circle"></i></a>' +
                '</div>' +
                '</div>');
        });
    });

</script>


<script>
    $('#country').on('change', function () {
        //			alert( this.value );
        event.preventDefault();
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            url: '{{ url("get-country-code") }}',
            data: {
                id: this.value
            },
            success: function (response) {
                //					console.log('+'+response.phonecode);
                $('#phone_code').val(response.phonecode);
                $('#phone_locale').val(response.locale);
            }
        });
    });

</script>
@endsection
