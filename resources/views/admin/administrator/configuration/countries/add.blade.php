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
        <li class="breadcrumb-item active" aria-current="page">Manage Countries</li>
      </ol>
    </nav>
  </div>
  <div class="content-viewport">
    @include("admin/includes/alerts")
    {!! Form::open([ 'url' => route('countries-save')]) !!}
    <div class="row">
      <div class="col-lg-6 equel-grid">
        <div class="grid">
          <div class="grid-header">
            <div class="title">Add New Country</div>
            <div class="actions">
              <div class="btn-group btn-group-sm" role="group" aria-label="...">
                <button type="submit" class="btn btn-success has-icon"><i class="fa fa-save"></i>Save</button>
                <button type="button" onClick="location.href='{{ route("countries-list") }}'" class="btn btn-danger has-icon"><i class="fa fa-times"></i>Cancel</button>
              </div>
            </div>
          </div>
          <div class="grid-body">
            <div class="item-wrapper">
              <div class="form-group">
                <label for="SortName">Sort Name:</label>
                {!! Form::text('sort_name', old("sort_name"), ['id' => 'sort_name', 'class' => 'form-control', 'maxlength' => '30']) !!}
              </div>
              <div class="form-group">
                <label for="Name">Name:</label>
                {!! Form::text('name', old("name"), ['id' => 'name', 'class' => 'form-control', 'maxlength' => '50']) !!}
              </div>
              <div class="form-group">
                <label for="PhoneCode">Phone Code:</label>
                {!! Form::text('phone_code', old("phone_code"), ['id' => 'phone_code', 'class' => 'form-control', 'maxlength' => '8']) !!}
              </div>
              <div class="form-group">
                <label for="LangCode">Language Code:</label>
                {!! Form::text('lang_code', old("lang_code"), ['id' => 'lang_code', 'class' => 'form-control', 'maxlength' => '11']) !!}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    {!! FORM::close() !!}
  </div>
@endsection