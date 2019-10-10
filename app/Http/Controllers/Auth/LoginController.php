<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Notification;
use App\User;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public $user_types = [1, 2];

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
	protected function redirectTo()
	{
		return '/';
	}

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $array = [];
        $super_admin = User::select('id')->where('user_type',1)->get();
        foreach ($super_admin as $id)
        {
            $array = $id['id'];
        }
        $this->to_id = $array;
        $this->middleware('guest')->except('logout');
    }

	protected function authenticated(Request $request, $user) {
		if (auth()->check()) {
            if($user->status == 1) {
                $request->session()->put('User_Type',$user->user_type);
                $request->session()->put('User_ID',$user->id);
                Notification::Notify(
                    ($user->user_type == 1)  ? 1 : $user->user_type,
                    $this->to_id,
                    "User: ".$user->name." Logged In",
                    '/admin-dashboard',
                    $user->id,
                    ' bg-inverse-secondary text-info',
                    'mdi mdi-login'
                );
				return redirect()->route((in_array(auth()->user()->user_type, $this->user_types) ? 'admin-dashboard' : 'home'));
			} else {
				$request->session()->flush();
				return redirect()->route("home");
			}
		} else {
			return redirect()->route("home");
		}
	}

    public function logout(Request $request) {

        Notification::Notify(
            (auth()->user()->user_type == 1)  ? 1 : auth()->user()->user_type,
             $this->to_id,
            "User: ".auth()->user()->name." Logged Out",
            '/admin-dashboard',
            auth()->user()->id,
            ' bg-inverse-secondary text-info',
            'mdi mdi-logout'
        );
        auth()->logout();
        $request->session()->flush();
        return redirect('/');
    }
}
