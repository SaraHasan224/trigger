@extends('layouts.admin')
@section('stylesheets')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset("admin/assets/vendors/datatables/datatables.bundle.css") }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset("admin/assets/vendors/iconfonts/mdi/css/materialdesignicons.css") }}">
    <link rel="stylesheet" href="{{ asset("admin/assets/vendors/iconfonts/flag-icon-css/css/flag-icon.css") }}">
@endsection
@section('styles')
    <style>
        .add_button {
            border-radius: 50px;
            width: 5px;
            height: 40px;
            margin-top: -5px;
        }
        .add_button i{
            font-size: 1.02rem;
        }
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
                <li class="breadcrumb-item active" aria-current="page">New Business Search</li>
            </ol>
        </nav>
    </div>
    <div class="content-viewport">
        @include("admin/includes/alerts")
            <div class="row">
                <div class="col-12">
                    <div class="item-wrapper">
                        {!! Form::open([ 'url' => route('business-save')]) !!}
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
                                                                <button type="button"  onClick="location.href='{{ route('business-result') }}'"
                                                                        class="btn btn-danger btn-lg has-icon">Result
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Personal Workbench -->
                                                    <div class="custom-head">
                                                        <label>Business Workbench </label>
                                                    </div> 
                                                    <div class="grid-body">
                                                        <div class="item-wrapper">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    {{--Business Name--}}
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                            <label> <i class="fa fa-building-o"></i> Business Name: </label>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                {!! Form::text('business_name', old("business_name"), ['placeholder' => 'Business Name','class' => 'form-control', 'maxlength' => '30']) !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="input-group mb-3">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon1"><img src="{{ asset('admin/country-flag/us.png')}}"></span>
                                                                                </div>
                                                                                {!! Form::text('business_country', "United States", ['class' => 'form-control', 'id' => 'SideID4', 'disabled' => 'disabled']) !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    {{--Business Address--}}
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                            <label> <i class="fa fa-address-card-o"></i> Business Address: </label>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="form-group">
                                                                                {!! Form::text('street_address', old("street_address"), ['placeholder' => 'Street Address','class' => 'form-control']) !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="form-group">
                                                                                {!! Form::text('b_city', old("b_city"), ['placeholder' => 'City','class' => 'form-control']) !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="form-group">
                                                                                {!! Form::text('b_state', old("b_state"), ['placeholder' => 'State','class' => 'form-control']) !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <div class="form-group">
                                                                                {!! Form::text('b_zip', old("b_zip"), ['placeholder' =>'ZIP','class' => 'form-control']) !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="input-group mb-3">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon1">+1</span>
                                                                                </div>
                                                                                {!! Form::text('b_phone', old("b_phone"), ['placeholder' => 'Phone Number','class' => 'form-control']) !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    {{--Business Email--}}
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                            <label> <i class="mdi mdi-message-outline mdi-1x"></i>  Business Email : </label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <div class="form-group">
                                                                                {!! Form::text('business_email', old("business_email"), ['placeholder' => 'Business Email','class' => 'form-control']) !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    {{--Business Website--}}
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                            <label> <i class="fa fa-globe"></i> Business Website: </label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <div class="input-group mb-3">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon1">www.</span>
                                                                                </div>
                                                                                {!! Form::text('business_website', old("business_website"), ['placeholder' => 'Business Website','class' => 'form-control']) !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    {{--Claim Information--}}
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                            <label> <i class="fa fa-exclamation-circle"></i> Claim Information: </label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <div class="form-group">
                                                                                {!! Form::text('business_claim_info', old("business_claim_info"), ['placeholder' => 'Claim Information','class' => 'form-control']) !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="business_clain_info_append"></div>
                                                                    {{--Principle--}}
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                            <label> <i class="fa fa-question-circle"></i> Principle: </label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <div class="form-group">
                                                                                {!! Form::text('business_principle', old("business_principle"), ['placeholder' => 'Principle','class' => 'form-control']) !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <a href="javascript:void(0)" class="btn btn-default add_business_principle_button add_button"><i class="fa fa-plus-square"></i></a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="business_principle_append"></div>
                                                                    {{--Search Comments--}}
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                            <label> <i class="fa fa-search"></i> Search Comments: </label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <div class="form-group">
                                                                                {!! Form::text('business_search_comments',old("business_search_comments"), ['placeholder' => 'Search Comments','class' => 'form-control']) !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    {{--School--}}
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                            <label> <i class="fa fa-signal"></i> Risk Characterstics: </label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <div class="form-group">
                                                                                {!! Form::select('business_risk_characterstics', $risk_char, old("business_risk_characterstics"), ['class' => 'form-control my-select', 'id' => 'SideID3']) !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    {{--Employer--}}
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                            <label> <i class="fa fa-sort-alpha-asc"></i> Index Segment: </label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <div class="form-group">
                                                                                {!! Form::select('business_index_segment', $index_seg, old("business_index_segment"), ['class' => 'form-control my-select', 'id' => 'SideID1']) !!}
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
                                                    <div class="row">                      
                                                        <div class="grid-body" >
                                                                <div class="item-wrapper" style="border:2px solid #e8e8e8; padding:20px;">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            {{--Schema--}}
                                                                            <div class="row">
                                                                                <div class="col-md-2">
                                                                                    <label> <i class="fa fa-user"></i> Schema:</label>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        {!! Form::select('schema', $schema, old("schema"), ['class' => 'form-control form-control-sm my-select', 'id' => 'SideID2']) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            {{-- Source Options--}}
                                                                            <div class="row">
                                                                                <div class="col-md-2">
                                                                                    <label style="font-weight: 900;">Source Options </label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="grid-body" style="border:2px solid #e8e8e8;">
                                                                                <div class="item-wrapper">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <label class="radio-label"
                                                                                                style="font-style: italic;">Sources : <span>check / uncheck</span>
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                    {{-- Source Options Checkboxes--}}
                                                                                    <div class="grid-body" style="border:2px solid #e8e8e8;">
                                                                                        <div class="item-wrapper">
                                                                                            <div class="row">
                                                                                                @foreach($source_opt as $key)
                                                                                                <div class="col-lg-2">
                                                                                                    <div class="form-group">
                                                                                                        <div class="checkbox">
                                                                                                            <label>
                                                                                                                <input type="checkbox" class="form-check-input"> {{$key}} <i class="input-frame"></i>
                                                                                                            </label>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                @endforeach
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="item-wrapper" style="margin-top: 20px;">
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
                                                                                    <div class="item-wrapper">
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
                                                                                        {{--Custom Search String Legend--}}

                                                                                        <div class="row">
                                                                                            <div class="col-md-3    ">
                                                                                                        <div class="custom-margin">
                                                                                                            <label>Custom Search String Legend </label>
                                                                                                            {!! Form::text('custom_f_name', old("custom_b_name"),['placeholder' => '[business_name]','class' => 'form-control form-control-sm','maxlength' => '30']) !!}
                                                                                                            {!! Form::text('custom_m_name', old("custom_industry_name"),['placeholder' => '[industry]','class' => 'form-control form-control-sm','maxlength' => '30']) !!}
                                                                                                            {!! Form::text('custom_l_name', old("custom_email"),['placeholder' => '[email]','class' => 'form-control form-control-sm','maxlength' => '30']) !!}
                                                                                                            {!! Form::text('custom_dob', old("custom_web"),['placeholder' => '[website]','class' => 'form-control form-control-sm','maxlength' => '30']) !!}
                                                                                                            {!! Form::text('custom_mail', old("custom_web"),['placeholder' => '[business_location.0.street]','class' => 'form-control form-control-sm']) !!}
                                                                                                            {!! Form::text('custom_num', old("custom_num"),['placeholder' => '[business_location.0.city]','class' => 'form-control form-control-sm']) !!}
                                                                                                            {!! Form::text('custom_u_name', old("custom_u_name"),['placeholder' => '[business_location.0.state]','class' => 'form-control form-control-sm']) !!}
                                                                                                            {!! Form::text('custom_street', old("custom_street"),['placeholder' => '[business_location.0.zip]','class' => 'form-control form-control-sm']) !!}
                                                                                                            {!! Form::text('custom_city', old("custom_city"),['placeholder' => '[business_location.0.phone]','class' => 'form-control form-control-sm']) !!}
                                                                                                            {!! Form::text('custom_state', old("custom_state"),['placeholder' => '[principle.0.first_name]','class' => 'form-control form-control-sm']) !!}
                                                                                                            {!! Form::text('custom_zip', old("custom_zip"),['placeholder' => '[principle.0.middle_name]','class' => 'form-control form-control-sm']) !!}
                                                                                                            {!! Form::text('custom_ins_name', old("custom_ins_name"),['placeholder' => '[principle.0.last_name]','class' => 'form-control form-control-sm']) !!}
                                                                                                            {!! Form::text('custom_ins_name', old("custom_ins_name"),['placeholder' => '[principle.0.email]','class' => 'form-control form-control-sm']) !!}
                                                                                                        </div>
                                                                                                    </div>
                                                                                            <div class="col-md-9">

                                                                                                <div class="custom-margin2">
                                                                                                    <label>Bing Busines Address (use placeholder)</label>
                                                                                                    {!! Form::text('custom_f_name_param', old("custom_f_name_param"),['placeholder' => '("[business_name]") "[business_location.0.city]"','class' => 'form-control form-control-sm']) !!}
                                                                                                    <label>Bing Busines Address 1 (use placeholder)</label>
                                                                                                    {!! Form::text('custom_m_name_param', old("custom_m_name_param"),['placeholder' => '("[business_name]") "[business_location.0.city]" [business_location.0.state] [business_location.0.zip]','class' => 'form-control form-control-sm']) !!}
                                                                                                    <label>Bing Busines Address 2 (use placeholder)</label>
                                                                                                    {!! Form::text('custom_l_name_param', old("custom_l_name_param"),['placeholder' => '("[business_name]") "[business_location.0.street]" [business_location.0.city] [business_location.0.state]','class' => 'form-control form-control-sm']) !!}
                                                                                                    <label>Bing Busines Email (use placeholder)</label>
                                                                                                    {!! Form::text('custom_dob_param', old("custom_dob_param"),['placeholder' => '"[email]"','class' => 'form-control form-control-sm']) !!}
                                                                                                    <label>Bing Busines Name (use placeholder)</label>
                                                                                                    {!! Form::text('custom_mail_param', old("custom_mail_param"),['placeholder' => '("[business_name]")','class' => 'form-control form-control-sm']) !!}
                                                                                                    <label>Bing Busines Name Address (use placeholder)</label>
                                                                                                    {!! Form::text('custom_num_param', old("custom_num_param"),['placeholder' => '("[business_name]") [business_location.0.street] [business_location.0.city] [business_location.0.state]','class' => 'form-control form-control-sm']) !!}
                                                                                                    <label>Bing Busines Name Industry (use placeholder)</label>
                                                                                                    {!! Form::text('custom_street_param', old("custom_street_param"),['placeholder' => '("[business_name]") [industry]','class' => 'form-control form-control-sm']) !!}
                                                                                                    <label>Bing Busines Phone (use placeholder)</label>
                                                                                                    {!! Form::text('custom_city_param', old("custom_city_param"),['placeholder' => '"[business_location.0.phone]"','class' => 'form-control form-control-sm']) !!}
                                                                                                    <label>Bing Busines Ticker  (use placeholder)</label>
                                                                                                    {!! Form::text('custom_state_param', old("custom_state_param"),['placeholder' => '("[email]")','class' => 'form-control form-control-sm']) !!}
                                                                                                    <label>Bing Busines Website  (use placeholder)</label>
                                                                                                    {!! Form::text('custom_state_param', old("custom_state_param"),['placeholder' => 'site:[website]','class' => 'form-control form-control-sm']) !!}
                                                                                                    <label>Google Custom Business  (use placeholder)</label>
                                                                                                    {!! Form::text('custom_state_param', old("custom_state_param"),['placeholder' => '([business_name])','class' => 'form-control form-control-sm']) !!}
                                                                                                    <label>Google Custom Business Address 1  (use placeholder)</label>
                                                                                                    {!! Form::text('custom_state_param', old("custom_state_param"),['placeholder' => '([business_name]) AND "[business_location.0.city]','class' => 'form-control form-control-sm']) !!}
                                                                                                    <label>Google Custom Business Address 2  (use placeholder)</label>
                                                                                                    {!! Form::text('custom_state_param', old("custom_state_param"),['placeholder' => '([business_name]) AND "[business_location.0.zip]"','class' => 'form-control form-control-sm']) !!}
                                                                                                    <label>Google Custom Business Address 3  (use placeholder)</label>
                                                                                                    {!! Form::text('custom_state_param', old("custom_state_param"),['placeholder' => '([business_name] AND [business_location.0.street][business_location.0.city][business_location.0.state])','class' => 'form-control form-control-sm']) !!}
                                                                                                    <label>Google Custom Business Email  (use placeholder)</label>
                                                                                                    {!! Form::text('custom_state_param', old("custom_state_param"),['placeholder' => '"[email]"','class' => 'form-control form-control-sm']) !!}
                                                                                                    <label>Google Custom Business Images  (use placeholder)</label>
                                                                                                    {!! Form::text('custom_state_param', old("custom_state_param"),['placeholder' => '"[business_name] "[business_location.0.city]"','class' => 'form-control form-control-sm']) !!}
                                                                                                    <label>Google Custom Business Phone  (use placeholder)</label>
                                                                                                    {!! Form::text('custom_state_param', old("custom_state_param"),['placeholder' => '"[business_location.0.phone]"','class' => 'form-control form-control-sm']) !!}
                                                                                                    <label>Google Custom Business Website  (use placeholder)</label>
                                                                                                    {!! Form::text('custom_state_param', old("custom_state_param"),['placeholder' => 'site:[website]','class' => 'form-control form-control-sm']) !!}
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
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                        <div class="grid-body">
                                                                <div class="item-wrapper">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            {{-- Report Options--}}
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
                                                        </div>
                                                    </div>
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
                                                            <button type="submit" class="btn btn-success btn-lg has-icon">
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
@endsection
@section('javascripts')
    <script>
		//  Personal Workbench
		$(document).ready(function () {
			$(document).on("click", ".WorkbenchModel", function () {
				//				alert ("oi");
				$("div").removeClass("modal-backdrop");
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
                            '{!! Form::text(' business_principle ', old("business_principle"), [' placeholder ' => 'Principle ','class ' => 'form-control form-control-sm']) !!}' +
                        '</div>' +
					'</div>' +
					'<div class="col-md-offset-1 col-md-1">' +
					'    <a href="javascript:void(0)" class="btn btn-default btn-sm remove_business_principle_append add_button"><i class="fa fa-minus-circle"></i></a>' +
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
