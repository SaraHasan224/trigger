<?php

namespace App\Http\Controllers\Admin\Administrator;

use App\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Notification,
    App\User;
use Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Input;
use Validator, Hash;
use App\State;

class States extends AdminController
{

    public $UserTypes = ["", "Super Admin", "Admin", "Visitor"];

    function __construct() {
        parent::__construct();
    }

    public function index() {

        $this->check_access('List State');
        return view('admin.administrator.configuration.states.list',$this->data);
    }

    public function data_list() {
        header("Content-type: application/json; charset=utf-8");
        if(!$this->check_access('List State', true)) {
            echo json_encode(["draw" => (int)Input::get("draw"), "recordsTotal" => 0, "recordsFiltered" => 0, "data" => [], "error" => "Access denied!"]);
            exit(0);
        }
        $start = (int)Input::get("start");
        $length = ((int)Input::get("length") > 0 ? (int)Input::get("length") : 25);

        $columns = ["states.id", "states.id", "states.name", "countries_name", "countries.phonecode", "countries.locale", "states.created_at", "states.updated_at"];
        $query = State::selectRaw("states.id, states.name, countries.name as countries_name,  countries.phonecode, countries.locale, states.created_at, states.updated_at, a_added.name as AddedBy, a_updated.name as ModifiedBy")
            ->leftJoin('countries as countries', 'states.country_id', '=', 'countries.id')
            ->leftJoin('users as a_added', 'states.AddedBy', '=', 'a_added.id')
            ->leftJoin('users as a_updated', 'states.ModifiedBy', '=', 'a_updated.id');

        $recordsTotal = count($query->get());

        if (Input::get("search")["value"] != "") {
            $input = escape(trim(Input::get("search")["value"]));
            $query->whereRaw("(states.name LIKE '%" . $input . "%' OR countries.name LIKE '%" . $input . "%' OR countries.phonecode LIKE '%" . $input . "%')");
        }

        $query->orderBy($columns[(int)Input::get("order")[0]["column"]], Input::get("order")[0]["dir"]);

        $recordsFiltered = count($query->get());
        $result = $query->skip($start)->take($length)->get();
        $data = [];
        foreach ($result as $Rs) {
            $data[] = [
                '<input type="checkbox" name="ids[]" id="checkbox' . $Rs->id . '" value="' . $Rs->id . '" class="checkboxes">',
                unescape($Rs->name),
                unescape($Rs->countries_name),
                '+'.unescape($Rs->phonecode),
                '<b>'.$Rs->AddedBy.'</b><br />'.$Rs->created_at,
                '<b>'.(!empty($Rs->ModifiedBy) ? $Rs->ModifiedBy : '--').'</b><br />'.$Rs->updated_at,
                '<div class="btn-group">
<button type="button" onclick="location.href=\'' . route('state-edit', ["id" => $Rs->id]) . '\'" class="btn btn-outline-primary btn-rounded btn-sm"'.($Rs->user_type == 1 ? ' disabled="disabled"' : '').'>Edit</button>'
            ];
        }

        echo json_encode(["draw" => (int)Input::get("draw"), "recordsTotal" => $recordsTotal, "recordsFiltered" => $recordsFiltered, "data" => $data]);
        exit(0);
    }

    public function add() {
        $this->check_access('Add State');
        $country_name = [];
        $countries = Country::get();
        foreach ($countries as $coun)
        {   $country_name[$coun->name]=$coun->name; }
        $this->data['country_name'] = $country_name;
        return view('admin.administrator.configuration.states.add',$this->data);
    }

    public function save() {
        $this->check_access('Add State');

        $v = Validator::make(Input::all(), [
            'name' => 'required',
            'country_id' => 'required',
        ]);

        $v->setAttributeNames([
            'country_id' => "Select country first",
            'name' => "Name Field Required",
        ]);
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        } else {
            $country = Country::where('name',escape(Input::get('country_id')))->first();

            Notification::create([
                'from_id' => Auth::user()->id,
                'message' => Auth::user()->name.' added state '.escape(Input::get('name'))
            ]);
            State::create([
                "name" => escape(Input::get("name")),
                "country_id" => $country->id,
                "AddedBy" => Auth::user()->id,
            ]);
            return redirect()->back()->with('success',"State has been added successfully.");
        }
    }

    public function edit($id) {
        $this->check_access('Edit State');
        $this->data["Record"] = State::whereId($id)->first();
        $countries = Country::get();
        $country_name = [];
        foreach ($countries as $coun)
        {   $country_name[$coun->name]=$coun->name; }
        $this->data['country_name'] = $country_name;

        if(!empty($this->data["Record"])) {
            return view('admin.administrator.configuration.states.edit', $this->data);
        } else {
            return redirect()->route("state-list")->withErrors("Invalid State ID.");
        }
    }

    public function update($id) {
        $this->check_access('Edit State');
        $rules["name"] = 'required';
        $rules["country_id"] = 'required';
        $v = Validator::make(Input::all(), $rules, [

        ]);

        $v->setAttributeNames([
            'country_id' => "Select country first",
            'name' => "Name Field Required",
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        } else {
            $Record = State::find($id);
            $country = Country::where('name',escape(Input::get('country_id')))->first();
            if(!empty($Record)) {
                $Record->country_id = (int)($country->id);
                $Record->name = escape(Input::get('name'));
                $Record->ModifiedBy = Auth::user()->id;
                $Record->save();

                Notification::create([
                    'from_id' => Auth::user()->id,
                    'message' => Auth::user()->name.' updated state '.escape(Input::get('name'))
                ]);
                return redirect()->route("state-list")->with('success', "State has been updated successfully.");
            } else {
                return redirect()->route("state-list")->withErrors("Invalid State ID.");
            }
        }
    }


    public function delete() {
        $this->check_access('Delete State', 'Delete');
        if(is_array(Input::get('ids')) && count(Input::get('ids')) > 0) {
            try {
                Notification::create([
                    'from_id' => Auth::user()->id,
                    'message' => Auth::user()->name.' deleted states'
                ]);
                State::whereIn('id', Input::get('ids'))->delete();
                return redirect('admin-dashboard/administrator/configuration/state')->with('success', "Selected records have been deleted successfully.");
            } catch(\Illuminate\Database\QueryException $ex) {
                return redirect()->back()->with("warning_msg", "Some record(s) can not be deleted.");
            }
        } else {
            return redirect('admin-dashboard/administrator/configuration/state')->with('warning_msg', "Please select records to delete.");
        }
    }
}
