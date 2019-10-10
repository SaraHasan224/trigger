<?php



namespace App\Http\Controllers\Admin;



use App\Http\Controllers\AdminController;

//use GuzzleHttp\Psr7\Request;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Spatie\Permission\Models\Role;

use Spatie\Permission\Models\Permission;

use App\Notification;
use Session;
use Carbon\Carbon;
use Auth;
use DB;

class Dashboard extends AdminController {

    function __construct() {
		parent::__construct();
    }

    public function index() {
       return view('admin.dashboard',$this->data);
    }

	public function create_permission() {
    	$permissions = [
	    ];
    	foreach($permissions as $permission) {
		    $permission = Permission::create( [ 'name' => $permission ] );
	    }
	    echo "Done !";
	}

    public function notification() {
        if(auth()->user()->user_type == 1) {
            $notifications = Notification::orderBy('dated','DESC')
                            ->select([
                                    'id',
                                    'to_type',
                                    'to_id',
                                    'from_type',
                                    'from_id',
                                    'message',
                                    'link',
                                    'class',
                                    'icon',
                                    'is_read',
                                    'is_sadmin_read',
                                        'dated',
                                    DB::raw('DATE(dated) as date1')
//                                    DB::raw('dated as c_date')
                             ])->paginate(50);
//            ->groupBy('date1');


        }
        else{
            $notifications = Notification::orderBy('id','DESC')->where('from_id',auth()->user()->id)->select('id','to_type','to_id','from_type','from_id','message','link','class','icon','is_read','is_sadmin_read', 'dated', DB::raw('DATE(dated) as date'),DB::raw('dated as c_date'))
                ->get()
                ->groupBy('date');
        }
        $this->data['notifications'] = $notifications;
        $this->data['current'] = Carbon::now();
        return view('admin.notification.notify-all',$this->data);
    }

    public function readAllNotification(Request $request)
    {
        if ($request->isMethod('post')) {
            $input = $request->all();
//            dd($input);
            /*
              "notify_id" => "17"
              "super_id" => "1"
              "user_id" => null
            */
            $user_read = 0;
            $admin_read = 0;
            if($request->user_id != "")
            {
                Notification::where('id', $request->notify_id)
                    ->update([
                        'is_read' => ($request->user_id == 1) ? 0 : 1,
                    ]);
                $admin_read = ($request->super_id == 1) ? 0 :1;
            }else{
                Notification::where('id', $request->notify_id)
                    ->update([
                        'is_sadmin_read' => ($request->super_id == 1) ? 0 : 1
                    ]);
                $user_read = ($request->user_id == 1) ? 0 :1;
            }
            $response = [
                'admin_read' => $admin_read,
                'user_read' => $user_read,
            ];
            return response()->json($response);
        }
    }
    public function recieveNotification()
    {
        if(Auth::user()->user_type == 1)
        {
            $notification = Notification::orderBy('id','desc')->limit(5)->get();
            $notifications_count = Notification::where([
                'is_sadmin_read'=>0
            ])->count();
        }else{
            $notification = Notification::where([
                'to_type'=> auth()->user()->user_type,
                'to_id'=> auth()->user()->id
            ]) ->orderBy('id','desc')
                ->limit(5)
                ->get();

            $notifications_count = Notification::where([
                'to_type'=> auth()->user()->user_type,
                'to_id'=> auth()->user()->id,
                'is_read'=>0
            ])->count();
        }
        $response = "";
            foreach($notification as $notify) {
                if (Auth::user()->user_type == 1) {
                    $style = ($notify->is_sadmin_read == 0) ? "dropdown-list-unread" : "";
                    $super_id = ($notify->is_sadmin_read == 0) ? 0 : 1;
                    $user_id = 0;
                    $admin = 1;
                }
                else {
                    $style = ($notify->is_read == 0) ? "dropdown-list-unread" : "";
                    $super_id = 0;
                    $user_id = ($notify->is_read == 0) ? 0 : 1;
                    $admin = 0;
                }
                $startTime = \Carbon\Carbon::parse($notify->dated);
                $finishTime = \Carbon\Carbon::parse(date('Y-m-d H:i:s'));


                $totalDayDuration = $totalHourDuration = $totalMinDuration = $totalSecDuration = 0;
                $totalSecDuration = $finishTime->diffInSeconds($startTime);
                $totalDuration = $totalSecDuration . ' seconds ago';
                $totalDayDuration = $finishTime->diffInDays($startTime);
                if ($totalSecDuration == 0) {
                    $totalMinDuration = $finishTime->diffInMinutes($startTime);
                    $totalDuration = $totalMinDuration . ' minutes ago';
                }
                if ($totalMinDuration == 0) {
                    $totalHourDuration = $finishTime->diffInHours($startTime);
                    $totalDuration = $totalHourDuration . ' hours ago';
                }
                if ($totalDayDuration > 0 && $totalHourDuration > 0) {
                    $totalDuration = $totalDayDuration . ' days ago';
                }
                $response .= '<div class="dropdown-list ' . $style . '" data-notify_id="' . $notify->id . '" data-is_admin="' . $admin . '" data-super_id="' . $super_id . '" data-user_id="' . $user_id . '">' . '<div class="icon-wrapper rounded-circle ' . $notify->class . '"><i class="' . $notify->icon . '"></i></div>'.
                                '<div class="content-wrapper">'.
                                    '<small class="name" style="white-space: pre-line; " ><a href="' . route("all-notification") . '" style="text-decoration: none;">' . $notify->message . '</a></small> <br/>'.
                                    '<small class="content-text">' . $totalDuration . '</small>'.
                                '</div>'.
                             '</div>';
                }
        return response()->json($response);
    }

    public function readNotification(Request $request)
    {
        if($request->isMethod('post'))
        {
            $input = $request->all();
            if($request->is_admin == 1 && $request->super_id == 0)
            {
                Notification::where('id',$request->notify_id)
                    ->update([
                        'is_sadmin_read' => 1,
                    ]);
            }
            elseif($request->is_admin == 0 && $request->user_id == 0)
            {
                Notification::where('id',$request->notify_id)
                    ->update([
                        'is_read' => 1,
                    ]);
            }
            if(Auth::user()->user_type == 1)
            {
                $notification = Notification::orderBy('id','desc')->limit(5)->get();
                $notifications_count = Notification::where([
                    'is_sadmin_read'=>0
                ])->count();
            }else{
                $notification = Notification::where([
                    'to_type'=> auth()->user()->user_type,
                    'to_id'=> auth()->user()->id
                ]) ->orderBy('id','desc')
                    ->limit(5)
                    ->get();

                $notifications_count = Notification::where([
                    'to_type'=> auth()->user()->user_type,
                    'to_id'=> auth()->user()->id,
                    'is_read'=>0
                ])->count();
            }
            $response = "";
            foreach($notification as $notify) {
                if (Auth::user()->user_type == 1) {
                    $style = ($notify->is_sadmin_read == 0) ? "dropdown-list-unread" : "";
                    $super_id = ($notify->is_sadmin_read == 0) ? 0 : 1;
                    $user_id = 0;
                    $admin = 1;
                }
                else {
                    $style = ($notify->is_read == 0) ? "dropdown-list-unread" : "";
                    $super_id = 0;
                    $user_id = ($notify->is_read == 0) ? 0 : 1;
                    $admin = 0;
                }
                $startTime = \Carbon\Carbon::parse($notify->dated);
                $finishTime = \Carbon\Carbon::parse(date('Y-m-d H:i:s'));


                $totalDayDuration = $totalHourDuration = $totalMinDuration = $totalSecDuration = 0;
                $totalSecDuration = $finishTime->diffInSeconds($startTime);
                $totalDuration = $totalSecDuration . ' seconds ago';
                $totalDayDuration = $finishTime->diffInDays($startTime);
                if ($totalSecDuration == 0) {
                    $totalMinDuration = $finishTime->diffInMinutes($startTime);
                    $totalDuration = $totalMinDuration . ' minutes ago';
                }
                if ($totalMinDuration == 0) {
                    $totalHourDuration = $finishTime->diffInHours($startTime);
                    $totalDuration = $totalHourDuration . ' hours ago';
                }
                if ($totalDayDuration > 0 && $totalHourDuration > 0) {
                    $totalDuration = $totalDayDuration . ' days ago';
                }
                $response .= '<div class="dropdown-list ' . $style . '" data-notify_id="' . $notify->id . '" data-is_admin="' . $admin . '" data-super_id="' . $super_id . '" data-user_id="' . $user_id . '">' . '<div class="icon-wrapper rounded-circle ' . $notify->class . '"><i class="' . $notify->icon . '"></i></div>'.
                    '<div class="content-wrapper">'.
                    '<small class="name" style="white-space: pre-line; " ><a href="' . route("all-notification") . '" style="text-decoration: none;">' . $notify->message . '</a></small> <br/>'.
                    '<small class="content-text">' . $totalDuration . '</small>'.
                    '</div>'.
                    '</div>';
            }
            return response()->json($response);
        }
    }

    public function get_roles(Request $request)
    {
        if($request->isMethod('POST'))
        {
            $response = "";
            $roles = DB::table('roles')->get();
            foreach ($roles as $role)
            {
                $response .= '<option value="'.$role->id.'">'.$role->name.'</option>';
            }
            return response()->json($response);
        }
    }
    public function generate_reg_link(Request $request)
    {
        if($request->isMethod('POST'))
        {
            $data = $request->all();

            $auth_id = Auth::user()->id;
            $registeration_link = url('register/'.$auth_id.'/'.$request->role_id);
            $response = '<p>Here is the registeration link: </p>'.
                         '<p><a href="'.$registeration_link.'" class="blue-text" target="_blank">'.$registeration_link.'</a></p>';
            return response()->json($response);
        }
    }
}

