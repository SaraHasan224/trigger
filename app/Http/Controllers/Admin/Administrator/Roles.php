<?php



namespace App\Http\Controllers\Admin\Administrator;

use App\Http\Controllers\AdminController;

use App\UserRole;

use App\Notification;

use Spatie\Permission\Models\Role;

use Spatie\Permission\Models\Permission;

use Auth;

use Illuminate\Support\Facades\Input;

use Validator;



class Roles extends AdminController {

    function __construct() {
		parent::__construct();
    }

    public function index() {
		$this->check_access('List Roles');
        return view('admin.administrator.roles.list',$this->data);
    }

    public function data_list() {
        header("Content-type: application/json; charset=utf-8");
        if(!$this->check_access('List Roles', true)) {
            echo json_encode(["draw" => (int)Input::get("draw"), "recordsTotal" => 0, "recordsFiltered" => 0, "data" => [], "error" => "Access denied!"]);
            exit(0);
        }

        $start = (int)Input::get("start");
        $length = ((int)Input::get("length") > 0 ? (int)Input::get("length") : 25);
        $columns = ["roles.id", "roles.id", "roles.name", "roles.created_at", "roles.updated_at"];

        $query = UserRole::selectRaw("roles.id, roles.name, a_added.name as AddedBy, roles.created_at, a_updated.name as ModifiedBy, roles.updated_at")
            ->leftJoin('users as a_added', 'roles.AddedBy', '=', 'a_added.id')
            ->leftJoin('users as a_updated', 'roles.ModifiedBy', '=', 'a_updated.id');

        $recordsTotal = count($query->get());

        if (Input::get("search")["value"] != "") {
            $input = escape(trim(Input::get("search")["value"]));
            $query->whereRaw("(roles.name LIKE '%" . $input . "%')");
        }

        $query->orderBy($columns[(int)Input::get("order")[0]["column"]], Input::get("order")[0]["dir"]);

        $recordsFiltered = count($query->get());
        $result = $query->skip($start)->take($length)->get();
        $data = [];
        foreach ($result as $Rs) {
            $data[] = [
				'<input type="checkbox" name="ids[]" id="checkbox' . $Rs->id . '" value="' . $Rs->id . '" class="checkboxes">',
                $Rs->id,
                unescape($Rs->name),
	            '<b>'.$Rs->AddedBy.'</b><br />'.$Rs->created_at,
	            '<b>'.(!empty($Rs->ModifiedBy) ? $Rs->updated_at : '--').'</b><br />'.$Rs->updated_at,
                '<button type="button" onclick="location.href=\'' . route('role-edit', ["id" => $Rs->id]) . '\'" class="btn btn-outline-primary btn-rounded btn-sm">Edit</button>'
            ];
        }
        echo json_encode(["draw" => (int)Input::get("draw"), "recordsTotal" => $recordsTotal, "recordsFiltered" => $recordsFiltered, "data" => $data]);
        exit(0);
	}

	public function getPermissions() {
    	return Permission::select("name")->pluck("name", "name")->toArray();
	}

	public function add() {
		$this->check_access('Add Role');
		$this->data['Permissions'] = $this->getPermissions();
        return view('admin.administrator.roles.add', $this->data);
	}

	public function save() {
		$this->check_access('Add Role');
        $v = Validator::make(Input::all(), [
			'RoleName' => 'required',
	        'Permissions' => 'required|array|min:1'
        ]);

        $v->setAttributeNames([
            'RoleName' => 'Role Name',
	        'Permissions' => 'Permissions',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        } else {
	        $role = Role::create([
	        	'name' => escape(Input::get("RoleName")),
		        'AddedBy' => auth()->user()->id
	        ]);
            // Firebase Notification sent
            Notification::Notify(
                auth()->user()->user_type,
                $this->to_id,
                "User: ".Auth::user()->name." (Having Role: ".Auth::user()->role->name.") "."created role : ".escape(Input::get("RoleName")),
                '/admin-dashboard/administrator/roles/',
                Auth::user()->id,
                ' bg-inverse-success text-success',
                'mdi mdi-account-star'
            );

//            Notification::create([
//                'from_id' => Auth::user()->id,
//                'message' => Auth::user()->name.' created role '.escape(Input::get("RoleName"))
//            ]);

	        foreach(Input::get("Permissions") as $RolePermission) {
		        $Permission = Permission::where("name", $RolePermission)->first();
		        if(!empty($Permission)) {
			        $role->givePermissionTo($Permission);
		        }
	        }
	        return redirect()->back()->with("success", "User Role has been added.");
        }
    }

	public function edit($id) {
		$this->check_access('Edit Role');
        $this->data['Record'] = Role::with("permissions")->find($id);

		if(!empty($this->data['Record']) > 0) {
			$this->data["Permissions"] = $this->getPermissions();
			$this->data["RolePermissions"] = [];
			foreach($this->data['Record']->permissions as $permission) {
				$this->data["RolePermissions"][] = unescape($permission->name);
			}
			return view('admin.administrator.roles.edit', $this->data);
		} else {
            redirect("admin-dashboard/administrator/user-roles")->withErrors("Invalid Group ID.");
        }
    }

	public function update($id) {
		$this->check_access('Edit Role');

		$v = Validator::make(Input::all(), [
			'RoleName' => 'required',
    		'Permissions' => 'required|array|min:1'
		]);
		$v->setAttributeNames([
			'RoleName' => 'Role Name',
			'Permissions' => 'Permissions',
		]);

		if ($v->fails()) {
			return redirect()->back()->withErrors($v->errors())->withInput();
		} else {
            $record = Role::find($id);
			if(!empty($record)) {
                // Firebase Notification sent
                Notification::Notify(
                    auth()->user()->user_type,
                    $this->to_id,
                    "User: ".Auth::user()->name." (Having Role: ".Auth::user()->role->name.") "."updated role against name: ".$record->name,
                    '/admin-dashboard/administrator/roles/edit/'.$id,
                    Auth::user()->id,
                    ' bg-inverse-primary text-primary',
                    'mdi mdi-account-star'
                );
				$record->name = escape(Input::get("RoleName"));
				$record->ModifiedBy = auth()->user()->id;
				$record->save();
//                Notification::create([
//                    'from_id' => Auth::user()->id,
//                    'message' => Auth::user()->name.' updated role '.escape(Input::get("RoleName"))
//                ]);
//				Permission::where("role_id", $id)->delete();
                \App\UserPermission::where("role_id",$id)->delete();
				foreach(Input::get("Permissions") as $RolePermission) {
					$Permission = Permission::where("name", $RolePermission)->first();
					if(!empty($Permission)) {
						$record->givePermissionTo($Permission);
					}
				}
				return redirect()->back()->with('success', "User Role has been updated successfully.");
			} else {
				return redirect()->route("role-list")->withErrors("Invalid User Role ID.");
			}
        }
    }

    public function delete() {
		$this->check_access('Delete Role');
		if(is_array(Input::get('ids')) && count(Input::get('ids')) > 0) {
			try {
//                Notification::create([
//                    'from_id' => Auth::user()->id,
//                    'message' => Auth::user()->name.' deleted role '
//                ]);
                Notification::Notify(
                    auth()->user()->user_type,
                    $this->to_id,
                    "User: ".Auth::user()->name." (Having Role: ".Auth::user()->role->name.") "."deleted role",
                    '/admin-dashboard/administrator/roles/',
                    Auth::user()->id,
                    '  bg-inverse-warning text-warning',
                    'mdi mdi-account-star'
                );

				UserRole::whereIn('id', Input::get('ids'))->delete();
				return redirect()->back()->with('success', "Selected roles have been deleted successfully.");
			} catch(\Illuminate\Database\QueryException $ex) {
			  return redirect()->back()->with("warning_msg", "Some record(s) can not be deleted.");
			}
		} else {
			return redirect()->back()->with('warning_msg', "Please select roles to delete.");
		}
    }
}

