<?php

namespace App\Http\Controllers\Admin\Administrator;

use App\Http\Controllers\AdminController;
use App\Notification,
    App\Record;
use App\User;
use Auth;
use App\UserRole;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Input;
use Validator;
use App\Imports\RecordsImport;
use Session;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class Records extends AdminController
{
    function __construct() {
        parent::__construct();
    }

    public function index(){
        $this->check_access('List Records');
        $Record = Record::selectRaw(
            "records.id as id,
            records.first_name as first_name, 
            records.middle_name as middle_name, 
            records.last_name as last_name,
            records.email as email,
            records.current_street as current_street,
            records.current_city as current_city,
            records.current_state as current_state, 
            records.phone_no as phone_no,
            records.old_street as old_street,
            records.old_city as old_city,
            records.old_state as old_state,
            records.dob as dob,
            records.current_emp as current_emp,
            records.policy_number as policy_number,
            records.line_of_business as line_of_business,
            records.claim_number as claim_number,
            records.loss_date as loss_date,
            records.created_at as created_at, 
            records.updated_at as updated_at, 
            a_added.name as AddedBy, 
            a_updated.name as ModifiedBy")
        ->leftJoin('users as a_added', 'records.AddedBy', '=', 'a_added.id')
        ->leftJoin('users as a_updated', 'records.ModifiedBy', '=', 'a_updated.id')
        ->get();
        foreach ($Record as $key => $r)
        {
            $record['first_name'][$key] = $r->first_name;
            $record['middle_name'][$key] = $r->middle_name;
            $record['last_name'][$key] = $r->last_name;
            $record['email'][$key] = $r->email;
            $record['current_street'][$key] = $r->current_street;
            $record['current_city'][$key] = $r->current_city;
            $record['current_state'][$key] = $r->current_state;
            $record['current_zip'][$key] = $r->current_zip;
            $record['phone_no'][$key] = $r->phone_no;
            $record['old_street'][$key] = $r->old_street;
            $record['old_city'][$key] = $r->old_city;
            $record['old_state'][$key] = $r->old_state;
            $record['old_zip'][$key] = $r->old_zip;
            $record['dob'][$key] = $r->dob;
            $record['current_emp'][$key] = $r->current_emp;
            $record['policy_number'][$key] = $r->policy_number;
            $record['line_of_business'][$key] = $r->line_of_business;
            $record['claim_number'][$key] = $r->claim_number;
            $record['loss_date'][$key] = $r->loss_date;
            $record['claim_desc'][$key] = $r->claim_desc;
            $record['AddedBy'][$key] = $r->AddedBy;
            $record['ModifiedBy'][$key] = $r->ModifiedBy;
        }
        $records = [];
        $records['first_name'] = array_unique($record['first_name']);
        $records['middle_name'] = array_unique($record['middle_name']);
        $records['last_name'] = array_unique($record['last_name']);
        $records['email'] = array_unique($record['email']);
        $records['current_street'] = array_unique($record['current_street']);
        $records['current_city'] = array_unique($record['current_city']);
        $records['current_state'] = array_unique($record['current_state']);
        $records['current_zip'] = array_unique($record['current_zip']);
        $records['phone_no'] = array_unique($record['phone_no']);
        $records['old_street'] = array_unique($record['old_street']);
        $records['old_city'] = array_unique($record['old_city']);
        $records['old_state'] = array_unique($record['old_state']);
        $records['old_zip'] = array_unique($record['old_zip']);
        $records['dob'] = array_unique($record['dob']);
        $records['current_emp'] = array_unique($record['current_emp']);
        $records['policy_number'] = array_unique($record['policy_number']);
        $records['line_of_business'] = array_unique($record['line_of_business']);
        $records['loss_date'] = array_unique($record['loss_date']);
        $records['claim_number'] = array_unique($record['claim_number']);
        $records['claim_desc'] = array_unique($record['claim_desc']);
        $records['AddedBy'] = array_unique($record['AddedBy']);
        $records['ModifiedBy'] = array_unique($record['ModifiedBy']);
        $this->data['Record'] = $records;
        return view("admin.administrator.records.list",$this->data);
    }


    public function data_list(Request $request) {
        header("Content-type: application/json; charset=utf-8");
        if(!$this->check_access('List Records', true)) {
            echo json_encode(["draw" => (int)Input::get("draw"), "recordsTotal" => 0, "recordsFiltered" => 0, "data" => [], "error" => "Access denied!"]);
            exit(0);
        }
        $start = (int)Input::get("start");
        $length = ((int)Input::get("length") > 0 ? (int)Input::get("length") : 25);
        $obj = $request->object;
        if($obj == [])
        {
            // Firebase Notification sent
            Notification::Notify(
                auth()->user()->user_type,
                $this->to_id,
                "User: ".Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." visited records list",
                'admin-dashboard/administrator/records/',
                Auth::user()->id,
                '  bg-inverse-secondary text-info',
                'mdi mdi-eye'
            );
        }
        $columns = ["records.id", "records.id", "records.first_name","records.last_name", "records.email","records.current_street", "records.current_city", "records.current_state","records.phone_no","records.old_street", "records.old_city", "records.old_state", 'records.dob',"records.current_emp","records.line_of_business","records.policy_number","records.claim_number","records.loss_date","records.created_at", "records.updated_at"];
        $query = Record::selectRaw(
                        "records.id,
                        records.first_name, 
                        records.middle_name, 
                        records.last_name,
                        records.email,
                        records.current_street,
                        records.current_city,
                        records.current_state, 
                        records.phone_no,
                        records.old_street,
                        records.old_city,
                        records.old_state,
                        records.old_zip,
                        records.dob,
                        records.current_emp,
                        records.policy_number,
                        records.line_of_business,
                        records.claim_number,
                        records.claim_number,
                        records.loss_date,
                        records.claim_desc,
                        records.created_at, 
                        records.updated_at");
                if($obj['first_name'] != null)
                {
                    $query->where('records.first_name',$obj['first_name']);

                    // Firebase Notification sent
                    Notification::Notify(
                        auth()->user()->user_type,
                        $this->to_id,
                        "User: ".Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." searched first name field in a record list against keyword ".$obj['first_name'],
                        'admin-dashboard/administrator/records/',
                        Auth::user()->id,
                        '  bg-inverse-secondary text-info',
                        'mdi mdi-eye'
                    );
                }
                if($obj['middle_name'] != null)
                {
                    $query->where('records.middle_name',$obj['middle_name']);
                    // Firebase Notification sent
                    Notification::Notify(
                        auth()->user()->user_type,
                        $this->to_id,
                        "User: ".Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." searched  middle name field in a record list against keyword: ".$obj['middle_name'],
                        'admin-dashboard/administrator/records/',
                        Auth::user()->id,
                        '  bg-inverse-secondary text-info',
                        'mdi mdi-eye'
                    );
                };
                if($obj['last_name'] != null)
                {
                    $query->where('records.last_name',$obj['last_name']);
                    // Firebase Notification sent
                    Notification::Notify(
                        auth()->user()->user_type,
                        $this->to_id,
                        "User: ".Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." searched last name field in a record list against keyword: ".$obj['last_name'],
                        'admin-dashboard/administrator/records/',
                        Auth::user()->id,
                        '  bg-inverse-secondary text-info',
                        'mdi mdi-eye'
                    );
                }
                if($obj['email'] != null)
                {
                    $query->where('records.email',$obj['email']);
                    // Firebase Notification sent
                    Notification::Notify(
                        auth()->user()->user_type,
                        $this->to_id,
                        "User: ".Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." searched email field in a record list against keyword: ".$obj['email'],
                        'admin-dashboard/administrator/records/',
                        Auth::user()->id,
                        '  bg-inverse-secondary text-info',
                        'mdi mdi-eye'
                    );
                }
                if($obj['current_street'] != null)
                {
                    $query->where('records.current_street',$obj['current_street']);
                    // Firebase Notification sent
                    Notification::Notify(
                        auth()->user()->user_type,
                        $this->to_id,
                        "User: ".Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." searched current street field in a record list against keyword: ".$obj['current_street'],
                        'admin-dashboard/administrator/records/',
                        Auth::user()->id,
                        '  bg-inverse-secondary text-info',
                        'mdi mdi-eye'
                    );
                }
                if($obj['current_city'] != null)
                {
                    $query->where('records.current_city',$obj['current_city']);
                    // Firebase Notification sent
                    Notification::Notify(
                        auth()->user()->user_type,
                        $this->to_id,
                        "User: ".Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." searched current city field in a record list against keyword: ".$obj['current_city'],
                        'admin-dashboard/administrator/records/',
                        Auth::user()->id,
                        '  bg-inverse-secondary text-info',
                        'mdi mdi-eye'
                    );
                }
                if($obj['current_state'] != null)
                {
                    $query->where('records.current_state',$obj['current_state']);
                    // Firebase Notification sent
                    Notification::Notify(
                        auth()->user()->user_type,
                        $this->to_id,
                        "User: ".Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." searched current state field in a record list against keyword: ".$obj['current_state'],
                        'admin-dashboard/administrator/records/',
                        Auth::user()->id,
                        '  bg-inverse-secondary text-info',
                        'mdi mdi-eye'
                    );
                }
                if($obj['current_zip'] != null)
                {
                    $query->where('records.current_zip',$obj['current_zip']);
                    // Firebase Notification sent
                    Notification::Notify(
                        auth()->user()->user_type,
                        $this->to_id,
                        "User: ".Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." searched current zip field in a record list against keyword: ".$obj['current_zip'],
                        'admin-dashboard/administrator/records/',
                        Auth::user()->id,
                        '  bg-inverse-secondary text-info',
                        'mdi mdi-eye'
                    );
                };
                if($obj['phone_no'] != null)
                {
                    $query->where('records.phone_no',$obj['phone_no']);
                    // Firebase Notification sent
                    Notification::Notify(
                        auth()->user()->user_type,
                        $this->to_id,
                        "User: ".Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." searched phone number field in a record list against keyword: ".$obj['phone_no'],
                        'admin-dashboard/administrator/records/',
                        Auth::user()->id,
                        '  bg-inverse-secondary text-info',
                        'mdi mdi-eye'
                    );
                }
                if($obj['old_street'] != null)
                {
                    $query->where('records.old_street',$obj['old_street']);
                    // Firebase Notification sent
                    Notification::Notify(
                        auth()->user()->user_type,
                        $this->to_id,
                        "User: ".Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." searched old street field in a record list against keyword: ".$obj['old_street'],
                        'admin-dashboard/administrator/records/',
                        Auth::user()->id,
                        '  bg-inverse-secondary text-info',
                        'mdi mdi-eye'
                    );
                }
                if($obj['old_city'] != null)
                {
                    $query->where('records.old_city',$obj['old_city']);
                    // Firebase Notification sent
                    Notification::Notify(
                        auth()->user()->user_type,
                        $this->to_id,
                        "User: ".Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." searched old city field in a record list against keyword: ".$obj['old_city'],
                        'admin-dashboard/administrator/records/',
                        Auth::user()->id,
                        '  bg-inverse-secondary text-info',
                        'mdi mdi-eye'
                    );
                }
                if($obj['old_state'] != null)
                {
                    $query->where('records.old_state',$obj['old_state']);
                    // Firebase Notification sent
                    Notification::Notify(
                        auth()->user()->user_type,
                        $this->to_id,
                        "User: ".Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." searched old state field in a record list against keyword: ".$obj['old_state'],
                        'admin-dashboard/administrator/records/',
                        Auth::user()->id,
                        '  bg-inverse-secondary text-info',
                        'mdi mdi-eye'
                    );
                }
                if($obj['old_zip'] != null)
                {
                    $query->where('records.old_zip',$obj['old_zip']);
                    // Firebase Notification sent
                    Notification::Notify(
                        auth()->user()->user_type,
                        $this->to_id,
                        "User: ".Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." searched old zip field in a record list against keyword: ".$obj['old_zip'],
                        'admin-dashboard/administrator/records/',
                        Auth::user()->id,
                        '  bg-inverse-secondary text-info',
                        'mdi mdi-eye'
                    );
                }
                if($obj['dob']  != null)
                {
                    $query->where('records.dob',$obj['dob']);
                    // Firebase Notification sent
                    Notification::Notify(
                        auth()->user()->user_type,
                        $this->to_id,
                        "User: ".Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." searched date of birth field in a record list against keyword: ".$obj['dob'],
                        'admin-dashboard/administrator/records/',
                        Auth::user()->id,
                        '  bg-inverse-secondary text-info',
                        'mdi mdi-eye'
                    );
                };
                if($obj['current_emp'] != null)
                {
                    $query->where('records.current_emp',$obj['current_emp']);
                    // Firebase Notification sent
                    Notification::Notify(
                        auth()->user()->user_type,
                        $this->to_id,
                        "User: ".Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." searched current employer field in a record list against keyword: ".$obj['current_emp'],
                        'admin-dashboard/administrator/records/',
                        Auth::user()->id,
                        '  bg-inverse-secondary text-info',
                        'mdi mdi-eye'
                    );
                }
                if($obj['policy_number'] != null)
                {
                    $query->where('records.policy_number',$obj['policy_number']);
                    // Firebase Notification sent
                    Notification::Notify(
                        auth()->user()->user_type,
                        $this->to_id,
                        "User: ".Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." searched policy number field in a record list against keyword:  ".$obj['policy_number'],
                        'admin-dashboard/administrator/records/',
                        Auth::user()->id,
                        '  bg-inverse-secondary text-info',
                        'mdi mdi-eye'
                    );
                };
                if($obj['line_of_business'] != null)
                {
                    $query->where('records.line_of_business',$obj['line_of_business']);
                    // Firebase Notification sent
                    Notification::Notify(
                        auth()->user()->user_type,
                        $this->to_id,
                        "User: ".Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." searched line of business field in a record list against keyword: ".$obj['line_of_business'],
                        'admin-dashboard/administrator/records/',
                        Auth::user()->id,
                        '  bg-inverse-secondary text-info',
                        'mdi mdi-eye'
                    );
                }
                if($obj['claim_number'] != null)
                {
                    $query->where('records.claim_number',$obj['claim_number']);
                    // Firebase Notification sent
                    Notification::Notify(
                        auth()->user()->user_type,
                        $this->to_id,
                        "User: ".Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." searched claim number field in a record list against keyword: ".$obj['claim_number'],
                        'admin-dashboard/administrator/records/',
                        Auth::user()->id,
                        '  bg-inverse-secondary text-info',
                        'mdi mdi-eye'
                    );
                }
                if($obj['loss_date'] != null)
                {
                    $query->where('records.loss_date',$obj['loss_date']);
                    // Firebase Notification sent
                    Notification::Notify(
                        auth()->user()->user_type,
                        $this->to_id,
                        "User: ".Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." searched loss date field in a record list against keyword: ".$obj['loss_date'],
                        'admin-dashboard/administrator/records/',
                        Auth::user()->id,
                        '  bg-inverse-secondary text-info',
                        'mdi mdi-eye'
                    );
                }
                if($obj['claim_desc'] != null)
                {
                    $query->where('records.claim_desc',$obj['claim_desc']);
                    // Firebase Notification sent
                    Notification::Notify(
                        auth()->user()->user_type,
                        $this->to_id,
                        "User: ".Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." searched claim description field in a record list against keyword: ".$obj['claim_desc'],
                        'admin-dashboard/administrator/records/',
                        Auth::user()->id,
                        '  bg-inverse-secondary text-info',
                        'mdi mdi-eye'
                    );
                }
                if($obj['current_emp'] != null)
                {
                    $query->where('records.current_emp',$obj['current_emp']);
                    // Firebase Notification sent
                    Notification::Notify(
                        auth()->user()->user_type,
                        $this->to_id,
                        "User: ".Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"."  current employment field in a record list against keyword: ".$obj['current_emp'],
                        'admin-dashboard/administrator/records/',
                        Auth::user()->id,
                        '  bg-inverse-secondary text-info',
                        'mdi mdi-eye'
                    );
                }

                if(Auth::user()->user_type == 2)
                {
                   $query->where('records.AddedBy',Auth::user()->id);
                }
                $query->leftJoin('users as a_added', 'records.AddedBy', '=', 'a_added.id')
                    ->leftJoin('users as a_updated', 'records.ModifiedBy', '=', 'a_updated.id');

        $recordsTotal = count($query->get());

        if (Input::get("search")["value"] != "") {
            $input = escape(trim(Input::get("search")["value"]));
            $query->whereRaw("(records.first_name LIKE '%" . $input . "%' OR records.email LIKE '%" . $input . "%' OR records.phone_no LIKE '%" . $input . "%' OR records.last_name LIKE '%" . $input . "%' OR records.current_city LIKE '%" . $input . "%' OR records.current_state LIKE '%" . $input . "%')");
        }

        $query->orderBy($columns[(int)Input::get("order")[0]["column"]], Input::get("order")[0]["dir"]);

        $recordsFiltered = count($query->get());
        $result = $query->skip($start)->take($length)->get();
        $data = [];
        foreach ($result as $key => $Rs) {
            $url = route('record-edit',['id' => $Rs->id]);
            $button_link = "location.href='".$url."'";
            $button = '<div class="btn-group"><button type="button" onclick="'.$button_link.'" class="btn btn-outline-primary btn-rounded btn-sm">Edit</button></div>';

            $data[] = [
                '<input type="checkbox" name="ids[]" id="checkbox' . $Rs->id . '" value="' . $Rs->id . '" class="checkboxes">',
                $key+1,
                unescape($Rs->first_name),
                unescape($Rs->middle_name),
                unescape($Rs->last_name),
                unescape($Rs->email),
                unescape($Rs->current_street),
                unescape($Rs->current_city),
                unescape($Rs->current_state),
                unescape($Rs->current_zip),
                unescape($Rs->phone_no),
                unescape($Rs->old_street),
                unescape($Rs->old_city),
                unescape($Rs->old_state),
                unescape($Rs->old_zip),
                unescape($Rs->dob),
                unescape($Rs->current_emp),
                unescape($Rs->policy_number),
                unescape($Rs->line_of_business),
                unescape($Rs->claim_number),
                unescape(date('d-M-y', strtotime($Rs->loss_date))),
                unescape($Rs->claim_desc),
                '<b>'.$Rs->AddedBy.'</b><br />'.$Rs->created_at,
                '<b>'.(!empty($Rs->ModifiedBy) ? $Rs->ModifiedBy : '--').'</b><br />'.$Rs->updated_at,
                $button
                    //'<button type="button" class="btn btn-outline-' . ($Rs->Status == 0 ? 'success' : 'danger') . ' btn-rounded btn-sm btn-status" id="' . $Rs->id . '" Status="' . $Rs->Status . '" '.($Rs->Status == 0 ? 'data-original-title="Click to Activate"' : 'data-original-title="Click to deactivate"').' data-placement="right"'.($Rs->user_type == 1 ? ' disabled="disabled"' : '').'><i class="fa ' . ($Rs->Status == 1 ? 'fa-eye-slash' : 'fa-eye') . '"></i></button>'+
            ];
        }

        echo json_encode(["draw" => (int)Input::get("draw"), "recordsTotal" => $recordsTotal, "recordsFiltered" => $recordsFiltered, "data" => $data]);
        exit(0);
    }


    public function importExportView()
    {
        $this->check_access('Import Records');
        return view('admin.administrator.records.import',$this->data);
    }

    public function import()
    {
        $this->check_access('Import Records');
        $v = Validator::make( [
            'extension' => strtolower(request()->file->getClientOriginalExtension()),
        ], [
                'extension'      => 'required|in:csv,xlsx,xls',
        ]);

        $v->setAttributeNames([
            'extension' => "Kindly upload excel sheet",
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        } else {
            $exampleImport = new RecordsImport();
            try{

//                Notification::create([
//                    'from_id' => Auth::user()->id,
//                    'message' => Auth::user()->name.' imported record file'
//                ]);

                // Firebase Notification sent
                Notification::Notify(
                    auth()->user()->user_type,
                    $this->to_id,
                    "User: ".Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." imported records file",
                    'admin-dashboard/administrator/records/import',
                    Auth::user()->id,
                    ' bg-inverse-success text-success',
                    'mdi mdi mdi-cloud-upload'
                );
                Excel::import( $exampleImport,  request()->file('file'));
                return redirect()->back()->with("success", "Import Successful");
            }catch ( ValidationException $e ){
                return response()->json(['success'=>'errorList','message'=> $e->errors()]);
            }
        }
    }
    public function download_eg(){
        $this->check_access('Download Sample');
        $file= public_path(). "/Trigger-Sample-Import.xlsx";
        $headers = [
            'Content-Type' => 'application/xlsx',
        ];

//        Notification::create([
//            'from_id' => Auth::user()->id,
//            'message' => Auth::user()->name.' downloaded record file'
//        ]);


        // Firebase Notification sent
        Notification::Notify(
            auth()->user()->user_type,
            $this->to_id,
            "User: ".Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." downloadeded record sample file",
            'admin-dashboard/administrator/records/download_eg',
            Auth::user()->id,
            ' bg-inverse-success text-success',
            'mdi mdi-cloud-download'
        );
        return response()->download($file, 'Trigger-Sample-Import.xlsx', $headers);
    }


    public function edit($id) {
        $this->check_access('Edit Record');
        $this->data["Record"] = Record::find($id);
        if(!empty($this->data["Record"])) {
            if($this->data["Record"]->AddedBy == 1 && auth()->user()->user_type != 1) {
                return redirect()->route("user-list")->with("warning_msg", "Records added by Super Admin are not allowed to be updated.");
            } else if($this->data["Record"]->AddedBy != auth()->user()->id && auth()->user()->user_type != 1) {
                return redirect()->route("user-list")->with("warning_msg", "You are not allowed to access records added by other user.");
            }else {

                return view('admin.administrator.records.edit', $this->data);
            }
        } else {
            return redirect()->route("record-list")->withErrors("Invalid Record ID.");
        }
    }

    public function update($id) {
        $this->check_access('Edit User');
        $rules["first_name"] = 'required|string|min:1|max:30';
        $rules["last_name"] = 'required|string|min:1|max:30';
        $rules["email"] = 'required|email';
        $rules["phone_no"] = 'required|min:1|max:40';
        $rules["current_street"] = 'max:40';
        $rules["current_city"] = 'required|string|min:1|max:30';
        $rules["current_state"] = 'required|string|min:1|max:30';
        $rules["current_zip"] = 'max:20';
        $rules["old_street"] = 'required|string|min:1|max:20';
        $rules["old_city"] = 'required|string|min:1|max:30';
        $rules["old_state"] = 'required|string|min:1|max:30';
        $rules["old_zip"] = 'max:20';
        $rules["dob"] = 'required|string|min:1|max:30';
        $rules["current_emp"] = 'max:200';
        $rules["policy_number"] = 'required|min:1|max:150';
        $rules["line_of_business"] = 'max:100';
        $rules["claim_number"] = 'required|min:1|max:150';
        $rules["loss_date"] = 'required|min:1|max:150';
        $rules["claim_desc"] = 'required|string|min:1|max:150';
        $v = Validator::make(Input::all(), $rules, [
            "first_name.required" => "First Name is required.",
            "first_name.string" => "First Name field should be a string.",
            "last_name.required" => "Last Name is required.",
            "last_name.string" => "Last Name field should be a string.",
            "email.required" => "Email field is required.",
            "phone_no.required" => "Phone Number is required.",
            "current_street.max" => "Current Street should not exceed 40 characters.",
            "current_city.required" => "Current City field is required.",
            "current_city.max" => "Current Street should not exceed 30 characters.",
            "current_state.required" => "Current State field is required.",
            "current_zip.max" => "Current ZIP Code field should not exceed 20 characters.",
            "old_street.max" => "Old Street should not exceed 40 characters.",
            "old_street.required" => "Old State field is required.",
            "old_state.max" => "Old Street should not exceed 30 characters.",
            "old_state.required" => "Old State field is required.",
            "old_zip.max" => "Old ZIP Code field should not exceed 20 characters.",
            "dob.max" => "Date of Birth field should not exceed 30 characters.",
            "dob.required" => "Date of Birth field is required.",
            "policy_number.required" => "Policy number field is required.",
            "policy_number.max" => "Policy number field should not exceed 150 characters.",
            "line_of_business.max" => "Line of Business field should not exceed 100 characters.",
            "claim_number.required" => "Claim number field is required.",
            "claim_number.max" => "Claim number field should not exceed 150 characters.",
            "loss_date.required" => "Loss Date field is required.",
            "loss_date.max" => "Loss Date field should not exceed 150 characters.",
            "claim_desc.required" => "Claim description field is required.",
            "claim_desc.max" => "Claim description field should not exceed 150 characters.",
        ]);
        $v->setAttributeNames([
            'first_name' => "First Name",
            'last_name' => "Last Name",
            'email' => "Email Address",
            'phone_no' => "Phone Number",
            'current_street' => "Current Street",
            'current_city' => "Current City",
            'current_state' => "Current State",
            'current_zip' => "Current ZIP Code",
            'old_street' => "Old Street",
            'old_state' => "Old State",
            'old_zip' => "Old ZIP Code",
            'dob' => "Date of Birth",
            'current_emp' => "Current Employer",
            'policy_number' => "Policy number",
            'line_of_business' => "Line of Business",
            'claim_number' => "Claim number",
            'loss_date' => "Loss Date",
            'claim_desc' => "Claim description",
        ]);
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        } else {
            $Record = Record::find($id);
            if(!empty($Record)) {
                if($Record->AddedBy == 1 && auth()->user()->user_type != 1) {
                    return redirect()->route("user-list")->with("warning_msg", "Records added by Super Admin are not allowed to be updated.");
                } else if($Record->AddedBy != auth()->user()->id && auth()->user()->user_type != 1) {
                    return redirect()->route("user-list")->with("warning_msg", "You are not allowed to access records added by other user.");
                }else {

                    $Record->first_name = escape(Input::get('cc_name'));
                    $Record->middle_name = escape(Input::get('middle_name'));
                    $Record->last_name = escape(Input::get('last_name'));
                    $Record->dob = escape(Input::get('dob'));
                    $Record->current_street = escape(Input::get('current_street'));
                    $Record->current_city = escape(Input::get('current_city'));
                    $Record->current_state = escape(Input::get('current_state'));
                    $Record->current_zip = escape(Input::get('current_zip'));
                    $Record->old_street = escape(Input::get('old_street'));
                    $Record->old_city = escape(Input::get('old_city'));
                    $Record->old_state = escape(Input::get('old_state'));
                    $Record->old_zip = escape(Input::get('old_zip'));
                    $Record->email = escape(Input::get('email'));
                    $Record->phone_no = escape(Input::get('phone_no'));
                    $Record->current_emp = escape(Input::get('current_emp'));
                    $Record->policy_number = escape(Input::get('policy_number'));
                    $Record->line_of_business = escape(Input::get('line_of_business'));
                    $Record->claim_number = escape(Input::get('claim_number'));
                    $Record->loss_date = escape(Input::get('loss_date'));
                    $Record->claim_desc = escape(Input::get('claim_desc'));
                    $Record->ModifiedBy = auth()->user()->id;
                    // Firebase Notification sent
                    Notification::Notify(
                        auth()->user()->user_type,
                        $this->to_id,
                        Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." updated user record, against User Name: ".$Record->name,
                        'admin-dashboard/administrator/users/edit/'.$id,
                        Auth::user()->id,
                        ' bg-inverse-primary text-primary',
                        'mdi mdi-account-multiple-plus'
                    );
                    return redirect()->route("record-list")->with('success', "Record has been updated successfully.");
                }
            } else {
                return redirect()->route("record-list")->withErrors("Invalid Record ID.");
            }
        }
    }


    public function delete() {
        $this->check_access('Delete Record');

        $super_admin = User::where('user_type',1)->get();
        $super_Admin = [];
        foreach ($super_admin as $id)
        {
            $super_Admin = $id['id'];
        }
        if(in_array($super_Admin,Input::get('ids')) && (auth()->user()->user_type != 1))
        {
            return redirect('admin-dashboard/record')->with('warning_msg', "Data Record added by Super Admin can't be deleted.");
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
                        'admin-dashboard/records',
                        Auth::user()->id,
                        '  bg-inverse-warning text-warning',
                        'mdi mdi-security'
                    );
                    if(auth()->user()->user_type != 1)
                    {
                        Record::where('AddedBy',auth()->user()->id)->whereIn('id', Input::get('ids'))->delete();
                    }else{
                        Record::whereIn('id', Input::get('ids'))->delete();
                    }
                    return redirect('admin-dashboard/record')->with('success', "Selected records have been delted successfully.");
                } catch(\Illuminate\Database\QueryException $ex) {
                    return redirect()->back()->with("warning_msg", "Some record(s) can not be deleted.");
                }
            } else {
                return redirect('admin-dashboard/administrator/record')->with('warning_msg', "Please select records to delete.");
            }
        }
    }
}
