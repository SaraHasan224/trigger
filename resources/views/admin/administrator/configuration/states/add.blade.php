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
        <li class="breadcrumb-item">
          <a href="javascript:;">Configuration</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Manage State</li>
      </ol>
    </nav>
  </div>
  <div class="content-viewport">
    @include("admin/includes/alerts")
    {!! Form::open([ 'url' => route('state-save')]) !!}
    <div class="row">
      <div class="col-lg-6 equel-grid">
        <div class="grid">
          <div class="grid-header">
            <div class="title">Add New State</div>
            <div class="actions">
              <div class="btn-group btn-group-sm" role="group" aria-label="...">
                <button type="submit" class="btn btn-success has-icon"><i class="fa fa-save"></i>Save</button>
                <button type="button" onClick="location.href='{{ route("state-list") }}'" class="btn btn-danger has-icon"><i class="fa fa-times"></i>Cancel</button>
              </div>
            </div>
          </div>
          <div class="grid-body">
            <div class="item-wrapper">
              <div class="form-group">
                <label for="name">Name:</label>
                {!! Form::text('name',  old("name"), ['id' => 'name', 'class' => 'form-control', 'maxlength' => '30']) !!}
              </div>
              <div class="form-group">
                <label for="Name">Country:</label>
                {!! Form::select('country_id', $country_name, old("country_id"), ['class' => 'form-control my-select', 'id' => 'country_id']) !!}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    {!! FORM::close() !!}
  </div>
@endsection