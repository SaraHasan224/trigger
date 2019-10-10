
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Trigger - Register</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset("admin/assets/vendors/iconfonts/mdi/css/materialdesignicons.css") }}"/>
    <link rel="stylesheet" href="{{ asset("admin/assets/vendors/css/vendor.addons.css") }}"/>
    <!-- endinject -->
    <!-- vendor css for this page -->
    <!-- End vendor css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset("admin/assets/css/shared/style.css") }}"/>
    <!-- endinject -->
    <!-- Layout style -->
    <link rel="stylesheet" href="{{ asset("admin/assets/css/demo_1/style.css") }}"/>
    <link rel="stylesheet" href="{{ asset("admin/assets/css/custom.css") }}"/>
    <!-- Layout style -->
    <link rel="shortcut icon" href="{{ asset("admin/assets/images/favicon.ico") }}"/>
</head>
<body>
<div class="authentication-theme auth-style_1">
    <div class="row">
        <div class="col-12 logo-section">
            <a href="{{ route("home") }}" class="logo">
                <img src="{{ asset("admin/assets/images/logo.png") }}" alt="logo"/>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5 col-md-7 col-sm-9 col-11 mx-auto">
            <div class="grid">
                <div class="grid-body">
                    <div class="row">
                        <div class="col-lg-7 col-md-8 col-sm-9 col-12 mx-auto form-wrapper">
                            @include("admin/includes/alerts")
                            {!! Form::open([ 'url' => route('register',['auth_id'=>$auth_id,'role_id'=>$role_id])]) !!}
                            <div class="form-group input-rounded">
                                {!! Form::text('name',null, ['id' => 'name', 'class' => 'form-control', 'maxlength' => '30', 'autocomplete' => 'off', 'placeholder' => 'User name']) !!}
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group input-rounded">
                                {!! Form::text('email', null, ['id' => 'email', 'class' => 'form-control', 'maxlength' => '255', 'autocomplete' => 'off', 'placeholder' => 'E-Mail Address']) !!}
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group input-rounded">
                                {!! Form::password('password', ['id' => 'password', 'class' => 'form-control', 'maxlength' => '30', 'autocomplete' => 'off', 'placeholder' => 'Password']) !!}
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group input-rounded">
                                {!! Form::password('password_confirmation', ['id' => 'password-confirm', 'class' => 'form-control', 'maxlength' => '30', 'autocomplete' => 'new-password', 'placeholder' => 'Confirm Password']) !!}
                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-inline">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />Remember me <i class="input-frame"></i>
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="auth_id" value="{{$auth_id}}" />
                            <input type="hidden" name="role_id" value="{{$role_id}}" />
                            <button type="submit" class="btn btn-primary btn-block"> Sign Up</button>
                            {!! FORM::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="auth_footer">
        <p class="text-muted text-center">© Trigger Inc 2019</p>
    </div>
</div>
<!--page body ends -->
<!-- SCRIPT LOADING START FORM HERE /////////////-->
<!-- plugins:js -->
<script src="{{ asset("admin/assets/vendors/js/core.js") }}"></script>
<script src="{{ asset("admin/assets/vendors/js/vendor.addons.js") }}"></script>
<!-- endinject -->
<!-- Vendor Js For This Page Ends-->
<!-- Vendor Js For This Page Ends-->
<!-- build:js -->
<script src="{{ asset("admin/assets/js/template.js") }}"></script>
<script src="{{ asset("admin/assets/js/notifications.js") }}"></script>
<!-- endbuild -->
</body>
</html>
