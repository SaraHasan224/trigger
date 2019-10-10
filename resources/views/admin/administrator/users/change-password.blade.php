@extends('layouts.admin')
@section("contents")
  <div class="viewport-header">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb has-arrow">
        <li class="breadcrumb-item">
          <a href="{{ route("admin-dashboard") }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="javascript:;">Administrator</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Change Password</li>
      </ol>
    </nav>
  </div>
  <div class="content-viewport">
    @include("admin/includes/alerts")
    <div class="row">
      <div class="col-lg-6 equel-grid">
        <div class="grid">
          <p class="grid-header">Change Password</p>
          <div class="grid-body">
            <div class="item-wrapper">
              {!! Form::open([ 'url' => route("update-password-admin")]) !!}
                <div class="form-group">
                  <label for="CurrentPassword">Current Password</label>
                  {!! Form::password('CurrentPassword', ['id' => 'CurrentPassword', 'class' => 'form-control', 'maxlength' => '30']) !!}
                </div>
                <div class="form-group">
                  <label for="NewPassword">New Password</label>
                  {!! Form::password('NewPassword', ['id' => 'NewPassword', 'class' => 'form-control', 'maxlength' => '30']) !!}
                </div>
                <div class="form-group">
                  <label for="ConfirmPassword">Retype New Password</label>
                  {!! Form::password('ConfirmPassword', ['id' => 'ConfirmPassword', 'class' => 'form-control', 'maxlength' => '30']) !!}
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Change Password</button>
              {!! FORM::close() !!}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection