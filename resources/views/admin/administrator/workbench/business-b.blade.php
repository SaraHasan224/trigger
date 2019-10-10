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
            <li class="breadcrumb-item">
                <a href="javascript:;">Workbench</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Business Search</li>
        </ol>
    </nav>
</div>
<div class="content-viewport">
    @include("admin/includes/alerts")
    <div class="row">
        <div class="col-12">
            {!! Form::open([ 'url' => route('business-save')]) !!}
            <div class="row">
                <div class="col-lg-12 equel-grid">
                    <div class="grid">
                        <div class="grid-header">
                            <div class="title"><i class="mdi mdi-inbox-multiple"></i>&nbsp;Business
                                Workbench
                            </div>
                            <div class="actions">
                                <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                    <button type="button" class="btn btn-success WorkbenchModel" data-toggle="modal"
                                        data-target="#WorkbenchModel"> Modal </button>
                                    <a href="{{route('business-result')}}">Result</a>
                                        <button type="submit" class="btn btn-success has-icon">
                                            <i class="fa fa-save"></i>Save
                                        </button>
                                        <button type="button" onClick="location.href='{{ route("user-list") }}'"
                                            class="btn btn-danger has-icon"><i class="fa fa-times"></i>Cancel
                                        </button>
                                </div>
                            </div>
                        </div>
                        <div class="grid-body">
                            <div class="item-wrapper">
                                <div class="row">
                                    <div class="col-lg-12">
                                        {{--Business Name--}}
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label> <i class="fa fa-building-o"></i>
                                                    Business Name: </label>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {!! Form::text('business_name', old("business_name"), ['placeholder'
                                                    => 'Business Name','class' => 'form-control', 'maxlength' => '30'])
                                                    !!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {!! Form::select('business_country', $countries,
                                                    old("business_country"), ['class' => 'form-control my-select', 'id'
                                                    => 'SideID1']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        {{--Business Address--}}
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label> <i class="fa fa-address-card-o"></i>
                                                    Business Address: </label>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {!! Form::text('street_address', old("street_address"),
                                                    ['placeholder' => 'Street Address','class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {!! Form::text('b_city', old("b_city"), ['placeholder' =>
                                                    'City','class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {!! Form::text('b_state', old("b_state"), ['placeholder' =>
                                                    'State','class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    {!! Form::text('b_zip', old("b_zip"), ['placeholder' =>
                                                    'ZIP','class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    {!! Form::text('b_phone', old("b_phone"), ['placeholder' => 'Phone
                                                    Number','class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        {{--Business Email--}}
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>
                                                    <i class="mdi mdi-message-outline mdi-1x"></i>
                                                    Business Email : </label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    {!! Form::text('business_email', old("business_email"),
                                                    ['placeholder' => 'Business Email','class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        {{--Business Website--}}
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label> <i class="fa fa-globe"></i> Business
                                                    Website: </label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    {!! Form::text('business_website', old("business_website"),
                                                    ['placeholder' => 'Business Website','class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        {{--Claim Information--}}
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>
                                                    <i class="fa fa-exclamation-circle"></i>
                                                    Claim Information: </label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    {!! Form::text('business_claim_info', old("business_claim_info"),
                                                    ['placeholder' => 'Claim Information','class' => 'form-control'])
                                                    !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="business_clain_info_append"></div>
                                        {{--Principle--}}
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>
                                                    <i class="fa fa-question-circle"></i>
                                                    Principle: </label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    {!! Form::text('business_principle', old("business_principle"),
                                                    ['placeholder' => 'Principle','class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-default add_business_principle_button add_button"><i
                                                        class="fa fa-plus-square"></i></a>
                                            </div>
                                        </div>
                                        <div class="business_principle_append"></div>
                                        {{--Search Comments--}}
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label> <i class="fa fa-search"></i> Search
                                                    Comments: </label>
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
                                                <label> <i class="fa fa-signal"></i> Risk
                                                    Characterstics: </label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    {!! Form::text('business_risk_characterstics',old("business_risk_characterstics"), ['placeholder' => 'Risk Characterstics','class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        {{--Employer--}}
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label> <i class="fa fa-sort-alpha-asc"></i>
                                                    Index Segment: </label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    {!! Form::text('business_index_segment',old("business_index_segment"), ['placeholder' => 'Index Segment','class' => 'form-control', 'maxlength' => '30']) !!}
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
                    '{!! Form::text("business_principle", old("business_principle"), ["placeholder" => "Principle","class" => "form-control"]) !!}' +
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
