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
    {!! Form::open([ 'url' => route('record-delete'), 'id' => 'frm_list', 'method' => 'delete']) !!}
    <div class="row">
      <div class="col-lg-12 equel-grid">
        <div class="grid">
          <div class="grid-header">
            <div class="title">Records</div>
            <div class="actions">
              <div class="btn-group btn-group-sm" role="group" aria-label="...">
                <button type="button" class="btn btn-success" onclick="location.href='{{ route("imp-view") }}'">Import Records</button>
                  &nbsp;&nbsp; &nbsp;&nbsp;
                {{--<button type="button" class="btn btn-success has-icon" onclick="location.href='{{ route("record-add") }}'"><i class="mdi mdi-plus"></i>Add</button>--}}
                <button type="button" onClick="doDelete()" class="btn btn-danger has-icon"><i class="mdi mdi-delete"></i>Delete</button>
              </div>
            </div>
          </div>
          <div class="grid-body">
            <table width="100%" class="table table-striped table-bordered table-hover table-checkable" id="dataList" >
              <thead>
              <tr role="row" class="heading">
                <th><input type="checkbox" class="check-all"></th>
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

  <script src="{{ asset('admin/assets/vendors/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset("admin/assets/vendors/datatables/datatables.bundle.js") }}" type="text/javascript"></script>@endsection
@section('javascripts')
<script language="javascript">
	Globals["urlList"] = '{{ route("record-get-list") }}';
	{{--Globals["urlUpdateStatus"] = '{{ route("user-update-status") }}';--}}
		Globals['body'] = [];

	Globals["disableOrderColumns"] = [0];
    Globals["dtDom"] = "lBfrtip";
	Globals["className"] = "btn btn-info btn-sm";
    Globals["dtButtons"] = [
        {
            extend: 'excel',
			title: 'Record List ',
            text: '<i class="fa fa-file-excel-o"></i> Excel',
            className: Globals["className"]
        },
		{
			extend: 'pdfHtml5',
			orientation: 'landscape',
			title: 'Record List ',
			text: '<i class="fa fa-file-pdf-o"></i> PDF',
			className: Globals["className"],
			pageSize: 'LEGAL',
			customize: function(doc) {
				doc.styles.title = {
					fontSize: '24',
					fontStyle: 'bold',
					bold: true,
					margin: [10, 5, 0, 10],
				}


				doc.pageMargins = [20,0,-15,30];
				var tblBody = doc.content[1].table.body;
				doc.defaultStyle.fontSize = 10;

				// ***
				//This section creates a grid border layout
				// ***
				doc.content[1].layout = {
					hLineWidth: function(i, node) {
						return (i === 0 || i === node.table.body.length) ? 2 : 1;},
					vLineWidth: function(i, node) {
						return (i === 0 || i === node.table.widths.length) ? 2 : 1;},
					hLineColor: function(i, node) {
						return (i === 0 || i === node.table.body.length) ? 'black' : 'gray';},
					vLineColor: function(i, node) {
						return (i === 0 || i === node.table.widths.length) ? 'black' : 'gray';}
				};
				// ***
				//This section loops thru each row in table looking for where either
				//the second or third cell is empty.
				//If both cells empty changes rows background color to '#FFF9C4'
				//if only the third cell is empty changes background color to '#FFFDE7'
				// ***
				$('#dataList').find('tr').each(function (ix, row) {
					var index = ix;
					var rowElt = row;
					$(row).find('td').each(function (ind, elt) {
						if (tblBody[index][1].text == '' && tblBody[index][2].text == '') {
							delete tblBody[index][ind].style;
							tblBody[index][ind].fillColor = '#FFF9C4';
						}
						else
						{
							if (tblBody[index][2].text == '') {
								delete tblBody[index][ind].style;
								tblBody[index][ind].fillColor = '#FFFDE7';
							}
						}
					});
				});
			}
		},
        {
            extend: 'csv',
			title: 'Record List ',
            text: '<i class="fa fa-file-text-o"></i> CSV',
            className: Globals["className"]
        },
        {
			title: 'Record List ',
			orientation: 'landscape',
            extend: 'print',
            text: '<i class="fa fa-print"></i> Print',
            className: Globals["className"],
			customize: function ( win ) {
				$(win.document.body)
					.css( 'font-size', '10pt' );
				$(win.document.body)
			        .css( 'font-weight', 'bold' );

				$(win.document.body).find( 'table' )
					.addClass( 'compact' )
					.css( 'font-size', 'inherit' );
			}
        }
    ];
  Globals["defaultOrderColumns"] = [[1, "asc"]];
</script>
<script src="{{ asset("admin/assets/scripts/datatable-instance.js") }}" type="text/javascript"></script>
@endsection