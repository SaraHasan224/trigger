<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Sara Hasan, sara@clickysoft.com">
  <meta name="copyright" content="Clickysoft">
  <meta name="owner" content="John Pagliaro">
  <title>Trigger - Administrator Panel</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset("admin/assets/vendors/iconfonts/mdi/css/materialdesignicons.css") }}"/>
  <link rel="stylesheet" href="{{ asset("admin/assets/vendors/iconfonts/font-awesome/css/font-awesome.css") }}" />
  <link rel="stylesheet" href="{{ asset("admin/assets/vendors/css/vendor.addons.css") }}"/>
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset("admin/assets/css/shared/style.css") }}"/>
  <link rel="stylesheet" href="{{ asset("admin/assets/css/sweet_alert/sweetalert.css") }}"/>
  <!-- endinject -->
  <!-- Layout style -->
  <link rel="stylesheet" href="{{ asset("admin/assets/css/demo_1/style.css") }}"/>
  <link rel="stylesheet" href="{{ asset("admin/assets/css/custom.css") }}"/>
  <!-- Layout style -->
  <link rel="shortcut icon" href="{{ asset("admin/assets/images/favicon.ico") }}"/>

  <link rel="stylesheet" href="{{ asset("js/modal/mdb.min.css") }}"/>
  @yield("styles")

</head>
<body class="header-fixed">

@include("admin/includes/header")
<!-- partial -->
<div class="page-body">
  @include("admin/includes/sidebar")
  <div class="page-content-wrapper">
    <div class="page-content-wrapper-inner">
      @yield("contents")
    </div>
    @include("admin/includes/footer")
  </div>
  <!-- page content ends -->
</div>
<form id="frmLogout" action="{{ route('logout') }}" method="POST" style="display: none;">
  @csrf
</form>
<div class="modal fade" id="MessageModal" tabindex="-1" role="dialog" aria-labelledby="MessageModalLabel">
  <div class="modal-dialog" role="document" id="dail" >
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="MessageModalLabel"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <h5></h5>
      </div>
      <div class="modal-footer"> </div>
    </div>
  </div>
</div>
<!-- Side Modal Top Right -->
{{--<!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->--}}
{{--<script src="https://www.gstatic.com/firebasejs/4.6.1/firebase.js"></script>--}}
{{--<script src="https://www.gstatic.com/firebasejs/4.1.3/firebase-app.js"></script>--}}
{{--<script src="https://www.gstatic.com/firebasejs/4.1.3/firebase-messaging.js"></script>--}}

{{--<!-- If you enabled Analytics in your project, add the Firebase SDK for Analytics -->--}}
{{--<script src="https://www.gstatic.com/firebasejs/7.0.0/firebase-analytics.js"></script>--}}
<!-- Initialized firebase object -->
{{--<script src="{{ asset("js/firebase/init.js") }}"></script>--}}
<!--page body ends -->
<!-- SCRIPT LOADING START FORM HERE /////////////-->
<!-- plugins:js -->
<script src="{{ asset("admin/assets/vendors/js/core.js") }}"></script>
<script src="{{ asset("admin/assets/vendors/js/vendor.addons.js") }}"></script>
<!-- build:js -->
<script src="{{ asset("admin/assets/js/template.js") }}"></script>
<script src="{{ asset("admin/assets/js/notifications.js") }}"></script>
<script src="{{ asset("admin/assets/js/sweet_alert/sweetalert.js") }}"></script>
<!-- endbuild -->
<script src="{{ asset("js/modal/mdb.min.js") }}"></script>

@yield("js_plugins")
<script>
	var Globals = {!! json_encode([
    'url' => url('/')
  ]) !!};
	$.ajaxSetup({
		"headers": {"X-CSRF-TOKEN": "{{ csrf_token() }}"}
	});

	$(document).ready(function(){
		// we call the function
		ajaxCall();
		setInterval(ajaxCall, 90000); //90000 MS == 1.5 min
	});
	function ajaxCall() {
		$.ajax({
			type: "GET",
			url: '{{route('recieve-notification')}}',
			success: function (response) {
				$('.dropdown-body').empty();
				$('.dropdown-body').append(response);
			}
		});
	}
	$(document).on('click',".dropdown-list",function(event) {
		var notify_id = $(this).attr("data-notify_id");
		var super_id = $(this).attr("data-super_id");
		var user_id = $(this).attr("data-user_id");
		var is_admin = $(this).attr("data-is_admin");
//        console.log(notify_id,super_id,user_id,is_admin);
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: '{{route('read-notification')}}',
			data: {
				'notify_id' : notify_id,
				'super_id' : super_id,
				'user_id' : user_id,
				'is_admin' : is_admin
			},
			success: function (response) {
				$('.dropdown-body').empty();
				$('.dropdown-body').append(response);
			}
		});
	});
</script>
@yield("javascripts")
<script src="{{ asset("admin/assets/js/common.js") }}"></script>
</body>
</html>