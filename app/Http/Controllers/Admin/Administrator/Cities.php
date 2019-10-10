<?php

namespace App\Http\Controllers\Admin\Administrator;

use App\Notification,
    App\Country;
use Auth;
use App\State;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Input;
use Validator, Hash;
use App\City;

class Cities extends AdminController
{
    function __construct() {
        parent::__construct();
    }

    public function index() {

        $this->check_access('List City');
        return view('admin.administrator.configuration.cities.list',$this->data);
    }

    public function data_list() {
        header("Content-type: application/json; charset=utf-8");
        if(!$this->check_access('List City', true)) {
            echo json_encode(["draw" => (int)Input::get("draw"), "recordsTotal" => 0, "recordsFiltered" => 0, "data" => [], "error" => "Access denied!"]);
            exit(0);
        }
        $start = (int)Input::get("start");
        $length = ((int)Input::get("length") > 0 ? (int)Input::get("length") : 25);

        $columns = ["cities.id", "cities.id", "cities.name", "state_name",  "country_name", "cities.created_at", "cities.updated_at"];
        $query = City::selectRaw("cities.id, cities.name, states.name as state_name, countries.name as country_name, cities.created_at, cities.updated_at, a_added.name as AddedBy, a_updated.name as ModifiedBy")
            ->leftJoin('states', 'cities.state_id', '=', 'states.id')
            ->leftJoin('countries', 'states.country_id', '=', 'countries.id')
            ->leftJoin('users as a_added', 'states.AddedBy', '=', 'a_added.id')
            ->leftJoin('users as a_updated', 'states.ModifiedBy', '=', 'a_updated.id');

        $recordsTotal = count($query->get());

        if (Input::get("search")["value"] != "") {
            $input = escape(trim(Input::get("search")["value"]));
            $query->whereRaw("(cities.name LIKE '%" . $input . "%' OR states.name LIKE '%" . $input . "%')");
        }

        $query->orderBy($columns[(int)Input::get("order")[0]["column"]], Input::get("order")[0]["dir"]);

        $recordsFiltered = count($query->get());
        $result = $query->skip($start)->take($length)->get();
        $data = [];
        foreach ($result as $Rs) {
            $data[] = [
                '<input type="checkbox" name="ids[]" id="checkbox' . $Rs->id . '" value="' . $Rs->id . '" class="checkboxes">',
                unescape($Rs->name),
                unescape($Rs->state_name),
                unescape($Rs->country_name),
                '<b>'.$Rs->AddedBy.'</b><br />'.$Rs->created_at,
                '<b>'.(!empty($Rs->ModifiedBy) ? $Rs->ModifiedBy : '--').'</b><br />'.$Rs->updated_at,
                '<div class="btn-group">
<button type="button" onclick="location.href=\'' . route('city-edit', ["id" => $Rs->id]) . '\'" class="btn btn-outline-primary btn-rounded btn-sm"'.($Rs->user_type == 1 ? ' disabled="disabled"' : '').'>Edit</button>'
            ];
        }

        echo json_encode(["draw" => (int)Input::get("draw"), "recordsTotal" => $recordsTotal, "recordsFiltered" => $recordsFiltered, "data" => $data]);
        exit(0);
    }

    public function add() {
        $this->check_access('Add City');
        $country_name = [];
        $state = State::get();
        foreach ($state as $coun)
        {   $country_name[$coun->name]=$coun->name; }
        $this->data['country_name'] = $country_name;
        return view('admin.administrator.configuration.cities.add',$this->data);
    }

    public function save() {
        $this->check_access('Add City');

        $v = Validator::make(Input::all(), [
            'name' => 'required',
            'state_id' => 'required',
        ]);

        $v->setAttributeNames([
            'state_id' => "Select state first",
            'name' => "Name Field Required",
        ]);
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        } else {
            $state = State::where('name',escape(Input::get('state_id')))->first();
            City::create([
                "name" => escape(Input::get("name")),
                "state_id" => $state->id,
                "AddedBy" => Auth::user()->id,
            ]);

            Notification::create([
                'from_id' => Auth::user()->id,
                'message' => Auth::user()->name.' added city '.escape(Input::get('name'))
            ]);
            return redirect()->back()->with('success',"City has been added successfully.");
        }
    }

    public function edit($id) {
        $this->check_access('Edit City');
        $this->data["Record"] = City::whereId($id)->first();
        $countries = State::get();
        $country_name = [];
        foreach ($countries as $coun)
        {   $country_name[$coun->name]=$coun->name; }
        $this->data['country_name'] = $country_name;

        if(!empty($this->data["Record"])) {
            return view('admin.administrator.configuration.cities.edit', $this->data);
        } else {
            return redirect()->route("city-list")->withErrors("Invalid City ID.");
        }
    }

    public function update($id) {
        $this->check_access('Edit City');
        $rules["name"] = 'required';
        $rules["state_id"] = 'required';
        $v = Validator::make(Input::all(), $rules, [

        ]);

        $v->setAttributeNames([
            'state_id' => "Select state first",
            'name' => "Name Field Required",
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        } else {
            $Record = City::find($id);
            $country = State::where('name',escape(Input::get('state_id')))->first();
            if(!empty($Record)) {
                $Record->state_id = (int)($country->id);
                $Record->name = escape(Input::get('name'));
                $Record->ModifiedBy = auth()->user()->id;
                $Record->save();

                Notification::create([
                    'from_id' => Auth::user()->id,
                    'message' => Auth::user()->name.' updated cities'.escape(Input::get('name'))
                ]);
                return redirect()->route("city-list")->with('success', "City has been updated successfully.");
            } else {
                return redirect()->route("city-list")->withErrors("Invalid City ID.");
            }
        }
    }


    public function delete() {
        $this->check_access('Delete City', 'Delete');
        if(is_array(Input::get('ids')) && count(Input::get('ids')) > 0) {
            try {

                Notification::create([
                    'from_id' => Auth::user()->id,
                    'message' => Auth::user()->name.' deleted cities'
                ]);
                City::whereIn('id', Input::get('ids'))->delete();
                return redirect('admin-dashboard/administrator/configuration/city')->with('success', "Selected records have been deleted successfully.");
            } catch(\Illuminate\Database\QueryException $ex) {
                return redirect()->back()->with("warning_msg", "Some record(s) can not be deleted.");
            }
        } else {
            return redirect('admin-dashboard/administrator/configuration/city')->with('warning_msg', "Please select records to delete.");
        }
    }
}
