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
                <li class="breadcrumb-item active" aria-current="page">View All Notifications</li>
            </ol>
        </nav>
    </div>
    <div class="content-viewport">
        <div class="row">
            <div class="col-md-12 calendar-page-wrapper">
                <div class="grid">
                    <div class="row">
                        <div class="col-md-12 order-md-4 calendar-container">
                            <div class="grid-body">
                                <div id="calendar" class="fc fc-unthemed fc-ltr">
                                    <div class="fc-toolbar fc-header-toolbar">
                                        <div class="fc-left"><h2>{{$current->startOfWeek()->format("M j")}} - {{$current->endOfWeek()->format("M j,Y")}}</h2></div>
                                        <div class="fc-center"></div>
                                        <div class="fc-clear"></div>
                                    </div>
                                    <div class="fc-view-container" style="">
                                        <div class="fc-view fc-listWeek-view fc-list-view fc-widget-content" style="">
                                            <div class="fc-scroller">
                                                <table class="fc-list-table ">
                                                    <tbody>
                                                    @foreach($notifications as $key => $notifier)
                                                        <tr class="fc-list-heading" data-date="2019-03-11">
                                                            <td class="fc-widget-header" colspan="3"><a
                                                                        class="fc-list-heading-main"
                                                                        data-goto="{&quot;date&quot;:&quot;2019-03-11&quot;,&quot;type&quot;:&quot;day&quot;}">{{Carbon\Carbon::parse($key)->format("l")}}</a><a
                                                                        class="fc-list-heading-alt"
                                                                        data-goto="{&quot;date&quot;:&quot;2019-03-11&quot;,&quot;type&quot;:&quot;day&quot;}">{{Carbon\Carbon::parse($key)->format("F j,Y")}}</a></td>
                                                        </tr>
                                                        @foreach($notifier as $notify)
                                                            <tr class="fc-list-item">
                                                                <?php
                                                                $startTime = \Carbon\Carbon::parse($notify->dated);
                                                                $finishTime = \Carbon\Carbon::parse(date('Y-m-d H:i:s'));
                                                                $totalDayDuration = $finishTime->diffInDays($startTime);
                                                                $totalDuration = $totalDayDuration.' days ago';
                                                                if($totalDayDuration == 0)
                                                                {
                                                                    $totalHourDuration =  $finishTime->diffInHours($startTime);
                                                                    $totalMinDuration =  $finishTime->diffInMinutes($startTime);
                                                                    $totalSecDuration =  $finishTime->diffInSeconds($startTime);
                                                                    if($totalHourDuration > 0)
                                                                    {
                                                                        $totalDuration = $totalHourDuration.' hours ago';
                                                                    }
                                                                    elseif($totalMinDuration > 0)
                                                                    {
                                                                        $totalDuration = $totalMinDuration.' minutes ago';
                                                                    }
                                                                    elseif ($totalSecDuration > 0)
                                                                    {
                                                                        $totalDuration = $totalSecDuration.' seconds ago';
                                                                    }
                                                                }
                                                                ?>
                                                                <?php
                                                                if(auth()->user()->user_type == 1) {
                                                                    $color_code =   ($notify->is_sadmin_read == 0) ?  "#ff5f66" :  "#6c61f6";
                                                                }
                                                                else{
                                                                    $color_code =  ($notify->is_read == 0) ?  "#ff5f66" :  "#00e093";
                                                                }
                                                                ?>
                                                                <td class="fc-list-item-time fc-widget-content">{{$totalDuration}}</td>
                                                                <td class="fc-list-item-marker fc-widget-content"><span  class="fc-event-dot" data-notify_id="{{$notify->id}}" style="background-color: {{$color_code}}"></span></td>
                                                                <td class="fc-list-item-title fc-widget-content"><a href="{{ url($notify->link) }}">{{$notify->message}}</a></td>
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                    </tbody>
                                                </table>
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
    </div>

@endsection
@section('js_plugins')
    <!-- Vendor Js For This Page Ends-->
    <script src="{{asset('public/vendor/fullcalendar/fullcalendar.min.jS')}}"></script>
    <!-- Vendor Js For This Page Ends-->
    <!-- build:js -->
    <script src="{{asset('public/js/template.js')}}"></script>
    <script>

		$(document).ready(function(){
			// we call the function
			ajaxCall();
			setInterval(ajaxCall, 90000); //90000 MS == 1.5 min
		});
		function ajaxCall() {
			$.ajax({
				type: "GET",
				url: '{{route('all-notification')}}',
				success: function (response) {
					$('.fc-list-table').append(response);
				}
			});
		}
		$(document).on('click',".fc-event-dot",function(event) {
			var notify_id = $(this).attr("data-notify_id");
			console.log(notify_id);
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
    </script>
@endsection