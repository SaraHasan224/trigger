<?php

namespace App\Http\Controllers\Admin\Administrator;

use App\Http\Controllers\AdminController;
use App\Notification,
    App\Record;
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
        return view("admin.administrator.records.list",$this->data);
    }


    public function data_list() {
        header("Content-type: application/json; charset=utf-8");
        if(!$this->check_access('List Records', true)) {
            echo json_encode(["draw" => (int)Input::get("draw"), "recordsTotal" => 0, "recordsFiltered" => 0, "data" => [], "error" => "Access denied!"]);
            exit(0);
        }
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
        $start = (int)Input::get("start");
        $length = ((int)Input::get("length") > 0 ? (int)Input::get("length") : 25);

        $columns = ["records.id", "records.id", "records.first_name","records.last_name", "records.email","records.current_street", "records.current_city", "records.current_state","records.phone_no","records.old_street", "records.old_city", "records.old_state", 'records.dob',"records.current_emp","records.line_of_business","records.policy_number","records.claim_number","records.loss_date","records.created_at", "records.updated_at"];
        $query = Record::selectRaw("records.id,records.first_name, records.last_name,records.email,records.current_street,records.current_city,records.current_state, records.phone_no,records.old_street,records.old_city,records.old_state,records.dob,records.current_emp,records.policy_number,records.line_of_business,records.claim_number,records.loss_date,records.created_at, records.updated_at, a_added.name as AddedBy, a_updated.name as ModifiedBy")
            ->leftJoin('users as a_added', 'records.AddedBy', '=', 'a_added.id')
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
        foreach ($result as $Rs) {
            $data[] = [
//                '<input type="checkbox" name="ids[]" id="checkbox' . $Rs->id . '" value="' . $Rs->id . '" class="checkboxes">',
                $Rs->id,
                unescape($Rs->first_name),
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
//                '<div class="btn-group">
//<button type="button" onclick="location.href=\'' . route('user-edit', ["id" => $Rs->id]) . '\'" class="btn btn-outline-primary btn-rounded btn-sm"'.($Rs->user_type == 1 ? ' disabled="disabled"' : '').'>Edit</button>
//
//
//m
//<button type="button" class="btn btn-outline-' . ($Rs->Status == 0 ? 'success' : 'danger') . ' btn-rounded btn-sm btn-status" id="' . $Rs->id . '" Status="' . $Rs->Status . '" '.($Rs->Status == 0 ? 'data-original-title="Click to Activate"' : 'data-original-title="Click to deactivate"').' data-placement="right"'.($Rs->user_type == 1 ? ' disabled="disabled"' : '').'><i class="fa ' . ($Rs->Status == 1 ? 'fa-eye-slash' : 'fa-eye') . '"></i></button></div>'
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
}
