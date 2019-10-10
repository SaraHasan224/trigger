@extends('layouts.admin')

@section('stylesheets')

  <link href="{{ asset("admin/assets/vendors/datatables/datatables.bundle.css") }}" rel="stylesheet" type="text/css" />

@endsection
@section('styles')
  <style>
    .btn-status i:hover{
      color: #fff !important;
    }
    btn-outline-danger:hover i{
      color: #ff5f66 !important;
    }
    btn-outline-success:hover i{
      color: #ff5f66 !important;
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
          <a href="javascript:;">Administrator</a>
        </li>
      </ol>
    </nav>
  </div>
  <div class="content-viewport">
    @include("admin/includes/alerts")
    {!! Form::open([ 'url' => route('user-delete'), 'id' => 'frm_list', 'method' => 'delete']) !!}
    <div class="row">
      <div class="col-lg-12 equel-grid">
        <div class="grid">
          <div class="grid-header">
            <div class="title">Users</div>
            <div class="actions">
              <div class="btn-group btn-group-sm" role="group" aria-label="...">
                @if(auth()->user()->user_type == 1)
                  <button type="button" data-toggle="modal" data-target="#registerationModal" id="registerationModalButton" class="btn btn-success has-icon" ><i class="mdi mdi-plus"></i>Generate Regsteraion Link</button>
                  &nbsp;&nbsp;&nbsp;
                @endif
                <button type="button" class="btn btn-success has-icon" onclick="location.href='{{ route("user-add") }}'"><i class="mdi mdi-plus"></i>Add</button>
                  &nbsp;&nbsp;&nbsp;
                <button type="button" onClick="doDelete()" class="btn btn-danger has-icon"><i class="mdi mdi-delete"></i>Delete</button>
              </div>
            </div>
          </div>
          <div class="grid-body">
            <table class="table table-striped table-bordered table-hover table-checkable" id="dataList">
              <thead>
              <tr role="row" class="heading">
                <th><input type="checkbox" class="check-all"></th>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>User Type</th>
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
    {!! FORM::close() !!}
  </div>
  <div class="modal fade right" id="registerationModal" tabindex="-1" role="dialog" aria-labelledby="registerationModalLabel">
    <!-- Add class .modal-side and then add class .modal-top-right (or other classes from list above) to set a position to the modal -->
    <div class="modal-dialog modal-side modal-top-right" role="document">
      <div class="modal-content">
        <div class="modal-header text-center">
          <h3 class="modal-title w-100 font-weight-bold" id="modal_title" style="font-size: 21px;">Registration Link</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body mx-3">
          <div class="md-form mb-1 col-md-1">
            <i class="fa fa-user prefix grey-text"></i>
          </div>
          <div class="md-form mb-4 offset-1 col-md-12">
            <select id="register_modal" class="form-control">
            </select>
            <div class="register_options text-center text-md-left mt-1"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btn-generate-registeration_link">Generate</button>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('js_plugins')
  <script src="{{ asset("admin/assets/vendors/datatables/datatables.bundle.js") }}" type="text/javascript"></script>
@endsection
@section('javascripts')
<script language="javascript">
	Globals["urlList"] = '{{ route("user-get-list") }}';
	Globals["urlUpdateStatus"] = '{{ route("user-update-status") }}';
	Globals["disableOrderColumns"] = [0, 8];
	Globals["dtDom"] = "lfrtip";
    Globals["defaultOrderColumns"] = [[1, "asc"]];
</script>
<script src="{{ asset("admin/assets/scripts/datatable-instance.js") }}" type="text/javascript"></script>
<script>
	$(document).ready(function(){
		$("#registerationModal").appendTo("body");
		$('#registerationModalButton').on('click', function() {
			$.ajax({
				type: "POST",
				url: '{{route('get-roles')}}',
				success: function (response) {
					$('#register_modal').empty();
					$('#register_modal').append(response);

				}
			});
		})
		$(".btn-generate-registeration_link").on('click',function(event) {
			var role_id = $('#register_modal').val();
			$.ajax({
				type: "POST",
				url: '{{route('generate-registeration-link')}}',
                data: {
                    'role_id': role_id
                },
				success: function (response) {
					$('.register_options').append(response);
				}
			});
		});
      });
</script>
@endsection