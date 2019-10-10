@extends('layouts.admin')
@section('stylesheets')
<link href="{{ asset("admin/assets/vendors/datatables/datatables.bundle.css") }}" rel="stylesheet" type="text/css" />
@endsection
@section('styles')
<style>
    .mapouter {
        position: relative;
        text-align: right;
        height: 300px;
        width: 290px;
        margin-bottom: -100px;
    }

    .gmap_canvas {
        overflow: hidden;
        background: none !important;
        height: 300px;
        width: 290px;
    }
    .table-bordered th{
        text-align: left !important;     
        white-space: normal;
    }
    .table-bordered td{
        text-align: left !important;     
        white-space: normal;
    }
    .time td{
        text-align: left !important;     
        white-space: normal;
    }
    .time td {
        padding: 0px;
        vertical-align: top;
        border-top: 1px solid #f2f4f9;
    }
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
            <li class="breadcrumb-item">
                <a href="{{ route("business-form") }}">Business Search</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Glassroots Icecream</li>
        </ol>
    </nav>
</div>
<div class="content-viewport">
    @include("admin/includes/alerts")
    <div class="email-wrapper grid">
        <div class="email-aside-list">
            <!-- Phone Number -->
            <div class="email-list-item">
                <div class="email-list-item-inner">
                    <div class="workbench-ico">
                        <i class="mdi mdi-phone"></i>
                    </div>
                    <div class="business-detail">
                        +1 860-653-6303
                    </div>
                </div>
            </div>
            <!-- Website -->
            <div class="email-list-item">
                <div class="email-list-item-inner">
                    <div class="workbench-ico">
                        <i class="mdi mdi-web"></i>
                    </div>
                    <div class="business-detail">
                        https://www.grassrootsicecream.com/
                    </div>
                </div>
            </div>
            <!-- Address -->
            <div class="email-list-item">
                <div class="email-list-item-inner">
                    <div class="workbench-ico">
                        <i class="mdi mdi-home-map-marker"></i>
                    </div>
                    <div class="business-detail">
                        On the Town Green, 4 Park Pl, Granby, CT 06035, USA
                    </div>
                </div>
            </div>
            <div class="email-list-item">
                <div class="row">
                    <div class="col-md-offset-4 col-md-4">
                        <div class="mapouter">
                            <div class="gmap_canvas">
                                <iframe width="290" height="200" id="gmap_canvas"
                                    src="https://maps.google.com/maps?q=clickysoft&t=&z=13&ie=UTF8&iwloc=&output=embed"
                                    frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Opening Timings -->
            <div class="email-list-item ">
                <div class="email-list-item-inner">
                    <div class="workbench-ico">
                        <i class="mdi mdi-clock"></i>
                    </div>
                    <div class="business-detail">
                        <div class="table-responsive">
                            <table class="table time">
                                <tbody>
                                    <tr><th>Sunday</th><td>Closed</td></tr>
                                    <tr><th>Monday</th><td>Open: 11am, Closed: 10pm</td></tr>
                                    <tr><th>Tuesday</th><td>Open: 11am, Closed: 10pm</td></tr>
                                    <tr><th>Wednesday</th><td>Open: 11am, Closed: 10pm</td></tr>
                                    <tr><th>Thursday</th><td>Open: 11am, Closed: 10pm</td></tr>
                                    <tr><th>Friday</th><td>Open: 11am, Closed: 10pm</td></tr>
                                    <tr><th>Saturday</th><td>Open: 11am, Closed: 10pm</td></tr>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- Ownership -->
            <div class="email-list-item">
                <div class="email-list-item-inner">
                    <div class="workbench-ico">
                        <i class="mdi mdi-information-outline"></i>
                    </div>
                    <div class="business-subject">URLs</div>
                    <div class="business-sub-detail">Private</div>
                </div>
            </div>
            <!-- Ownership -->
            <div class="email-list-item">
                <div class="email-list-item-inner">
                    <div class="workbench-ico">
                        <i class="mdi mdi-information-outline"></i>
                    </div>
                    <div class="business-subject">Ownership</div>
                    <div class="business-sub-detail">Private</div>
                </div>
            </div>
            <!-- SIC Code -->
            <div class="email-list-item">
                <div class="email-list-item-inner">
                    <div class="workbench-ico">
                        <i class="mdi mdi-information-outline"></i>
                    </div>
                    <div class="business-subject">SIC Code</div>
                    <div class="business-sub-detail">54</div>
                </div>
            </div>
            <!-- NAICS Code -->
            <div class="email-list-item">
                <div class="email-list-item-inner">
                    <div class="workbench-ico">
                        <i class="mdi mdi-information-outline"></i>
                    </div>
                    <div class="business-subject">NAICS Code</div>
                    <div class="business-sub-detail">72</div>
                </div>
            </div>
            <!-- Price Range -->
            <div class="email-list-item">
                <div class="email-list-item-inner">
                    <div class="workbench-ico">
                        <i class="mdi mdi-information-outline"></i>
                    </div>
                    <div class="business-subject">Price Range</div>
                    <div class="business-sub-detail">Inexpensive</div>
                </div>
            </div>
        </div>
        <div class="email-preview-wrapper">
            <div class="preview-header"> 
                <p class="business_heading"><i class="fa fa-building"></i>&nbsp;Glass Roots Icecream</p>
            </div>
            <div class="email-container">
                <div class="email-content">
                    <div class="item-wrapper">
                        <div id="sample-bar-chart" class="sample-chart"></div>
                    </div>
                </div>
                <div class="email-content">
                    <h2 class="grid-title">Trigger Data Scores</h2>
                        <div class="item-wrapper">
                            <div class="table-responsive">
                                <table class="table info-table table-bordered">
                                    <thead> 
                                        <tr>
                                            <th>Loss Propensity</th>
                                            <td colspan="5">4</td>
                                        </tr>
                                        <tr>
                                            <th>Categories</th>
                                            <td colspan="5">Ice cream, German Chocolate Cake, Sorbet, Unique Flavours, Grass Roots, Town Green, Birch Beer, Kiddie Cup, Grape Nut, Farmington Valley, Many Choices, Scoop, Oreo, Rosse, Chip, Gazebo, Blood, Sushi Bars, Thai, Chinese, Ice Cream & Frozen Yogurt, B2c, Consumer Staples</td>
                                        </tr>
                                        <tr>
                                            <th>Sector Categories</th>
                                            <td colspan="5">Consumer Staples</td>
                                        </tr>
                                        <tr>
                                            <th>Industry Categories</th>
                                            <td colspan="5">Food Products</td>
                                        </tr>
                                        <tr>
                                            <th>Site Title</th>
                                            <td colspan="5">Grassroots Ice Cream | Deep Roots Street Food | Granby,CT<</td>
                                        </tr>
                                        <tr>
                                            <th>Site Description</th>
                                            <td colspan="5">Under our roofs in Granby, CT find wickedly creative ice creams made with real food. And Deep Roots Street Food, a dine-in or take-out restaurant offering an ever-changing menu of global street food. Now offering online orders!</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>Lat:</th>
                                                <td>41.9534567</td>
                                            <th>Parking Lot:</th>
                                                <td>Yes</td>
                                            <th>Accept Credit Card:</th>
                                                <td>Yes</td>
                                        </tr>
                                        <tr>
                                            <th>Lng</th>
                                                <td>-72.7883896</td>
                                            <th>Bike Parking:</th>
                                                <td>Yes</td>
                                            <th>Liked By Vegetarians:</th>
                                                <td>Yes</td>
                                        </tr>
                                        <tr>
                                            <th>Wi-fi</th>
                                                <td>No</td>
                                            <th>Dogs Allowed:</th>
                                                <td>No</td>
                                            <th>Wheelchair Accessible:</th>
                                                <td>Yes</td>
                                        </tr>
                                        <tr>
                                            <th>Caters:</th>
                                            <td>Yes</td>
                                            <th>Street Parking:</th>
                                            <td>Yes</td>
                                            <th>Accepts Cryptocurrency:</th>
                                            <td>No</td>
                                        </tr>
                                        <tr>
                                            <th>Parking:</th>
                                                <td>Street, Private Lot</td>
                                            <th>Accepts Apple Pay:</th>
                                                <td>Yes</td>
                                            <th>Gender Neutral Restrooms:</th>
                                                <td>Yes</td>
                                        </tr>
                                        <tr>
                                            <th>Take-out:</th>
                                                <td>Yes</td>
                                            <th>Accepts Google Pay:</th>
                                                <td>No</td>
                                        </tr>
                                    </tbody>
                                </table> 
                            </div> 
                        </div> 
                </div>
            </div>
        </div>
    </div>
    <!-- Gonvernment & Employee Data -->
    <div class="row">
        <div class="col-lg-6 equel-grid">
            <div class="grid">
                <div class="grid-header">
                    <div class="title"><i class="mdi mdi-home"></i> &nbsp; Gonvernment Data</div>
                </div>
                <div class="grid-body">
                    <div class="item-wrapper">
                        <div class="row table-responsive">
                            <table class="table table-striped table-bordered table-hover table-checkable" id="dataList1">
                                <thead>
                                    <tr role="row" class="heading">
                                        <th><input type="checkbox" class="check-all"></th>
                                        <th>Webpage</th>
                                        <th>Category</th>
                                        <th>Data Matched</th>
                                        <th>Match</th>
                                        <th>Status</th>
                                        <th>Added</th>
                                        <th>Modified</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 equel-grid">
            <div class="grid">
                <div class="grid-header">
                    <div class="title"><i class="mdi mdi-worker"></i> &nbsp; Employee Data</div>
                </div>
                <div class="grid-body">
                    <div class="item-wrapper">
                        <div class="row table-responsive">
                            <table class="table table-striped table-bordered table-hover table-checkable" id="dataList2">
                                <thead>
                                    <tr role="row" class="heading">
                                        <th><input type="checkbox" class="check-all"></th>
                                        <th>Webpage</th>
                                        <th>Category</th>
                                        <th>Data Matched</th>
                                        <th>Match</th>
                                        <th>Status</th>
                                        <th>Added</th>
                                        <th>Modified</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Commercial Eligiblity -->
    <div class="row">
        <div class="col-lg-12 equel-grid">
            <div class="grid">
                <div class="grid-header">
                    <div class="title"><i class="mdi mdi-web"></i> &nbsp; Commercial Eligiblity</div>
                </div>
                <div class="grid-body">
                    <div class="item-wrapper">
                        <div class="email-aside-list">
                            <div class="email-list-item">
                                <div class="email-list-item-inner">
                                    <img class="workbech_site_img" src="http://www.placehold.it/50x50"
                                        alt="profile image">
                                    <p class="workbech_site_name">Link</p>
                                    <p class="workbech_site_name">Title</p>
                                    <p class="workbech_site_name">Preview</p>
                                    <div class="workbench-social-detail">
                                        <a href="https://www.linkedin.com/in/john-pagliaro-47b75258/" target="_blank">
                                            https://www.linkedin.com/in/john-pagliaro-47b75258/ </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Social -->
    <div class="row">
        <div class="col-lg-12 equel-grid">
            <div class="grid">
                <div class="grid-header">
                    <div class="title"><i class="fa fa-podcast"></i> &nbsp; Social</div>
                </div>
                <div class="grid-body">
                    <div class="item-wrapper">
                        <div class="email-aside-list">
                            <div class="email-list-item">
                                <div class="email-list-item-inner">
                                    <div class="business-social-head">
                                        <i class="mdi mdi-linkedin"></i> &nbsp Linkedin
                                    </div>
                                    <div class="business-social-detail">
                                        <div class="table-responsive">
                                            <table class="table time">
                                                <tbody>
                                                    <tr><th>Link: </th><td><a href="https://www.tripadvisor.com/Restaurant_Review-g33791-d6556342-Reviews-Grassroots_Ice_Cream-Granby_Connecticut.html" target="_blank">
                                                        https://www.tripadvisor.com/Restaurant_Review-g33791-d6556342-Reviews-Grassroots_Ice_Cream-Granby_Connecticut.html
                                                    </a></td></tr>
                                                    <tr><th>Title: </th><td>5.0/5.0</td></tr>
                                                    <tr><th>Popularity: </th><td>#1 of 2 Deserts in Granby</td></tr>
                                                    <tr><th>Review Counts: </th><td>83</td></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="email-list-item">
                                <div class="email-list-item-inner">
                                    <div class="business-social-head">
                                        <i class="mdi mdi-facebook"></i> &nbsp Facebook
                                    </div>
                                    <div class="business-social-detail">
                                        <div class="table-responsive">
                                            <table class="table time">
                                                <tbody>
                                                    <tr><th>Link: </th><td>
                                                    <a href="https://www.linkedin.com/in/john-pagliaro-47b75258/" target="_blank">
                                                        https://www.linkedin.com/in/john-pagliaro-47b75258/
                                                    </a></td></tr>
                                                </tbody>
                                            </table>
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
    <!-- Reviews -->
    <div class="row">
        <div class="col-lg-12 equel-grid">
            <div class="grid">
                <div class="grid-header">
                    <div class="title"><i class="mdi mdi-message-processing"></i> &nbsp; Reviews</div>
                </div>
                <div class="grid-body">
                    <table class="table table-striped table-bordered table-hover table-checkable" id="dataList">
                        <thead>
                            <tr role="row" class="heading">
                                <th><input type="checkbox" class="check-all"></th>
                                <th>Webpage</th>
                                <th>Category</th>
                                <th>Data Matched</th>
                                <th>Match</th>
                                <th>Status</th>
                                <th>Added</th>
                                <th>Modified</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Images -->
    <div class="row">
        <div class="col-lg-12 equel-grid">
            <div class="grid">
                <div class="grid-header">
                    <div class="title"><i class="mdi mdi-image-filter"></i> &nbsp; Images</div>
                </div>
                <div class="grid-body">
                    <div class="item-wrapper">
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-6">
                                <a href="#" class="d-block mb-4 h-100">
                                    <img class="img-fluid img-thumbnail"
                                        src="https://source.unsplash.com/pWkk7iiCoDM/400x300" alt="">
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-4 col-6">
                                <a href="#" class="d-block mb-4 h-100">
                                    <img class="img-fluid img-thumbnail"
                                        src="https://source.unsplash.com/aob0ukAYfuI/400x300" alt="">
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-4 col-6">
                                <a href="#" class="d-block mb-4 h-100">
                                    <img class="img-fluid img-thumbnail"
                                        src="https://source.unsplash.com/EUfxH-pze7s/400x300" alt="">
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-4 col-6">
                                <a href="#" class="d-block mb-4 h-100">
                                    <img class="img-fluid img-thumbnail"
                                        src="https://source.unsplash.com/M185_qYH8vg/400x300" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Risk Analysis -->
    <div class="row">
        <div class="col-lg-12 equel-grid">
            <div class="grid">
                <div class="grid-header">
                    <div class="title"><i class="mdi mdi-account-convert"></i> &nbsp; Risk Analysis</div>
                </div>
                <div class="grid-body">
                    <div class="row">
                        <div class="col-md-3"><i class="mdi mdi-label"></i> &nbsp; ALL</div>
                        <div class="col-md-3"><i class="mdi mdi-label"></i> &nbsp; CUSTOMER SENTIMENT</div>
                    </div>
                    <table class="table table-striped table-bordered table-hover table-checkable" id="dataList3">
                        <thead>
                            <tr role="row" class="heading">
                                <th><input type="checkbox" class="check-all"></th>
                                <th>URL</th>
                                <th>Matched By</th>
                                <th>Flagged Rules</th>
                                <th>Guidelines</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Web Results -->
    <div class="row">
        <div class="col-lg-12 equel-grid">
            <div class="grid">
                <div class="grid-header">
                    <div class="title"><i class="mdi mdi-cisco-webex"></i> &nbsp; Web Results</div>
                </div>
                <div class="grid-body">
                    <div class="row">
                        <div class="col-md-3"><i class="mdi mdi-label"></i> &nbsp; OTHERS</div>
                        <div class="col-md-3"><i class="mdi mdi-label"></i> &nbsp; NEWS & PRESS</div>
                        <div class="col-md-3"><i class="mdi mdi-label"></i> &nbsp; REVIEWS</div>
                        <div class="col-md-3"><i class="mdi mdi-label"></i> &nbsp; SOCIAL PRESENCE</div>
                    </div>
                    <div class="row" style="margin-bottom:50px;">
                        <div class="col-md-3"><i class="mdi mdi-label"></i> &nbsp; ALL</div>
                    </div>
                    <table class="table table-striped table-bordered table-hover table-checkable" id="dataList5">
                        <thead>
                            <tr role="row" class="heading">
                                <th><input type="checkbox" class="check-all"></th>
                                <th>Webpage</th>
                                <th>Category</th>
                                <th>Data Matched</th>
                                <th>Match</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js_plugins')
<script src="{{ url("public/vendor/laravel-filemanager/js/lfm.js") }}"></script>
<script src="https://cdn.anychart.com/releases/8.0.0/js/anychart-base.min.js"></script>
<script src="{{ asset("admin/assets/vendors/datatables/datatables.bundle.js") }}" type="text/javascript"></script>
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


    anychart.onDocumentReady(function() {

    // set the data
    var data = {
        header: ["Name", "Data Indexes"],
        rows: [
            ["Customer Review", 4.00],
            ["Health & Safety", 4.00],
            ["Property", 3.44],
            ["Reputation", 4.00],
            ["Visiblity", 3.16],
        ]};
        // create the chart
        var chart = anychart.bar();
        // add data
        chart.data(data);
        // set the chart title
        chart.title("Trigger Data Indexes");
        // draw
        chart.container("sample-bar-chart");
        chart.draw();
    });
</script>
<script src="{{ asset("admin/assets/scripts/datatable-instance.js") }}" type="text/javascript"></script>
@endsection
