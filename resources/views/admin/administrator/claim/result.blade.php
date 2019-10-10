@extends('layouts.admin')
@section('stylesheets')
<link href="{{ asset("admin/assets/vendors/datatables/datatables.bundle.css") }}" rel="stylesheet" type="text/css" />
@endsection
@section('styles')
<style>
    .mapouter {
        position: relative;
        text-align: right;
        height: 500px;
        width: 600px;
    }

    .gmap_canvas {
        overflow: hidden;
        background: none !important;
        height: 500px;
        width: 600px;
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
                <a href="javascript:;">Administrator</a>
            </li>
            <li class="breadcrumb-item">
                <a href="javascript:;">Workbench</a>
            </li>
            <li class="breadcrumb-item">
                <a href="javascript:;">Personal Search</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">John Pagliaro</li>
        </ol>
    </nav>
</div>
<div class="content-viewport">
    @include("admin/includes/alerts")
    <div class="email-wrapper grid">
        <div class="email-aside-list">
            <div class="email-list-item">
                <div class="row">
                    <div class="col-md-offset-4 col-md-4">
                        <img src="http://trigger.local/photos/1/Picture.jpg" class="workbench-img" alt="profile image">
                    </div>
                </div>
            </div>
            <!-- Gender -->
            <div class="email-list-item">
                <a href="#" class="email-list-item-inner">
                    <div class="workbench-ico">
                        <i class="mdi mdi-human-male-female"></i>
                    </div>
                    <div class="workbench-detail">Male</div>
                </a>
            </div>
            <!-- Phone Number -->
            <div class="email-list-item">
                <a href="#" class="email-list-item-inner">
                    <div class="workbench-ico">
                        <i class="mdi mdi-phone"></i>
                    </div>
                    <div class="workbench-detail">
                        860-987-2151
                        <br />
                        (413) 562-1107
                    </div>
                </a>
            </div>
            <!-- Email Address -->
            <div class="email-list-item">
                <a href="#" class="email-list-item-inner">
                    <div class="workbench-ico">
                        <i class="mdi mdi-email"></i>
                    </div>
                    <div class="workbench-detail">
                        jpagliarojr@comsat.net
                        <br />
                        jpagliaro@yoursummit.com
                    </div>
                </a>
            </div>
            <!-- Language -->
            <div class="email-list-item">
                <a href="#" class="email-list-item-inner">
                    <div class="workbench-ico">
                        <i class="fa fa-language"></i>
                    </div>
                    <div class="workbench-detail">
                        English
                    </div>
                </a>
            </div>
            <!-- Address -->
            <div class="email-list-item">
                <a href="#" class="email-list-item-inner">
                    <div class="workbench-ico">
                        <i class="mdi mdi-home-map-marker"></i>
                    </div>
                    <div class="workbench-detail">
                        49 Cider Mill Heights,North Granby, CT 06060
                        <br />
                        1244 Russel Road,Westfield, MA 01085
                    </div>
                </a>
            </div>
            <!--<div class="email-list-item">
                <a href="#" class="email-list-item-inner">
                    <img class="profile-img" src="http://www.placehold.it/50x50" alt="profile image">
                    <div class="date">15/6/2018</div>
                    <p class="user_name">Mike Cohen</p>
                    <p class="mail-text">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                </a>
            </div>-->
            <div class="email-list-item">
                <div class="mapouter">
                    <div class="gmap_canvas">
                        <iframe width="290" height="200" id="gmap_canvas"
                            src="https://maps.google.com/maps?q=clickysoft&t=&z=13&ie=UTF8&iwloc=&output=embed"
                            frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="email-preview-wrapper">
            <div class="preview-header">
                <p class="user_name">John Pagliaro</p>
                <a class="user-email" href="mailto:jpagliaro@yoursummit.com">jpagliaro@yoursummit.com</a>
                <a class="user-email" href="mailto:jpagliarojr@comsat.net">jpagliarojr@comsat.net</a>
                <p class="date">23/5/2018</p>
            </div>
            <div class="email-container">
                <div class="email-content">
                    <h2 class="grid-title">Presence</h2>
                    <div class="item-wrapper">
                        <div id="sample_c3-bar-chart" class="sample-chart"></div>
                    </div>
                </div>
                <div class="grid">
                    <div class="email-aside-list">
                        <div class="email-list-item">
                            <a href="#" class="email-list-item-inner">
                                <div class="workbench-title">
                                    Relationship
                                </div>
                                <div class="workbench-detail2">
                                    49 Cider Mill Heights,North Granby, CT 06060
                                    <br />
                                    1244 Russel Road,Westfield, MA 01085
                                </div>
                            </a>
                        </div>
                        <div class="email-list-item">
                            <a href="#" class="email-list-item-inner">
                                <div class="workbench-title">
                                    Job
                                </div>
                                <div class="workbench-detail2">
                                    -
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="email-attachments">
                    <p>Jobs</p>


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
                                    <div class="workbench-social-head">
                                        <i class="mdi mdi-linkedin"></i> &nbsp Linkedin
                                    </div>
                                    <div class="workbench-social-detail">
                                        <a href="https://www.linkedin.com/in/john-pagliaro-47b75258/" target="_blank">
                                            https://www.linkedin.com/in/john-pagliaro-47b75258/
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="email-list-item">
                                <div class="email-list-item-inner">
                                    <div class="workbench-social-head">
                                        <i class="mdi mdi-facebook"></i> &nbsp Facebook
                                    </div>
                                    <div class="workbench-social-detail">
                                        <a href="https://www.linkedin.com/in/john-pagliaro-47b75258/" target="_blank">
                                            https://www.linkedin.com/in/john-pagliaro-47b75258/
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="email-list-item">
                                <div class="email-list-item-inner">
                                    <div class="workbench-social-head">
                                        <i class="mdi mdi-instagram"></i> &nbsp Instagram
                                    </div>
                                    <div class="workbench-social-detail">
                                        <a href="https://www.linkedin.com/in/john-pagliaro-47b75258/" target="_blank">
                                            https://www.linkedin.com/in/john-pagliaro-47b75258/
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="email-list-item">
                                <div class="email-list-item-inner">
                                    <div class="workbench-social-head">
                                        <i class="mdi mdi-google"></i> &nbsp Google
                                    </div>
                                    <div class="workbench-social-detail">
                                        <a href="https://www.linkedin.com/in/john-pagliaro-47b75258/" target="_blank">
                                            https://www.linkedin.com/in/john-pagliaro-47b75258/
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Related Websites -->
    <div class="row">
        <div class="col-lg-12 equel-grid">
            <div class="grid">
                <div class="grid-header">
                    <div class="title"><i class="mdi mdi-web"></i> &nbsp; Related Websites</div>
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
                        <div class="col-md-3"><i class="mdi mdi-label"></i> &nbsp; SOCIAL NETWORK PROFILES</div>
                        <div class="col-md-3"><i class="mdi mdi-label"></i> &nbsp; PICTURE & VIDEO SHARING</div>
                        <div class="col-md-3"><i class="mdi mdi-label"></i> &nbsp; MICRO BLOGGING</div>
                    </div>
                    <div class="row" style="margin-bottom:50px;">
                        <div class="col-md-3"><i class="mdi mdi-label"></i> &nbsp; GEO SOCIAL NETWORK</div>
                        <div class="col-md-3"><i class="mdi mdi-label"></i> &nbsp; BLOGGING & FORUMS</div>
                        <div class="col-md-3"><i class="mdi mdi-label"></i> &nbsp; NEWS & MEDIA</div>
                        <div class="col-md-3"><i class="mdi mdi-label"></i> &nbsp; ALL</div>
                    </div>
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
    <!-- Web Results -->
    <div class="row">
        <div class="col-lg-12 equel-grid">
            <div class="grid">
                <div class="grid-header">
                    <div class="title"><i class="mdi mdi-cisco-webex"></i> &nbsp; Transaction History</div>
                </div>
                <div class="grid-body">
                    <div class="row">
                        <div class="col-md-3"><i class="mdi mdi-label"></i> &nbsp; OTHERS</div>
                        <div class="col-md-3"><i class="mdi mdi-label"></i> &nbsp; SOCIAL NETWORK PROFILES</div>
                        <div class="col-md-3"><i class="mdi mdi-label"></i> &nbsp; PICTURE & VIDEO SHARING</div>
                        <div class="col-md-3"><i class="mdi mdi-label"></i> &nbsp; MICRO BLOGGING</div>
                    </div>
                    <div class="row" style="margin-bottom:50px;">
                        <div class="col-md-3"><i class="mdi mdi-label"></i> &nbsp; GEO SOCIAL NETWORK</div>
                        <div class="col-md-3"><i class="mdi mdi-label"></i> &nbsp; BLOGGING & FORUMS</div>
                        <div class="col-md-3"><i class="mdi mdi-label"></i> &nbsp; NEWS & MEDIA</div>
                        <div class="col-md-3"><i class="mdi mdi-label"></i> &nbsp; ALL</div>
                    </div>
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
</div>
@endsection
@section('js_plugins')
<script src="{{ url("public/vendor/laravel-filemanager/js/lfm.js") }}"></script>

<!-- Vendor Js For This Page Ends-->
<script src="{{ url("public/admin/assets/vendors/d3/d3.min.js") }}"></script>
<script src="{{ url("public/admin/assets/vendors/c3/c3.js") }}"></script>
<!-- Vendor Js For This Page Ends-->
<!-- build:js -->
<script src="{{ url("public/admin/assets/js/charts/c3.js") }}"></script>
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

</script>
<script src="{{ asset("admin/assets/scripts/datatable-instance.js") }}" type="text/javascript"></script>
@endsection
