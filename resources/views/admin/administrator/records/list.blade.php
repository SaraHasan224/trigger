@extends('layouts.admin')
@section('stylesheets')
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/vendors/datatables/datatables.min.css') }}"/>
  <link href="{{ asset("admin/assets/vendors/datatables/datatables.bundle.css") }}" rel="stylesheet" type="text/css" />
    <style>
        .landscape {page: land;}
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
    {!! Form::open([ 'url' => route('record-delete'), 'id' => 'frm_list', 'method' => 'DELETE']) !!}
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
                {{--<div id="dataList_filter" class="dataTables_filter" style="float: right;"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="dataList"></label></div>--}}
                <thead>
                    <tr role="row" class="heading">
                        <th><input type="checkbox" class="check-all"></th>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
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
                          @if(auth()->user()->user_type == 1)
                        <th>Added</th>
                        <th>Modified</th>
                          @endif
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
				<tfoot>
					<tr>
						<th></th>
						<th></th>
					<th>
						First Name <br/>
						<select name="first_name" id="first_name"  class="form-control" >
							<option value="">Select First Name</option>
							@foreach($Record['first_name'] as $key => $row)
								<option value="{{ $row }}">{{ $row }}</option>
							@endforeach
						</select>
					</th>
					<th>
						Middle Name <br/>
						<select name="middle_name" id="middle_name" class="form-control" >
							<option value="">Select Last Name</option>
							@foreach($Record['middle_name'] as $row)
								<option value="{{ $row }}">{{ $row }}</option>
							@endforeach
						</select>
					</th>
					<th>
						Last Name <br/>
						<select name="last_name" id="last_name" class="form-control" >
							<option value="">Select Last Name</option>
							@foreach($Record['last_name'] as $row)
								<option value="{{ $row }}">{{ $row }}</option>
							@endforeach
						</select>
					</th>
					<th>
						Email Address <br/>
						<select name="email" id="email" class="form-control" >
							<option value="">Select Email Address</option>
							@foreach($Record['email'] as $row)
								<option value="{{ $row }}">{{ $row }}</option>
							@endforeach
						</select>
					</th>
					<th>
						Current Street <br/>
						<select name="current_street" id="current_street" class="form-control" >
							<option value="">Select Current Street</option>
							@foreach($Record['current_street'] as $row)
								<option value="{{ $row }}">{{ $row }}</option>
							@endforeach
						</select>
					</th>
					<th>
						Current City <br/>
						<select name="current_city" id="current_city" class="form-control" >
							<option value="">Select Current City</option>
							@foreach($Record['current_city'] as $row)
								<option value="{{ $row }}">{{ $row }}</option>
							@endforeach
						</select>
					</th>
					<th>
						Current State <br/>
						<select name="current_state" id="current_state" class="form-control" >
							<option value="">Select Current State</option>
							@foreach($Record['current_state'] as $row)
								<option value="{{ $row }}">{{ $row }}</option>
							@endforeach
						</select>
					</th>
					<th>
						Current ZIP Code <br/>
						<select name="current_zip" id="current_zip" class="form-control" >
							<option value="">Select Current ZIP Code</option>
							@foreach($Record['current_zip'] as $row)
								<option value="{{ $row }}">{{ $row }}</option>
							@endforeach
						</select>
					</th>
					<th>
						Phone Number <br/>
						<select name="phone_no" id="phone_no" class="form-control" >
							<option value="">Select Phone Number</option>
							@foreach($Record['phone_no'] as $row)
								<option value="{{ $row }}">{{ $row }}</option>
							@endforeach
						</select>
					</th>
					<th>
						Old Street <br/>
						<select name="old_street" id="old_street" class="form-control" >
							<option value="">Select Old Street</option>
							@foreach($Record['old_street'] as $row)
								<option value="{{ $row }}">{{ $row }}</option>
							@endforeach
						</select>
					</th>
					<th>
						Old City <br/>
						<select name="old_city" id="old_city" class="form-control" >
							<option value="">Old City</option>
							@foreach($Record['old_city'] as $row)
								<option value="{{ $row }}">{{ $row }}</option>
							@endforeach
						</select>
					</th>
					<th>
						Old State <br/>
						<select name="old_state" id="old_state" class="form-control" >
							<option value="">Old State</option>
							@foreach($Record['old_state'] as $row)
								<option value="{{ $row }}">{{ $row }}</option>
							@endforeach
						</select>
					</th>
					<th>
						Old ZIP Code <br/>
						<select name="old_zip" id="old_zip" class="form-control" >
							<option value="">Select Old ZIP Code</option>
							@foreach($Record['old_zip'] as $row)
								<option value="{{ $row }}">{{ $row }}</option>
							@endforeach
						</select>
					</th>
					<th>
						Date of Birth<br/>
						<select name="dob" id="dob" class="form-control" >
							<option value="">Select Date of Birth</option>
							@foreach($Record['dob'] as $row)
								<option value="{{ $row }}">{{ $row }}</option>
							@endforeach
						</select>
					</th>
					<th>
						Current Employer <br/>
						<select name="current_emp" id="current_emp" class="form-control">
							<option value="">Select Current Employer</option>
							@foreach($Record['current_emp'] as $row)
								<option value="{{ $row }}">{{ $row }}</option>
							@endforeach
						</select>
					</th>
					<th>
						Policy number <br/>
						<select name="policy_number" id="policy_number" class="form-control">
							<option value="">Select Policy number</option>
							@foreach($Record['policy_number'] as $row)
								<option value="{{ $row }}">{{ $row }}</option>
							@endforeach
						</select>
					</th>
					<th>
						Line of Business <br/>
						<select name="line_of_business" id="line_of_business" class="form-control">
							<option value="">Select Line of Business</option>
							@foreach($Record['line_of_business'] as $row)
								<option value="{{ $row }}">{{ $row }}</option>
							@endforeach
						</select>
					</th>
					<th>
						Claim number <br/>
						<select name="claim_number" id="claim_number" class="form-control">
							<option value="">Select Claim number</option>
							@foreach($Record['claim_number'] as $row)
								<option value="{{ $row }}">{{ $row }}</option>
							@endforeach
						</select>
					</th>
					<th>
						Loss Date <br/>
						<select name="loss_date" id="loss_date" class="form-control">
							<option value="">Select Loss Date</option>
							@foreach($Record['loss_date'] as $row)
								<option value="{{ $row }}">{{ $row }}</option>
							@endforeach
						</select>
					</th>
					<th>
						Claim description <br/>
						<select name="claim_desc" id="claim_desc" class="form-control">
							<option value="">Select Claim description</option>
							@foreach($Record['claim_desc'] as $row)
								<option value="{{ $row }}">{{ $row }}</option>
							@endforeach
						</select>
					</th>
						<th>Added</th>
						<th>Modified</th>
						<th>Actions</th>
				</tr>
				</tfoot>
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
  <script src="{{ asset("admin/assets/vendors/datatables/datatables.bundle.js") }}" type="text/javascript"></script>
    <script src="{{ asset('https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js') }}" type="application/javascript"></script>
@endsection
@section('javascripts')
<script language="javascript">
	$(document).ready(function(){
		Globals["urlList"] = '{{ route("record-get-list") }}';
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


					doc.pageMargins = [20,20,20,30];
					var tblBody = doc.content[1].table.body;
					doc.defaultStyle.fontSize = 8;

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
				extend: 'print',
				text: '<i class="fa fa-print"></i> Print',
				className: Globals["className"],
				customize: function ( win ) {
					var last = null;
					var current = null;
					var bod = [];

					var css = '@page { size: landscape; }',
						head = win.document.head || win.document.getElementsByTagName('head')[0],
						style = win.document.createElement('style');

					style.type = 'text/css';
					style.media = 'print';

					if (style.styleSheet)
					{
						style.styleSheet.cssText = css;
					}
					else
					{
						style.appendChild(win.document.createTextNode(css));
					}

					head.appendChild(style);


					$(win.document.body).find('title')
						.css( 'font-size', '24pt' )
						.css( 'font-weight', 'bold' )
						.css( 'margin', '10pt 5pt 0pt 10pt' );


					$(win.document.body)
						.addClass( 'landscape' )
						.css( 'font-size', '9pt' )
						//					.css( 'page', 'land' )
						.css( 'font-weight', 'bold' );

					$(win.document.body).find('grid-body').addClass('table-responsive');

					$(win.document.body).find( 'table' )
						.addClass( 'compact' )
						.css('width', '95%')
						.css( 'font-size', 'inherit' );
				}
			}
		];
		Globals["defaultOrderColumns"] = [[1, "asc"]];
		Globals["dtSearching"] = false;
	});
</script>
<script src="{{ asset("admin/assets/scripts/datatable-customsearching.js") }}" type="text/javascript"></script>
@endsection