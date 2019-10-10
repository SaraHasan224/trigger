@extends('layouts.admin')
@section('stylesheets')
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/vendors/datatables/datatables.min.css') }}"/>
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
          <a href="javascript:;">Administrator</a>
        </li>
      </ol>
    </nav>
  </div>
  <div class="content-viewport">
    @include("admin/includes/alerts")
    {{--{!! Form::open([ 'url' => route('record-delete'), 'id' => 'frm_list']) !!}--}}
    <div class="row">
      <div class="col-lg-12 equel-grid">
        <div class="grid">
          <div class="grid-header">
            <div class="title">Records</div>
            <div class="actions">
              <div class="btn-group btn-group-sm" role="group" aria-label="...">
                <button type="button" class="btn btn-success" onclick="location.href='{{ route("imp-view") }}'">Import Records</button>


                {{--<button type="button" class="btn btn-success has-icon" onclick="location.href='{{ route("record-add") }}'"><i class="mdi mdi-plus"></i>Add</button>--}}
                {{--<button type="button" onClick="doDelete()" class="btn btn-danger has-icon"><i class="mdi mdi-delete"></i>Delete</button>--}}
              </div>
            </div>
          </div>
          <div class="grid-body">
            <table width="100%" class="table table-striped table-bordered table-hover table-checkable" id="dataList" >
              <thead>
              <tr role="row" class="heading">
                {{--<th><input type="checkbox" class="check-all"></th>--}}
                <th>ID</th>
                <th>First Name</th>
                <th>last Name</th>
                <th>Email</th>
                <th>Street</th>
                <th>City</th>
                <th>State</th>
                <th>Zip</th>
                <th>Phone #</th>
                <th>Prior Street</th>
                <th>Prior City</th>
                <th>Prior State</th>
                <th>Prior Zip</th>
                <th>Date of Birth</th>
                <th>Current Employment</th>
                <th>Policy Number</th>
                <th>Line of Business</th>
                <th>Claim Number</th>
                <th>Loss Date</th>
                <th>Claim Description</th>
                <th>Added</th>
                <th>Modified</th>
                {{--<th>Actions</th>--}}
              </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
{{--    {!! FORM::close() !!}--}}
  </div>
@endsection
@section('js_plugins')

  <script src="{{ asset('admin/assets/vendors/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset("admin/assets/vendors/datatables/datatables.bundle.js") }}" type="text/javascript"></script>
@endsection
@section('javascripts')
<script language="javascript">
	Globals["urlList"] = '{{ route("record-get-list") }}';
	{{--Globals["urlUpdateStatus"] = '{{ route("user-update-status") }}';--}}
	Globals["disableOrderColumns"] = [0, 5];
    Globals["dtDom"] = "lBfrtip";
	Globals["className"] = "btn btn-info btn-sm";
    Globals["dtButtons"] = [
        {
            extend: 'excel',
            text: '<i class="fa fa-file-excel-o"></i> Excel',
            className: Globals["className"]
        },
//        {
//            extend: 'pdf',
//            text: '<i class="fa fa-file-pdf-o"></i> PDF',
//            className: Globals["className"]
//        },
        {
            extend: 'csv',
            text: '<i class="fa fa-file-text-o"></i> CSV',
            className: Globals["className"]
        },
        {
            extend: 'print',
            text: '<i class="fa fa-print"></i> Print',
            className: Globals["className"]
        }
    ];
  Globals["defaultOrderColumns"] = [[1, "asc"]];
</script>
<script src="{{ asset("admin/assets/scripts/datatable-instance.js") }}" type="text/javascript"></script>
@endsection