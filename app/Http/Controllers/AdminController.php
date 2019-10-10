<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Notification;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Support\Facades\Auth;
use Session;
class AdminController extends MasterController {

	public $_Status;
    public $user_info;

    function __construct() {
	    $this->_Status = ['<span class="m-badge m-badge--danger m-badge--wide record-{id}">Deactive</span>', '<span class="m-badge m-badge--success m-badge--wide record-{id}">Active</span>'];
        $this->data['now'] = Carbon::now(config('app.timezone'));
        if(Session::get('User_Type') == 1)
        {
            $this->data["notification"] = Notification::orderBy('id','desc')->limit(5)->get();
            $this->data["notifications_count"] = Notification::where([
                'is_sadmin_read'=>0
            ])->count();
        }else{
            $userType = Session::get('User_Type');
            $userId = Session::get('User_ID');
            $this->data["notification"] = Notification::where([
                'to_type'=> $userType,
                'to_id'=> $userId
            ])
                ->orderBy('id','desc')
                ->limit(5)
                ->get();
            if($userType = "" || $userId == "")
            {
                auth()->logout();
                session()->flush();
                return view('auth.login');
            }else{
                $this->data["notifications_count"] = Notification::where([
                    'to_type'=> $userType,
                    'to_id'=> $userId,
                    'is_read'=>0
                ])->count();
            }

        }
//        if(auth()->user()->user_type == 1) {
//            $this->data['notification'] = Notification::orderBy('id','DESC')->take(6)->get();
//        }else{
//            $this->data['notification'] = Notification::where('from_id',auth()->user()->id)->orderBy('id','DESC')->take(6)->get();
//        }
        $array = [];
        $super_ids = User::select('id')->where('user_type',1)->get();
        foreach ($super_ids as $id)
        {
            $array = $id['id'];
        }
        $this->to_id = $array;

        parent::__construct();
    }

    public function check_access($permission, $ajax = false) {
        if(auth()->user()->user_type == 1) {
            return true;
        } else {
            $hasPermission = auth()->user()->hasPermissionTo($permission);
            if(!$hasPermission) {
                if (!$ajax) {
                    abort(503);
                } else {
                    return false;
                }
            } else {
	            if ($ajax) {
		            return true;
	            }
            }
        }
    }
}
