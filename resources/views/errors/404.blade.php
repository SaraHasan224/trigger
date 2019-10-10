<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Trigger - Administrator Panel</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset("admin/assets/vendors/iconfonts/mdi/css/materialdesignicons.css") }}"/>
    <link rel="stylesheet" href="{{ asset("admin/assets/vendors/iconfonts/font-awesome/css/font-awesome.css") }}" />
    <link rel="stylesheet" href="{{ asset("admin/assets/vendors/css/vendor.addons.css") }}"/>
    <!-- endinject -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset("admin/assets/css/shared/style.css") }}"/>
    <!-- endinject -->
    <!-- Layout style -->
    <link rel="stylesheet" href="{{ asset("admin/assets/css/demo_1/style.css") }}"/>
    <link rel="stylesheet" href="{{ asset("admin/assets/css/custom.css") }}"/>
    <!-- Layout style -->
    <link rel="shortcut icon" href="{{ asset("admin/assets/images/favicon.ico") }}"/>
    @yield("styles")
</head>
<body class="header-fixed">
<nav class="t-header">

    <div class="t-header-brand-wrapper">
        <a href="{{url('/')}}">
            <img class="logo" src="{{ asset("admin/assets/images/logo.png") }}" alt="Logo">
            <img class="logo-mini" src="{{ asset("admin/assets/images/logo.png") }}" alt="Logo">
        </a>
        <button class="t-header-toggler t-header-desk-toggler d-none d-lg-block">
            <svg class="logo" viewBox="0 0 200 200">
                <path class="top" d="
                M 40, 80
                C 40, 80 120, 80 140, 80
                C180, 80 180, 20  90, 80
                C 60,100  30,120  30,120
              "></path>
                <path class="middle" d="
                M 40,100
                L140,100
              "></path>
                <path class="bottom" d="
                M 40,120
                C 40,120 120,120 140,120
                C180,120 180,180  90,120
                C 60,100  30, 80  30, 80
              "></path>
            </svg>
        </button>
    </div>
    <div class="t-header-content-wrapper">
        <div class="t-header-content">
            <button class="t-header-toggler t-header-mobile-toggler d-block d-lg-none">
                <i class="mdi mdi-menu"></i>
            </button>
        </div>
    </div>
</nav>
<!-- partial -->
<div class="page-body">

    <div class="sidebar">
        <ul class="navigation-menu">

        </ul>
    </div>
    <div class="page-content-wrapper">
        <div class="page-content-wrapper-inner">
            <div class="viewport-header">
                <div class="error_page error_2">
                    <div class="container inner-wrapper">
                        <h1 class="display-1 error-heading">404</h1>
                        <h2 class="error-code">Page Not Found</h2>
                        <p class="error-message">The page you are looking for might have been removed had its name changed or is temporarily unavailable.</p>
                        <a href="{{url('/admin-dashboard')}}" class="btn btn-primary">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
        @include("admin/includes/footer")
    </div>
    <!-- page content ends -->
</div>
<!--page body ends -->
<!-- SCRIPT LOADING START FORM HERE /////////////-->
<!-- plugins:js -->
<script src="{{ asset("admin/assets/vendors/js/core.js") }}"></script>
<script src="{{ asset("admin/assets/vendors/js/vendor.addons.js") }}"></script>
<!-- endinject -->
<!-- build:js -->
<script src="{{ asset("admin/assets/js/template.js") }}"></script>
