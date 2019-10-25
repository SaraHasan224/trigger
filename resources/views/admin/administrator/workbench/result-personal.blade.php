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
            <li class="breadcrumb-item active" aria-current="page">{{$result['fullName']}}</li>
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
                        <img src="{{$result['display']}}" class="workbench-img" alt="profile image">
                    </div>
                </div>
            </div>
            <!-- Gender -->
            <div class="email-list-item">
                <a href="#" class="email-list-item-inner">
                    <div class="workbench-ico">
                        @if(strtolower($result['gender']) == "male")
                            <i class="mdi mdi-human-male"></i>
                        @elseif(strtolower($result['gender']) == "female")
                            <i class="mdi mdi-human-female"></i>
                        @else
                            <i class="mdi mdi-human"></i>
                        @endif
                    </div>
                    <div class="workbench-detail">{{$result['gender']}}</div>
                </a>
            </div>
            <!-- Language -->
            <div class="email-list-item">
                <a href="#" class="email-list-item-inner">
                    <div class="workbench-ico">
                        <i class="fa fa-language"></i>
                    </div>
                    <div class="workbench-detail">
                        {{ strtoupper($result['language'])}}
                    </div>
                </a>
            </div>
            <!-- country -->
            <div class="email-list-item">
                <a href="#" class="email-list-item-inner">
                    <div class="workbench-ico">
                        <i class="mdi mdi-web"></i>
                    </div>
                    <div class="workbench-detail">
                        {{ $result['country']}}
                    </div>
                </a>
            </div>
            <!-- timeZone -->
            <div class="email-list-item">
                <a href="#" class="email-list-item-inner">
                    <div class="workbench-ico">
                        <i class="mdi mdi mdi-clock-fast"></i>
                    </div>
                    <div class="workbench-detail">
                        {{ $result['timeZone']}}
                    </div>
                </a>
            </div>
            <!-- Longitude and Latitude -->
            @if($result['lat'] != "" && $result['lng'] != '')
            <div class="email-list-item">
                <a href="#" class="email-list-item-inner">
                    <div class="workbench-ico">
                        <i class="mdi mdi-home-map-marker"></i>
                    </div>
                    <div class="workbench-detail">
                        Latitude: {{$result['lat']}} <br/>
                        Longitude: {{$result['lng']}}
                    </div>
                </a>
            </div>
            @endif
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
                <p class="user_name">{{$result['fullName']}}</p>
                {{--@foreach($result['emails'] as $item)--}}
                    {{--<a class="user-email" href="{!! $item !!}">{!! $item !!}</a>--}}
                {{--@endforeach--}}
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
                <!-- Email -->
                <div class="grid">
                    <div class="email-aside-list">
                        <div class="email-list-item">
                            <div class="email-list-item-inner">
                                <div class="workbench-title">
                                    <i class="mdi mdi-email"></i> Email Address
                                </div>
                                <div class="workbench-detail2">
                                    <div class="row">
                                    @foreach($result['emails'] as $key => $item)
                                            @if($key%2 == 0)
                                                <div class="col-md-6">
                                                    {!! $item !!}<br/>
                                                </div>
                                            @else
                                                <div class="col-md-6">
                                                    {!! $item !!}<br/>
                                                </div>
                                            @endif
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Phone Number -->
                <div class="grid">
                    <div class="email-aside-list">
                        <div class="email-list-item">
                            <div class="email-list-item-inner">
                                <div class="workbench-title">
                                    <i class="mdi mdi-phone"></i> Phone Number
                                </div>
                                <div class="workbench-detail2">
                                    <div class="row">
                                        @foreach($result['phone_number'] as $key => $num)
                                            @if($key%2 == 0)
                                                <div class="col-md-6">
                                                    {!! $num !!}<br/>
                                                </div>
                                            @else
                                                <div class="col-md-6">
                                                    {!! $num !!}<br/>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Address -->
                <div class="grid">
                    <div class="email-aside-list">
                        <div class="email-list-item">
                            <div class="email-list-item-inner">
                                <div class="workbench-title">
                                    <i class="mdi mdi-home-map-marker"></i> Location
                                </div>
                                <div class="workbench-detail2">
                                    @foreach($result['locations'] as $item)
                                        {!! $item !!}
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Relations -->
                <div class="grid">
                    <div class="email-aside-list">
                        <div class="email-list-item">
                            <a href="#" class="email-list-item-inner">
                                <div class="workbench-title">
                                    <i class="mdi mdi-human-male-female"></i> Relationship
                                </div>
                                <div class="workbench-detail2">
                                    {{$result['relationship']}}
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Career -->
                <div class="grid">
                    <div class="email-aside-list">
                        @if($result['work_at'] != "")
                            <div class="email-list-item">
                                <div class="email-list-item-inner">
                                    <div class="workbench-title">
                                        <i class="mdi mdi-worker"></i>  Work
                                    </div>
                                    <div class="workbench-detail2">
                                        @if($result['work_at'] != "")
                                            Company: {!! $result['work_at'] !!}
                                            @if($result['work_description'] != "")
                                                &nbsp; <br/>({!! $result['work_description'] !!})<br/>
                                            @endif
                                            @if($result['foundedYear'] != "")
                                                &nbsp; <br/>Founded In: {!! $result['foundedYear'] !!}<br/>
                                            @endif
                                        @endif
                                        @if($result['work_domain'] != "")
                                                <br/>Domain: {!! $result['work_domain'] !!}<br/>
                                        @endif
                                        @if($result['work_title'] != "")
                                                <br/> Title: {!! $result['work_title'] !!}<br/>
                                        @endif
                                        @if($result['work_role'] != "")
                                                <br/> Role: {!! $result['work_role'] !!}<br/>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Images -->
    @if($result['images'] != [])
    <div class="row">
        <div class="col-lg-12 equel-grid">
            <div class="grid">
                <div class="grid-header">
                    <div class="title"><i class="mdi mdi-image-filter"></i> &nbsp; Images</div>
                </div>
                <div class="grid-body">
                    <div class="item-wrapper">
                        <div class="row">
                            @foreach($result['images'] as $img)
                                @php
//                                    $result = file_get_contents($img);
//                                    dd($result);
                                @endphp
                            <div class="col-lg-3 col-md-4 col-6">
                                <a href="{{$img}}" class="d-block mb-4 h-100">
                                    <img class="img-fluid img-thumbnail"
                                        src="{{$img}}" alt="">
                                </a>
                            </div>
                            @endforeach
                            <!--
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
                            -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- Social -->
    @if($result['social'] != [])
        @php
            $github = $result['github'];
            $twitter = $result['twitter'];
            $facebook = $result['facebook'];
            $linkedin = $result['linkedin'];
            $crunchbase = $result['crunchbase'];
        @endphp
        <div class="row">
        <div class="col-lg-12 equel-grid">
            <div class="grid">
                <div class="grid-header">
                    <div class="title"><i class="fa fa-podcast"></i> &nbsp; Social</div>
                </div>
                <div class="grid-body">
                    <div class="item-wrapper">
                        <div class="email-aside-list">
                            @if(array_key_exists('handle',$linkedin) && $linkedin['handle'] != [])
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
                            @endif
                            @if(array_key_exists('handle',$facebook) && $facebook['handle'] != [])
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
                            </div>x
                            @endif
                            @if(array_key_exists('handle',$twitter) && $twitter['handle'] != [])
                            <div class="email-list-item">
                                <div class="email-list-item-inner">
                                    <div class="workbench-social-head">
                                        <i class="mdi mdi-twitter"></i> &nbsp Twitter
                                    </div>
                                    <div class="workbench-social-detail">
                                        @foreach($twitter['handle'] as $twitter_handle)
                                        <a href="https://twitter.com/{{$twitter_handle}}" target="_blank">
                                            https://twitter.com/{{$twitter_handle}}
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(array_key_exists('handle',$github) && $github['handle'] != [])
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
                                @endif
                            @if(array_key_exists('handle',$crunchbase) && $crunchbase['handle'] != [])
                                    <div class="email-list-item">
                                        <div class="email-list-item-inner">
                                            <div class="workbench-social-head">
                                                <i class="mdi mdi-google"></i> &nbsp Crunchbase
                                            </div>
                                            <div class="workbench-social-detail">
                                                <a href="https://www.linkedin.com/in/john-pagliaro-47b75258/" target="_blank">
                                                    https://www.linkedin.com/in/john-pagliaro-47b75258/
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- Related Websites -->
    @if($result['urls'] != [])
    <div class="row">
        <div class="col-lg-12 equel-grid">
            <div class="grid">
                <div class="grid-header">
                    <div class="title"><i class="mdi mdi-web"></i> &nbsp; Related Websites</div>
                </div>
                <div class="grid-body">
                    <div class="item-wrapper">
                        <div class="email-aside-list">
                            @foreach($result['urls'] as $item)
                            <div class="email-list-item">
                                <div class="email-list-item-inner">
                                    <img class="workbech_site_img" src="http://www.placehold.it/50x50"
                                        alt="profile image">
                                    <p class="workbech_site_name">Link</p>
                                    {{--<p class="workbech_site_name">Title</p>--}}
                                    {{--<p class="workbech_site_name">Preview</p>--}}
                                    <div class="workbench-social-detail">
                                        <a href="{{$item}}" target="_blank">
                                            {{$item}} </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
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
