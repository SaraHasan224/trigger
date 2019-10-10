<?php



namespace App\Http\Controllers\Admin\Administrator;

use App\Http\Controllers\AdminController;
use App\Notification,
    App\User;
use App\UserInfo;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Input;
use Validator, Hash;
use Auth;

class Users extends AdminController {
	public $UserTypes = ["", "Super Admin", "Admin", "Visitor"];

	function __construct() {
		parent::__construct();
    }

    public function index() {
		$this->check_access('List Users');
        return view('admin.administrator.users.list',$this->data);
    }

	public function data_list() {
        header("Content-type: application/json; charset=utf-8");
        if(!$this->check_access('List Users', true)) {
            echo json_encode([
                    "draw" => (int)Input::get("draw"),
                    "recordsTotal" => 0,
                    "recordsFiltered" => 0,
                    "data" => [], "error" => "Access denied!"
            ]);
            exit(0);
        }
        $start = (int)Input::get("start");
        $length = ((int)Input::get("length") > 0 ? (int)Input::get("length") : 25);

        $columns = ["users.id", "users.id", "users.name", "users.email", "users.user_type", "users.status", "users.created_at", "users.updated_at"];

        $query = User::selectRaw("users.id, users.Deletable, users.user_type, users.name, users.email, users.status, users.created_at, users.updated_at, a_added.name as AddedBy, a_updated.name as ModifiedBy")
        ->leftJoin('users as a_added', 'users.AddedBy', '=', 'a_added.id')
        ->leftJoin('users as a_updated', 'users.ModifiedBy', '=', 'a_updated.id');

        $recordsTotal = count($query->get());

        if (Input::get("search")["value"] != "") {
            $input = escape(trim(Input::get("search")["value"]));
            $query->whereRaw("(users.name LIKE '%" . $input . "%' OR users.email LIKE '%" . $input . "%' OR users.phone LIKE '%" . $input . "%')");
        }

        $query->orderBy($columns[(int)Input::get("order")[0]["column"]], Input::get("order")[0]["dir"]);

        $recordsFiltered = count($query->get());
        $result = $query->skip($start)->take($length)->get();
        $data = [];
        foreach ($result as $Rs) {
        	$RoleName = implode(",", $Rs->getRoleNames()->toArray());
            $data[] = [
				'<input type="checkbox" name="ids[]" id="checkbox' . $Rs->id . '" value="' . $Rs->id . '" class="checkboxes">',
	            $Rs->id,
	            unescape($Rs->name).($RoleName != '' ? ' <span class="m-badge m-badge--info m-badge--wide">'.$RoleName.'</span>' : ''),
		        unescape($Rs->email),
		        $this->UserTypes[$Rs->user_type],
                str_replace("{id}", $Rs->id, $this->_Status[$Rs->status]),
                '<b>'.$Rs->AddedBy.'</b><br />'.$Rs->created_at,
                '<b>'.(!empty($Rs->ModifiedBy) ? $Rs->ModifiedBy : '--').'</b><br />'.$Rs->updated_at,
                '<div class="btn-group">
                    <button type="button" onclick="location.href=\'' . route('user-edit', ["id" => $Rs->id]) . '\'" class="btn btn-outline-primary btn-rounded btn-sm"'.($Rs->user_type == 1 ? ' disabled="disabled"' : '').'>Edit</button>
                    <button type="button" class="btn btn-outline-' . ($Rs->status == 0 ? 'success' : 'danger') . ' btn-rounded btn-sm btn-status" id="' . $Rs->id . '" Status="' . $Rs->Status . '" '.($Rs->Status == 0 ? 'data-original-title="Click to Activate"' : 'data-original-title="Click to deactivate"').' data-placement="right"'.($Rs->user_type == 1 ? ' disabled="disabled"' : '').'><i class="fa ' . ($Rs->Status == 1 ? 'fa-eye-slash' : 'fa-eye') . '"></i></button></div>'
            ];
        }
        echo json_encode(["draw" => (int)Input::get("draw"), "recordsTotal" => $recordsTotal, "recordsFiltered" => $recordsFiltered, "data" => $data]);
        exit(0);
	}

	public function getRoles() {
		return ["0" => "-- Select Roles --"]+\App\UserRole::select("id", "name")->pluck("name", "id")->toArray();
	}

	public function add() {
		$this->check_access('Add User');
        $this->data['Roles'] = $this->getRoles();
        return view('admin.administrator.users.add',$this->data);
	}

	public function save() {
        $this->check_access('Add User');
        $v = Validator::make(Input::all(), [
			'name' => 'required|max:30',
			'email' => 'required|email|max:191|unique:users',
			'password' => 'required|min:5|max:15',
			'RoleID' => 'required|integer|min:1',
        ], [
	        "RoleID.min" => "Please select :attribute.",
	        "RoleID.integer" => "Please select :attribute.",
        ]);

        $v->setAttributeNames([
            'name' => "Full Name",
            'email' => "Email Address",
            'password' => "Password",
            'RoleID' => "Role",
        ]);

        if ($v->fails()) {
	        Input::merge(["Status" => (int)Input::get("Status")]);
            return redirect()->back()->withErrors($v->errors())->withInput();
        } else {
        	$Role = Role::find((int)Input::get("RoleID"));
        	if(empty($Role)) {
		        return redirect()->back()->withErrors("Selected user role is invalid.")->withInput();
	        }
			$User = User::create([
				"name" => escape(Input::get("name")),
				"email" => escape(Input::get("email")),
				"phone" => escape(Input::get("phone")),
				"user_image" => escape(Input::get("user_image")),
				"user_type" => 2,
				"status" => (Input::get('Status') == 'on')? 1 : 0,
				"password" => Hash::make(Input::get("password")),
				"AddedBy" => Auth::user()->id,
			]);
        	/*
            Notification::create([
                'from_id' => Auth::user()->id,
                'message' => Auth::user()->name.' created user '.escape(Input::get("name")).' account'
            ]);
            */
            // Firebase Notification sent
            Notification::Notify(
                auth()->user()->user_type,
                $this->to_id,
                Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." added user record, against User Name: ".escape(Input::get("name"))." and User Role: ".$Role->name,
                'admin-dashboard/administrator/users/add',
                Auth::user()->id,
                ' bg-inverse-success text-success',
                'mdi mdi-account-multiple-plus'
            );
	        $User->assignRole($Role->name);
            return redirect()->back()->with('success',"User has been added successfully.");
        }
    }

	public function edit($id) {
		$this->check_access('Edit User');
		$this->data["Record"] = User::find($id);

    	if(!empty($this->data["Record"])) {
			if($this->data["Record"]->user_type == 1) {
				return redirect()->route("user-list")->with("warning_msg", "Super administrator can not be edited.");
			} else {
				$this->data["Roles"] = $this->getRoles();
				$role = Role::findByName(implode(",", $this->data["Record"]->getRoleNames()->toArray()));
				$this->data["RoleID"] = (!empty($role) ? $role->id : 0);
				return view('admin.administrator.users.edit', $this->data);
			}
		} else {
            return redirect()->route("user-list")->withErrors("Invalid User ID.");
        }
    }

	public function update($id) {
        $this->check_access('Edit User');
		$rules["name"] = 'required|max:30';
		$rules["email"] = 'required|email|max:191|unique:users,email,'.$id.',id';
		if(Input::get("Password") != "") {
			$rules["Password"] = 'min:5|max:15';
		}
		$rules["RoleID"] = 'required|integer|min:1';
        $v = Validator::make(Input::all(), $rules, [
	        "RoleID.min" => "Please select :attribute.",
            "RoleID.integer" => "Please select :attribute.",
		]);
        $v->setAttributeNames([
	        'name' => "Full Name",
	        'email' => "Email Address",
	        'password' => "Password",
	        'RoleID' => "Role",
        ]);
        if ($v->fails()) {
	        Input::merge(["Status" => (int)Input::get("Status")]);
            return redirect()->back()->withErrors($v->errors())->withInput();
        } else {
			$Record = User::find($id);
			if(!empty($Record)) {
				if($Record->user_type == 1) {
					return redirect()->route("user-list")->withErrors("Super administrator can not be edited.");
				} else {
					$Role = Role::find((int)Input::get("RoleID"));
					// Firebase Notification sent
                    Notification::Notify(
                        auth()->user()->user_type,
                        $this->to_id,
                        Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." edited user record, against User Name: ".$Record->name,
                        'admin-dashboard/administrator/users/edit/'.$id,
                        Auth::user()->id,
                        ' bg-inverse-primary text-primary',
                        'mdi mdi-account-multiple-plus'
                    );

					if(empty($Role)) {
						return redirect()->back()->withErrors("Selected user role is invalid.")->withInput();
					}
					if(Input::get('Password') != "") {
						$Record->Password = Hash::make(Input::get('Password'));
					}
					$Record->name = escape(Input::get('name'));
					$Record->email = escape(Input::get('email'));
					$Record->phone = escape(Input::get('phone'));
					$Record->user_image = escape(Input::get('user_image'));
					$Record->status = (Input::get('Status') == 'on')? 1 : 0;
					$Record->ModifiedBy = Auth::user()->id;
					$Record->save();

                    /*
                    Manual Notification Old
                        Notification::create([
                            'from_id' => Auth::user()->id,
                            'message' => Auth::user()->name.' edited user '.escape(Input::get("name"))
                        ]);
                    */
					$Record->syncRoles([$Role->name]);
					return redirect()->route("user-list")->with('success', "User has been updated successfully.");
				}
			} else {
    			return redirect()->route("user-list")->withErrors("Invalid User ID.");
			}
		}
    }

    public function update_status() {
		$this->check_access('Edit User', false);
        $v = Validator::make(Input::all(), [
			'sid' => 'required|integer',
			'status' => 'required|integer|min:0|max:1',
        ]);
        if ($v->fails()) {
            echo json_encode(['updated' => false]);
        } else {
            $user = User::where("id", (int)Input::get('sid'))->first();
			$user->update([
				"Status" => (int)Input::get('status')
			]);
    /*
            Notification::create([
                'from_id' => Auth::user()->id,
                'message' => Auth::user()->name.' updated user '.escape(Input::get("name")).' status'
            ]);
    */
            // Firebase Notification sent
            Notification::Notify(
                auth()->user()->user_type,
                $this->to_id,
                Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." updated user status, against User Name: ".$user->name,
                'admin-dashboard/administrator/users/',
                Auth::user()->id,
                '  bg-inverse-secondary text-info',
                'mdi mdi-account-multiple-plus'
            );


            echo json_encode(['updated' => true, 'status' => Input::get('status')]);
        }
    }

    public function delete() {
		$this->check_access('Delete User', false);
        $super_admin = User::select('id')->where('user_type',1)->get();
        $super_Admin = [];
        foreach ($super_admin as $id)
        {
            $super_Admin = $id['id'];
        }
        $logged_user = auth()->user()->id;
        if(in_array($super_Admin,Input::get('ids')))
        {
            return redirect('admin-dashboard/administrator/users')->with('warning_msg', "Super Admin can't be deleted.");
        }
        else if(in_array($logged_user,Input::get('ids'))){
            return redirect('admin-dashboard/administrator/users')->with('warning_msg', "Logged In user can't be deleted.");
        }
        else{
            if(is_array(Input::get('ids')) && count(Input::get('ids')) > 0) {
                try {
                    /*
                     Old Notifcation
                        Notification::create([
                            'from_id' => Auth::user()->id,
                            'message' => Auth::user()->name.' deleted users '
                        ]);
                    */
                    // Firebase Notification sent
                    Notification::Notify(
                        auth()->user()->user_type,
                        $this->to_id,
                        Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." deleted user record",
                        'admin-dashboard/administrator/users',
                        Auth::user()->id,
                        '  bg-inverse-warning text-warning',
                        'mdi mdi-security'
                    );
                    User::whereIn('id', Input::get('ids'))->delete();
                    return redirect('admin-dashboard/administrator/users')->with('success', "Selected records have been delted successfully.");
                } catch(\Illuminate\Database\QueryException $ex) {
                    return redirect()->back()->with("warning_msg", "Some record(s) can not be deleted.");
                }
            } else {
                return redirect('admin-dashboard/administrator/users')->with('warning_msg', "Please select records to delete.");
            }
        }
    }

	public function my_profile() {
	    $user_info = UserInfo::whereUser_id(Auth::user()->id)->first();
        $user_info['cc_num'] = decrypt($user_info['cc_num']);
        $user_info['dc_num'] = decrypt($user_info['dc_num']);
	    $this->data['user_list'] = $user_info;
		return view('admin.administrator.users.my-profile',$this->data);
	}

	public function update_profile() {
		$rules["name"] = 'required|max:30';
		$rules["email"] = 'required|max:255|unique:users,email,'.Auth::user()->id.',id';
        $v = Validator::make(Input::all(), $rules);
        $v->setAttributeNames([
            'name' => "Name",
            'email' => "E-mail Address",
        ]);
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        } else {
			$Record = User::find(Auth::user()->id);
			if(!empty($Record)) {
				$Record->name = escape(Input::get('name'));
				$Record->email = escape(Input::get('email'));
				$Record->phone = escape(Input::get('phone'));
				$Record->user_image = escape(Input::get('user_image'));
				$Record->save();
                /*
                    Notification::create([
                        'from_id' => Auth::user()->id,
                        'message' => Auth::user()->name.' updated profile '
                    ]);
                */

                // Firebase Notification sent
                Notification::Notify(
                    auth()->user()->user_type,
                    $this->to_id,
                    Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." updated their profile",
                    'admin-dashboard/administrator/my-profile',
                    Auth::user()->id
                );
				return redirect()->route("my-profile-admin")->with('success', "Profile has been updated successfully.");
			} else {
                return redirect()->route("my-profile-admin")->withErrors("Invalid User ID.");
			}
		}
	}

    public function change_password() {
        return view('admin.administrator.users.change-password',$this->data);
    }

    public function update_password() {
        $v = Validator::make(Input::all(), [
            'CurrentPassword' => 'required|max:30',
            'NewPassword' => 'required|max:30',
            'ConfirmPassword' => 'required|same:NewPassword',
        ]);

        $v->setAttributeNames([
            'CurrentPassword' => "Current Password",
            'NewPassword' => "New Password",
            'ConfirmPassword' => "Retype Password",
        ]);
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        } else {
            $user = User::findOrFail(Auth::user()->id);
            if (Hash::check(Input::get('CurrentPassword'), $user->Password)) {
                $user->Password = Hash::make(Input::get("NewPassword"));
                $user->save();
                /*
                Notification::create([
                    'from_id' => Auth::user()->id,
                    'message' => Auth::user()->name.' updated password'
                ]);
                */
                // Firebase Notification sent
                Notification::Notify(
                    auth()->user()->user_type,
                    $this->to_id,
                    Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." updated their password",
                    'admin-dashboard/administrator/change-password',
                    Auth::user()->id,
                    ' bg-inverse-secondary text-primary',
                    'mdi mdi-logout'
                );
                return redirect()->route("change-password-admin")->with('success', "Password has been changed successfully.");
            } else {
                return redirect()->route("change-password-admin")->with('warning_msg', "Invalid current password.");
            }
        }
    }


    public function change_cc_info() {
        $rules["cc_name"] = 'required|max:199';
        $rules["cc_num1"] = 'required|max:19';
        $rules["cc_exp"] = 'required|max:5';
        $rules["c_cvv"] = 'required|max:3';

        $v = Validator::make(Input::all(), $rules);
        $v->setAttributeNames([
            'cc_name' => "Enter Credit Card Holder Name",
            'cc_num' => "Enter Credit Card Number",
            'cc_exp' => "Incorrect range for Credit Card Expiry Date",
            'c_cvv' => "Incorrect range for Card Verification Value (CVV)",
        ]);
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        } else {
            $cc_num = Input::get('cc_num');
            $cc_num1 = Input::get('cc_num1');
            $value_to_be_encrypted = strpos($cc_num, '#') == 0 ? $cc_num1 : $cc_num;
            $value_encrypted = encrypt($value_to_be_encrypted);

            UserInfo::updateOrCreate(['user_id' => Auth::user()->id], [
                'cc_name' => escape(Input::get('cc_name')),
                'cc_num' => $value_encrypted,
                'cc_exp' => escape(Input::get('cc_exp')),
                'c_cvv' => escape(Input::get('c_cvv')),
            ]);
            Notification::Notify(
                auth()->user()->user_type,
                $this->to_id,
                Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." updated their profile",
                'admin-dashboard/administrator/my-profile',
                Auth::user()->id,
                ' bg-inverse-success text-success',
                'mdi mdi-account-convert'
            );
            return redirect()->route("my-profile-admin")->with('success', "Credit Card Information has been updated successfully.");
        }
    }

    public function change_dc_info() {
        $rules["dc_name"] = 'required|max:199';
        $rules["dc_num"] = 'required|max:19';
        $rules["dc_exp"] = 'required|max:5';
        $rules["d_cvv"] = 'required|max:3';

        $v = Validator::make(Input::all(), $rules);
        $v->setAttributeNames([
            'dc_name' => "Enter Debit Card Holder Name",
            'dc_num' => "Enter Debit Card Number",
            'dc_exp' => "Incorrect range for Debit Card Expiry Date",
            'd_cvv' => "Incorrect range for Card Verification Value (CVV)",
        ]);
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        } else {
            $dc_num = Input::get('dc_num');
            $dc_num1 = Input::get('dc_num1');
            $value_to_be_encrypted = strpos($dc_num, '#') == 0 ? $dc_num1 : $dc_num;
//dd($value_to_be_encrypted);
            $value_encrypted = encrypt($value_to_be_encrypted);

            UserInfo::updateOrCreate(['user_id' => Auth::user()->id], [
                'dc_name' => escape(Input::get('dc_name')),
                'dc_num' => $value_encrypted,
                'dc_exp' => escape(Input::get('dc_exp')),
                'd_cvv' => escape(Input::get('d_cvv')),
            ]);
            Notification::Notify(
                auth()->user()->user_type,
                $this->to_id,
                Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." updated their profile",
                'admin-dashboard/administrator/my-profile',
                Auth::user()->id,
                ' bg-inverse-success text-success',
                'mdi mdi-account-convert'
            );
            return redirect()->route("my-profile-admin")->with('success', "Personal Profile Information has been updated successfully.");

        }
    }

    public function change_bank_info() {
        $rules["holder_name"] = 'required|max:199';
        $rules["acc_num"] = 'required|max:255';
        $rules["iban_num"] = 'max:50';
        $rules["bank_name"] = 'max:199';
        $rules["bank_code"] = 'required|max:10';

        $v = Validator::make(Input::all(), $rules);
        $v->setAttributeNames([
            'holder_name' => "Enter Account Holder Name",
            'acc_num' => "Enter Account Number",
            'iban_num' => "Incorrect range for IBAN Name",
            'bank_name' => "Enter Bank Name",
            'bank_code' => "Enter Bank Code",
        ]);
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        } else {
//            dd(Input::all());
            UserInfo::updateOrCreate(['user_id' => Auth::user()->id], [
                'holder_name' =>  escape(Input::get('holder_name')),
                'acc_num' => escape(Input::get('acc_num')),
                'iban_num' => escape(Input::get('iban_num')),
                'bank_name' => escape(Input::get('bank_name')),
                'bank_code' => escape(Input::get('bank_code')),
            ]);
            Notification::Notify(
                auth()->user()->user_type,
                $this->to_id,
                Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." updated their profile",
                'admin-dashboard/administrator/my-profile',
                Auth::user()->id,
                ' bg-inverse-success text-success',
                'mdi mdi-account-convert'
            );
            return redirect()->route("my-profile-admin")->with('success', "Bank Account Information has been updated successfully.");
        }
    }
}

