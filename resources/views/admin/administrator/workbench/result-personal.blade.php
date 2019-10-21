@extends('layouts.admin')
@section('stylesheets')
<link href="{{ asset("admin/assets/vendors/datatables/datatables.bundle.css") }}" rel="stylesheet" type="text/css" />
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
                <a href="{{ route("personal-form") }}">Personal Search</a>
            </li>
            @php
                $first_name = $record->first_name;
                $middle_name = $record->middle_name;
                $last_name = $record->last_name;
                if ($middle_name != '') {
                    $fullName = $first_name . ' ' . $middle_name . ' ' . $last_name;
                }
                else {
                    $fullName = $first_name . ' ' . $last_name;
                }
            @endphp
            <li class="breadcrumb-item active" aria-current="page">{{$fullName}}</li>
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
                        @php
                            if (array_key_exists('personal', $result)) {
                                if (array_key_exists('avatar', $result['personal']) && !empty($result['personal']['avatar'])) {
                                    $avatar = $result['personal']['avatar'];
                                }else{
                                    $avatar = asset('admin/users/avatar.png');
                                }
                            }else{
                                    $avatar = asset('admin/users/avatar.png');
                            }
                        @endphp
                        <img src="{{$avatar}}" class="workbench-img" alt="profile image">
                    </div>
                </div>
            </div>
            <!-- Gender -->
            <div class="email-list-item">
                <a href="#" class="email-list-item-inner">
                    <div class="workbench-ico">
                        <i class="mdi mdi-human-male-female"></i>
                    </div>
                    @php
                        $gender = '-';
                        if (array_key_exists('personal', $result)) {
                                if (array_key_exists('gender', $result['personal']) && !empty($result['personal']['gender'])) {
                                    $gender = $result['personal']['gender'];
                                }else{
                                     $gender = "-";
                                }
                        }
                    @endphp
                    <div class="workbench-detail">{{$gender}}</div>
                </a>
            </div>
            <!-- Phone Number -->
            <div class="email-list-item">
                <a href="#" class="email-list-item-inner">
                    <div class="workbench-ico">
                        <i class="mdi mdi-phone"></i>
                    </div>
                    @php
                        $phone_number = '-';
                        if (array_key_exists('personal', $result)) {
                                if (array_key_exists('phone_number', $result['personal']) && !empty($result['personal']['phone_number'])) {
                                    $phone_number = $result['personal']['phone_number'];
                                }else{
                                     $phone_number = "-";
                                }
                        }
                    @endphp
                    <div class="workbench-detail">
                        {{$phone_number}}
                    </div>
                </a>
            </div>
            <!-- Email Address -->
            <div class="email-list-item">
                <a href="#" class="email-list-item-inner">
                    <div class="workbench-ico">
                        <i class="mdi mdi-email"></i>
                    </div>
                    @php
                        $email = '-';

                        if (array_key_exists('personal', $result)) {
                                if (array_key_exists('email', $result['personal']) && !empty($result['personal']['email'])) {
                                    $email = $result['personal']['email'];
                                }else{
                                     $email = "-";
                                }
                        }
                    @endphp
                    <div class="workbench-detail">
                        {{$email}}
                    </div>
                </a>
            </div>
            <!-- Language -->
            <div class="email-list-item">
                <a href="#" class="email-list-item-inner">
                    <div class="workbench-ico">
                        <i class="fa fa-language"></i>
                    </div>
                    @php
                        $language = 'English';
                        if (array_key_exists('personal', $result)) {
                                if (array_key_exists('language', $result['personal']) && !empty($result['personal']['language'])) {
                                    $language = $result['personal']['language'];
                                }else{
                                     $language = "English";
                                }
                        }
                    @endphp
                    <div class="workbench-detail">
                        {{$language}}
                    </div>
                </a>
            </div>
            <!-- Address -->
            <div class="email-list-item">
                <a href="#" class="email-list-item-inner">
                    <div class="workbench-ico">
                        <i class="mdi mdi mdi-clock-fast"></i>
                    </div>
                    @php
                        $timeZone = '-';
                        if (array_key_exists('personal', $result)) {
                                if (array_key_exists('timezone', $result['personal']) && !empty($result['personal']['timezone'])) {
                                    $timeZone = $result['personal']['timezone'];
                                }else{
                                     $timeZone = "-";
                                }
                        }
                    @endphp
                    <div class="workbench-detail">
                        {{$timeZone}}
                    </div>
                </a>
            </div>
            <!-- Address -->
            <div class="email-list-item">
                <a href="#" class="email-list-item-inner">
                    <div class="workbench-ico">
                        <i class="mdi mdi-home-map-marker"></i>
                    </div>
                    @php
                        $location = '-';
                        if (array_key_exists('personal', $result)) {
                                if (array_key_exists('location', $result['personal']) && !empty($result['personal']['location'])) {
                                    $location = $result['personal']['location'];
                                }else{
                                     $location = "-";
                                }
                        }
                        if (array_key_exists('business', $result)) {
                                if (array_key_exists('business', $result) && !empty($result['business'])) {
                                        $location = $result['business']['location'];
                                }else{
                                     $location = "-";
                                }
                        }
                    @endphp
                    <div class="workbench-detail">
                        {{$location}}
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
            <div class="email-list-item" style="display: none;">
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
                <p class="user_name">{{$fullName}}</p>
                <a class="user-email" href="mailto:jpagliaro@yoursummit.com">{{$email}}</a>
                {{--<a class="user-email" href="mailto:jpagliarojr@comsat.net">jpagliarojr@comsat.net</a>--}}
                <p class="date">{{$result_date}}</p>
            </div>
            <div class="email-container" >
                <div class="email-content" style="display:none;">
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

                                @php
                                    $relationship = '-';
                                    if (array_key_exists('personal', $result)) {
                                            if (array_key_exists('relationship', $result['personal']) && !empty($result['personal']['relationship'])) {
                                                $relationship = $result['personal']['relationship'];
                                            }else{
                                                 $relationship = "-";
                                            }
                                    }
                                @endphp
                                <div class="workbench-detail2">
                                    {{$relationship}}
                                </div>
                            </a>
                        </div>
                        @php
                            $job = '';
                             $works_at = "-";
                             $work_role = "-";
                             $company_domain = "-";
                             $business_description = "-";
                            if (array_key_exists('personal', $result)) {
                                    if (array_key_exists('works_at', $result['personal']) && !empty($result['personal']['works_at'])) {
                                        $works_at = $result['personal']['works_at'];
                                        $work_role = $result['personal']['work_role'];
                                        $company_domain = $result['personal']['company_domain'];
                                    }else{
                                         $works_at = "-";
                                        $work_role = "-";
                                        $company_domain = "-";
                                    }
                            }
                             if (array_key_exists('business', $result)) {
                              if (array_key_exists('description', $result['business']) && !empty($result['business']['description'])) {
                                $business_description =  $result['business']['description'];
                              }else{ $business_description = "-";}
                              if (array_key_exists('name', $result['business']) && !empty($result['business']['name'])) {
                                if($works_at == "-") { $works_at =  $result['business']['name']; }
                              }else{ $works_at = "-";}
                             }
                            $job = '<b>Works At:</b> '.$works_at.' <br/> <b>Job Role:</b> '.$work_role.' <br/> <b>Company Domain:</b>'.$company_domain.'<br/> <b>Company Description:</b> '.$business_description;

                        @endphp
                        <div class="email-list-item">
                            <a href="#" class="email-list-item-inner">
                                <div class="workbench-title">
                                    Works At
                                </div>
                                <div class="workbench-detail2">
                                    {!! $works_at !!}
                                </div>
                            </a>
                        </div>
                        <div class="email-list-item">
                            <a href="#" class="email-list-item-inner">
                                <div class="workbench-title">
                                    Work Role
                                </div>
                                <div class="workbench-detail2">
                                    {!! $work_role !!}
                                </div>
                            </a>
                        </div>
                        <div class="email-list-item">
                            <a href="#" class="email-list-item-inner">
                                <div class="workbench-title">
                                    Company Domain
                                </div>
                                <div class="workbench-detail2">
                                    {!! $company_domain !!}
                                </div>
                            </a>
                        </div>
                        <div class="email-list-item">
                            <a href="#" class="email-list-item-inner">
                                <div class="workbench-title">
                                    Company Description
                                </div>
                                <div class="workbench-detail2">
                                    {!! $business_description !!}
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                {{--<div class="email-attachments">--}}
                    {{--<p>Jobs</p>--}}


                {{--</div>--}}
            </div>
        </div>
    </div>
    <!-- Images -->
    <div class="row" style="display: none">
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
    <div class="row" style="display: none">
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
    <div class="row" style="display: none">
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
    <div class="row" style="display: none">
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
    <div class="row" style="display: none">
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

  if( window.localStorage )
  {
    if( !localStorage.getItem('firstLoad') )
    {
      localStorage['firstLoad'] = true;
      window.location.reload();
    }  
    else
      localStorage.removeItem('firstLoad');
  }
</script>
<script src="{{ asset("admin/assets/scripts/datatable-instance.js") }}" type="text/javascript"></script>
@endsection
