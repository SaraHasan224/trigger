<?php

namespace App\Http\Controllers\Auth;

use App\Notification;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Session;
use Spatie\Permission\Models\Role;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    public $user_types = [1, 2];
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    public function showRegistrationForm($auth_id = null, $role_id = null) {
        $data = [
            'auth_id' => $auth_id,
            'role_id' => $role_id
        ];
        return view ('auth.register',$data);
    }
	protected function redirectTo()
	{
		return route("home");
	}

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'RoleID' => ['required', 'integer', 'min:1'],
            'password' => ['required', 'string', 'min:5', 'min:15', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(Request $request,$auth_id = null, $role_id = null)
    {
        if($request->isMethod('post'))
        {
            $request->validate([
                'name' => 'required|string|max:30',
                'email' => 'required|string|email|max:191|unique:users',
                'password' => 'required|string|min:5|max:15|confirmed',
            ]);
            if($role_id == null || $auth_id == null) {
                return redirect()->back()->withErrors("User Role not granted. Please regenerate registeration link.")->withInput();
            }else{
                $Role = Role::find((int)$role_id);
                if(empty($Role)) {
                    return redirect()->back()->withErrors("Selected user role is invalid.")->withInput();
                }
            }

            $user = User::create([
                "name" => escape($request->name),
                "email" => escape($request->email),
                "user_type" => 2,
                "status" => 1,
                "password" => Hash::make($request->password),
                "AddedBy" => $auth_id,
            ]);
            $user->assignRole($Role->name);
            // Firebase Notification sent
            Notification::Notify(
                1,
                1,
                "User : ".escape($request->name)." registered via provided registeration link and has been assigned a role: ".$Role->name,
                'admin-dashboard/administrator/users/add',
                 $user->id,
                ' bg-inverse-success text-success',
                'mdi mdi-account-multiple-plus'
            );
            $request->session()->put('User_Type',$user->user_type);
            $request->session()->put('User_ID',$user->id);
            return redirect()->route((in_array($user->user_type, $this->user_types) ? 'admin-dashboard' : 'home'));
        }



    }
}
