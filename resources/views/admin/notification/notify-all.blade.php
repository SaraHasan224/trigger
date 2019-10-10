@extends('layouts.admin')
@section('styles')
    <style>

        .pagination{
            float:right;
            margin-top: 50px;
            background-color: #ffffff85;
        }
        .page-item{

            background-color: #ffffff85;
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
                                        {{--<div class="fc-left"><h2>{{$current->startOfWeek()->format("M j")}} - {{$current->endOfWeek()->format("M j,Y")}}</h2></div>--}}
                                        <div class="fc-left"><h2>View All Notifications</h2></div>
                                        <div class="fc-center"></div>
                                        <div class="fc-clear"></div>
                                    </div>
                                    <div class="fc-view-container" style="">
                                        <div class="fc-view fc-listWeek-view fc-list-view fc-widget-content" style="">
                                            <div class="fc-scroller">
                                                <table class="fc-list-table ">
                                                    <tbody>
                                                    @foreach($notifications as $key => $notify)
                                                        {{--<tr class="fc-list-heading" data-date="2019-03-11">--}}
                                                            {{--<td class="fc-widget-header" colspan="3"><a--}}
                                                                        {{--class="fc-list-heading-main"--}}
                                                                        {{--data-goto="{&quot;date&quot;:&quot;2019-03-11&quot;,&quot;type&quot;:&quot;day&quot;}">{{Carbon\Carbon::parse($key)->format("l")}}</a><a--}}
                                                                        {{--class="fc-list-heading-alt"--}}
                                                                        {{--data-goto="{&quot;date&quot;:&quot;2019-03-11&quot;,&quot;type&quot;:&quot;day&quot;}">{{Carbon\Carbon::parse($key)->format("F j,Y")}}</a></td>--}}
                                                        {{--</tr>--}}
                                                        {{--@foreach($notifier  as $notify)--}}
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
                                                                if (Auth::user()->user_type == 1) {
                                                                    $color_code =   ($notify->is_sadmin_read == 0) ?  "rgba(255, 95, 102, 1)" :  "rgb(108, 97, 246,1)";
                                                                    $style = ($notify->is_sadmin_read == 0) ? "dropdown-list-unread" : "";
                                                                    $super_id = ($notify->is_sadmin_read == 0) ? 0 : 1;
                                                                    $user_id = "";
                                                                }
                                                                else {
                                                                    $color_code =  ($notify->is_read == 0) ?  "rgba(255, 95, 102, 1)" :  "rgb(108, 97, 246,1)";
                                                                    $style = ($notify->is_read == 0) ? "dropdown-list-unread" : "";
                                                                    $super_id = "";
                                                                    $user_id = ($notify->is_read == 0) ? 0 : 1;
                                                                }
                                                            ?>

                                                            <td class="fc-list-item-time fc-widget-content">{{$totalDuration}}</td>
                                                            <td class="fc-list-item-marker fc-widget-content"><span  class="fc-event-dot" data-notify_id="{{$notify->id}}" data-super_id="{{$super_id}}" data-user_id="{{$user_id}}" style="background-color: {{$color_code}}"></span></td>
                                                            <td class="fc-list-item-title fc-widget-content"><a href="{{ url($notify->link) }}">{{$notify->message}}</a></td>
                                                        </tr>
                                                        {{--@endforeach--}}
                                                        {{--<div class="pagination">--}}
                                                            {{--{{ $notifier->links() }}--}}
                                                        {{--</div>--}}
                                                        <!--an simple table ...-->
                                                    @endforeach
                                                </table>
                                            </div>
                                            <div class="fc-scroller">
                                                {{ $notifications->links()}}
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


		$(document).on('click',".fc-event-dot",function(event) {
			var notify_id = $(this).attr("data-notify_id");
			var super_id = $(this).attr("data-super_id");
			var user_id = $(this).attr("data-user_id");
//			console.log("=============================================================================");
//			console.log("Before: notify_id= "+notify_id+" super_admin = "+super_id+" is_user = "+user_id);
//			console.log($( "span[data-notify_id="+notify_id+"]" )[0]);
			event.preventDefault();
			$.ajax({
				type: "POST",
				url: '{{route('read-all-notification')}}',
				data: {
					'notify_id' : notify_id,
					'super_id' : super_id,
					'user_id' : user_id,
				},
				success: function (response) {
//					console.log(response);
                    // Check if admin has read the notification or not
					var admin_read = (response["admin_read"] == 1) ? 1 : 0;
					var user_read = (response["user_read"] == 1) ? 1 : 0;
//					console.log(response['admin_read'],response['user_read']);
					// Assign revised values to data.* paramters
					$( "span[data-notify_id="+notify_id+"]" )[0].dataset.super_id = admin_read;
					$( "span[data-notify_id="+notify_id+"]" )[0].dataset.user_id = user_read;
					//  Redefine super_read and user_read;
					var super_id = $( "span[data-notify_id="+notify_id+"]" )[0].dataset.super_id;
					var user_id = $( "span[data-notify_id="+notify_id+"]" )[0].dataset.user_id;
//					console.log("After: notify_id= "+notify_id+" super_admin = "+super_id+" is_user = "+user_id);
                    if(response["admin_read"] == 1 && super_id == 1)
                    {
						$( "span[data-notify_id="+notify_id+"]" )[0].style.background = "rgba(108, 97, 246,1)";
                    }
                    else if(response["admin_read"] == 0 && super_id == 0){
//                    	console.log($( "span[data-notify_id="+notify_id+"]" )[0]);
						$( "span[data-notify_id="+notify_id+"]" )[0].style.background = "rgba(255, 95, 102, 1)";
                    }
                    else if(response["user_read"] == 0 && user_id == 1)
					{
						$( "span[data-notify_id="+notify_id+"]" )[0].style.background = "rgba(255, 95, 102, 1)";
					}
					else if(response["user_read"] == 1 && user_id == 0){
						$( "span[data-notify_id="+notify_id+"]" )[0].style.background = "rgba(108, 97, 246,1)"
					}

				}
			});
		});
    </script>
@endsection