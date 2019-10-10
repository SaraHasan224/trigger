@php
$main_segment = Request::segment(1);
$sub_segment1 = Request::segment(2);
@endphp
<div class="sidebar">
    <ul class="navigation-menu">
        <li class="nav-category-divider">MAIN</li>
        <li>
            <a href="{{ route("admin-dashboard") }}">
                <span class="link-title">Dashboard</span>
                <i class="mdi mdi-gauge link-icon"></i>
            </a>
        </li>
        <li class="nav-category-divider">ADIMINSTRATOR</li>
        @if(auth()->user()->can('List Users'))
        <li>
            <a href="{{ route("user-list") }}">
                <span class="link-title">Users</span>
                <i class="mdi mdi-account-multiple link-icon"></i>
            </a>
        </li>
        @endif
        @if(auth()->user()->can('List Roles'))
        <li>
            <a href="{{ route("role-list") }}">
                <span class="link-title">Roles</span>
                <i class="mdi mdi-account-check link-icon"></i>
            </a>
        </li>
        @endif
        @if(auth()->user()->can('List Records'))
        <li>
            <a href="{{ route("record-list") }}">
                <span class="link-title">Records</span>
                <i class="mdi mdi-file link-icon"></i>
            </a>
        </li>
        @endif
        <!--<li>
            <a href="#icons" data-toggle="collapse" aria-expanded="false" class="collapsed">
                <span class="link-title">Configuration</span>
                <i class="mdi mdi-asterisk link-icon"></i>
            </a>
            <ul class="navigation-submenu collapse" id="icons" style="">
                <li>
                    <a href="{{ route("countries-list") }}">Manage Countries</a>
                </li>
            </ul>
        </li>-->
        @if(auth()->user()->can('List Workbench'))
        <li>
            <a href="#ui-elements" data-toggle="collapse" aria-expanded="false">
                <span class="link-title">Workbench</span>
                <i class="mdi mdi-bullseye link-icon"></i>
            </a>
            <ul class="collapse navigation-submenu" id="ui-elements">
                <li>
                    <a href="{{ route("personal-form") }}">Personal Workbench</a>
                </li>
                <li>
                    <a href="{{ route("business-form") }}">Business Workbench</a>
                </li>
            </ul>
        </li>
        @endif
        @if(auth()->user()->can('List Workbench'))
        <li>
            <a href="#search-elements" data-toggle="collapse" aria-expanded="false">
                <span class="link-title">Claim Search</span>
                <i class="mdi mdi-adjust link-icon"></i>
            </a>
            <ul class="collapse navigation-submenu" id="search-elements">
                <li>
                    <a href="{{ route("claim-form") }}">Claim Search</a>
                </li>
                <!--<li>
                    <a href="{{ route("prior-claim-search") }}">Prior Claim Search</a>
                </li>-->
            </ul>
        </li>
        @endif
        <!--<li>
            <a href="{{ route("prior-search") }}">
                <span class="link-title">Prior Searches</span>
                <i class="mdi mdi-magnify link-icon"></i>
            </a>
        </li>-->
        @if(auth()->user()->can('Send Email'))
        <li>
            <a href="#icons" data-toggle="collapse" aria-expanded="false" class="collapsed">
                <span class="link-title">Mailing</span>
                <i class="mdi mdi-email-outline  link-icon"></i>
            </a>
            <ul class="navigation-submenu collapse" id="icons" style="">
                <li>
                    <a href="{{ route("email-send") }}">Mailing</a>
                </li>
                <li>
                    <a href="{{ route("mass-email-send") }}">Mass Mailing</a>
                </li>
            </ul>
        </li>
        @endif

    </ul>
    <div class="sidebar_footer">
        <div class="user-account">
            <a class="user-profile-item" href="{{ route("my-profile-admin") }}"><i class="mdi mdi-account"></i>
                Profile</a>
            <a class="user-profile-item" href="{{ route("change-password-admin") }}"><i class="mdi mdi-settings"></i>
                Change Password</a>
            <a class="btn btn-primary btn-logout" href="#">Logout</a>
        </div>
        <div class="btn-group admin-access-level">
            <div class="avatar">
                <img class="profile-img" src="{{ asset(auth()->user()->user_image) }}" alt="">
            </div>
            <div class="user-type-wrapper">
                <p class="user_name">{{ auth()->user()->name }}</p>
                <div class="d-flex align-items-center">
                    <div class="status-indicator small rounded-indicator bg-success"></div>
                    <small class="user_access_level">Admin</small>
                </div>
            </div>
            <i class="arrow mdi mdi-chevron-right"></i>
        </div>
    </div>
</div>
