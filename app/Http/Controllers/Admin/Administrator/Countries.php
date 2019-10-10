<?php

namespace App\Http\Controllers\Admin\Administrator;

use App\Notification,
    App\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\User;
use Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Input;
use Validator, Hash;

class Countries extends AdminController
{

    public $UserTypes = ["", "Super Admin", "Admin", "Visitor"];

    function __construct() {
        parent::__construct();
    }

    public function index() {

        $this->check_access('List Countries');
        return view('admin.administrator.configuration.countries.list',$this->data);
    }

    public function data_list() {
        header("Content-type: application/json; charset=utf-8");
        if(!$this->check_access('List Countries', true)) {
            echo json_encode(["draw" => (int)Input::get("draw"), "recordsTotal" => 0, "recordsFiltered" => 0, "data" => [], "error" => "Access denied!"]);
            exit(0);
        }
        $start = (int)Input::get("start");
        $length = ((int)Input::get("length") > 0 ? (int)Input::get("length") : 25);

        $columns = ["countries.id", "countries.id", "countries.sortname", "countries.name", "countries.phonecode", "countries.locale", "countries.created_at", "countries.updated_at"];
        $query = Country::selectRaw("countries.id, countries.sortname, countries.name, countries.phonecode, countries.locale, countries.created_at, countries.updated_at, a_added.name as AddedBy, a_updated.name as ModifiedBy")
            ->leftJoin('users as a_added', 'countries.AddedBy', '=', 'a_added.id')
            ->leftJoin('users as a_updated', 'countries.ModifiedBy', '=', 'a_updated.id');

        $recordsTotal = count($query->get());

        if (Input::get("search")["value"] != "") {
            $input = escape(trim(Input::get("search")["value"]));
            $query->whereRaw("(countries.name LIKE '%" . $input . "%' OR countries.locale LIKE '%" . $input . "%' OR countries.phonecode LIKE '%" . $input . "%')");
        }

        $query->orderBy($columns[(int)Input::get("order")[0]["column"]], Input::get("order")[0]["dir"]);

        $recordsFiltered = count($query->get());
        $result = $query->skip($start)->take($length)->get();
        $data = [];
        foreach ($result as $Rs) {
            $data[] = [
                '<input type="checkbox" name="ids[]" id="checkbox' . $Rs->id . '" value="' . $Rs->id . '" class="checkboxes">',
                unescape($Rs->name),
                '+'.unescape($Rs->phonecode),
                unescape($Rs->locale),
                '<b>'.$Rs->AddedBy.'</b><br />'.$Rs->created_at,
                '<b>'.(!empty($Rs->ModifiedBy) ? $Rs->ModifiedBy : '--').'</b><br />'.$Rs->updated_at,
                '<div class="btn-group">
<button type="button" onclick="location.href=\'' . route('countries-edit', ["id" => $Rs->id]) . '\'" class="btn btn-outline-primary btn-rounded btn-sm"'.($Rs->user_type == 1 ? ' disabled="disabled"' : '').'>Edit</button>'
            ];
        }

        echo json_encode(["draw" => (int)Input::get("draw"), "recordsTotal" => $recordsTotal, "recordsFiltered" => $recordsFiltered, "data" => $data]);
        exit(0);
    }

    public function add() {
        $this->check_access('Add Countries');
        return view('admin.administrator.configuration.countries.add',$this->data);
    }

    public function save() {
        $this->check_access('Add Countries');

        $v = Validator::make(Input::all(), [
            'sort_name' => 'required',
            'name' => 'required',
            'phone_code' => 'required',
            'lang_code' => 'required',
        ]);

        $v->setAttributeNames([
            'sort_name' => "Sort Name Field Required",
            'name' => "Name Field Required",
            'phone_code' => "Phone Code Required",
            'lang_code' => "Language Code Required",
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        } else {
            $country = Country::create([
                "sortname" => escape(Input::get("sort_name")),
                "name" => escape(Input::get("name")),
                "phonecode" => escape(Input::get("phone_code")),
                "locale" => escape(Input::get("lang_code")),
                "AddedBy" => auth()->user()->id,
            ]);

            Notification::create([
                'from_id' => Auth::user()->id,
                'message' => Auth::user()->name.' added country '.escape(Input::get('name'))
            ]);
            return redirect()->back()->with('success',"Country has been added successfully.");
        }
    }

    public function edit($id) {
        $this->check_access('Edit Countries');
        $this->data["Record"] = Country::whereId($id)->first();

        if(!empty($this->data["Record"])) {
                return view('admin.administrator.configuration.countries.edit', $this->data);
        } else {
            return redirect()->route("state-list")->withErrors("Invalid Country ID.");
        }
    }

    public function update($id) {
        $this->check_access('Edit Countries');
        $rules["sort_name"] = 'required';
        $rules["name"] = 'required';
        $rules["phone_code"] = 'required';
        $rules["lang_code"] = 'required';
        $v = Validator::make(Input::all(), $rules, [

        ]);

        $v->setAttributeNames([
            'sort_name' => "Sort Name Field Required",
            'name' => "Name Field Required",
            'phone_code' => "Phone Code  Required",
            'lang_code' => "Language Code Required",
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        } else {
            $Record = Country::find($id);

            if(!empty($Record)) {
                    $Record->sortname = escape(Input::get('sort_name'));
                    $Record->name = escape(Input::get('name'));
                    $Record->phonecode = escape(Input::get('phone_code'));
                    $Record->locale = escape(Input::get('lang_code'));
                    $Record->ModifiedBy = auth()->user()->id;
                    $Record->save();

                Notification::create([
                    'from_id' => Auth::user()->id,
                    'message' => Auth::user()->name.' updated country '.escape(Input::get('name'))
                ]);
                    return redirect()->route("countries-list")->with('success', "Country has been updated successfully.");
            } else {
                return redirect()->route("countries-list")->withErrors("Invalid Country ID.");
            }
        }
    }


    public function delete() {
        $this->check_access('Delete Countries', 'Delete');
        if(is_array(Input::get('ids')) && count(Input::get('ids')) > 0) {
            try {

                Notification::create([
                    'from_id' => Auth::user()->id,
                    'message' => Auth::user()->name.' deleted countries'
                ]);
                Country::whereIn('id', Input::get('ids'))->delete();
                return redirect('admin-dashboard/administrator/configuration/countries')->with('success', "Selected records have been deleted successfully.");
            } catch(\Illuminate\Database\QueryException $ex) {
                return redirect()->back()->with("warning_msg", "Some record(s) can not be deleted.");
            }
        } else {
            return redirect('admin-dashboard/administrator/configuration/countries')->with('warning_msg', "Please select records to delete.");
        }
    }
}
