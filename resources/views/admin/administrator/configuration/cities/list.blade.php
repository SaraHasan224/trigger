@extends('layouts.admin')
@section('stylesheets')
<link href="{{ asset("admin/assets/vendors/datatables/datatables.bundle.css") }}" rel="stylesheet" type="text/css" />
@endsection
@section('contents')
  <div class="viewport-header">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb has-arrow">
        <li class="breadcrumb-item">
          <a href="{{ route("admin-dashboard") }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="javascript:;">Configuration</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Manage States</li>
      </ol>
    </nav>
  </div>
  <div class="content-viewport">
    @include("admin/includes/alerts")
    {!! Form::open([ 'url' => route('city-delete'), 'id' => 'frm_list', 'method' => 'DELETE']) !!}
    <div class="row">
      <div class="col-lg-12 equel-grid">
        <div class="grid">
          <div class="grid-header">
            <div class="title">Cities</div>
            <div class="actions">
              <div class="btn-group btn-group-sm" role="group" aria-label="...">
                <button type="button" class="btn btn-success has-icon" onclick="location.href='{{ route("city-add") }}'"><i class="mdi mdi-plus"></i>Add</button>
                <button type="button" onClick="doDelete()" class="btn btn-danger has-icon"><i class="mdi mdi-delete"></i>Delete</button>
              </div>
            </div>
          </div>
          <div class="grid-body">
            <table class="table table-striped table-bordered table-hover table-checkable" id="dataList">
              <thead>
              <tr role="row" class="heading">
                <th><input type="checkbox" class="check-all"></th>
                <th>City Name</th>
                <th>State </th>
                <th>Country </th>
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
    {!! FORM::close() !!}
  </div>
@endsection
@section('js_plugins')
  <script src="{{ asset("admin/assets/vendors/datatables/datatables.bundle.js") }}" type="text/javascript"></script>
@endsection
@section('javascripts')
  <script language="javascript">
      Globals["urlList"] = '{{ route("city-get-list") }}';
      Globals["disableOrderColumns"] = [0, 5];
      Globals["dtDom"] = "lfrtip";
      Globals["defaultOrderColumns"] = [[1, "asc"]];
  </script>
<script src="{{ asset("admin/assets/scripts/datatable-instance.js") }}" type="text/javascript"></script>
@endsection