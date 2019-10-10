@extends('layouts.admin')

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
        <li class="breadcrumb-item active" aria-current="page">User Roles</li>
      </ol>
    </nav>
  </div>
  <div class="content-viewport">
    @include("admin/includes/alerts")
    {!! Form::open([ 'url' => route('user-save')]) !!}
    <div class="row">
      <div class="col-lg-12 equel-grid">
        <div class="grid">
          <div class="grid-header">
            <div class="title">Add New User</div>
            <div class="actions">
              <div class="btn-group btn-group-sm" role="group" aria-label="...">
                <button type="submit" class="btn btn-success has-icon"><i class="fa fa-save"></i>Save</button>
                <button type="button" onClick="location.href='{{ route("user-list") }}'" class="btn btn-danger has-icon"><i class="fa fa-times"></i>Cancel</button>
              </div>
            </div>
          </div>
          <div class="grid-body">
            <div class="item-wrapper">
              <div class="row">
                <div class="col-lg-8">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label> Full Name: </label>
                        {!! Form::text('name', old("name"), ['class' => 'form-control', 'maxlength' => '30']) !!}
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class=""> Phone Number: </label>
                        {!! Form::text('phone', old("phone"), ['class' => 'form-control', 'maxlength' => '20']) !!}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label> Email Address: </label>
                        {!! Form::text('email', old("email"), ['class' => 'form-control', 'maxlength' => '191']) !!}
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class=""> Password: </label>
                        {!! Form::password('password', ['class' => 'form-control', 'maxlength' => '15']) !!}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label for="RoleID">Role:</label>
                        {!! Form::select('RoleID', $Roles, old("RoleID"), ['class' => 'form-control my-select', 'id' => 'RoleID']) !!}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="custom-control custom-switch">
                        <input type="checkbox" name="Status" id="customSwitch1" class="chk-switch custom-control-input"{{ ((int)old("Status", 1) == 1 ? ' checked="checked"' : '') }}>
                        <label class="custom-control-label" for="customSwitch1">Active</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group m-form__group">
                        <label>Profile Picture: </label>
                        <div class="input-group">
                          <input id="thumbnail" class="form-control" type="text" name="user_image" value="{{ old("user_image") }}" readonly>
                          <div class="input-group-append">
                            <button class="btn btn-danger btn-remove-image" type="button" data-input="thumbnail" data-preview="holder"><i class="fa fa-times"></i></button>
                            <button class="btn btn-primary lfm-image" type="button" data-input="thumbnail" data-preview="holder">Choose</button>
                          </div>
                        </div>
                        <img id="holder"{{ (old("user_image") != "" ? ' src='.asset(old("user_image")) : "") }} class="img-fluid img-holder">
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
@endsection
@section('js_plugins')
<script src="{{ url("public/vendor/laravel-filemanager/js/lfm.js") }}"></script>
@endsection