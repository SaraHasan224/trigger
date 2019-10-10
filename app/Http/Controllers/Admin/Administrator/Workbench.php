<?php
namespace App\Http\Controllers\Admin\Administrator;
use Illuminate\Http\Request;
use App\Notification;
use App\Http\Controllers\Admin\Administrator\APIController;
//  Guzzle Files import
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
//  Import Models
use App\City,
    App\Country,
    App\State,
    App\Social,
    App\User;
// Import roles and permission files
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Input;
use Validator, Hash;
class Workbench extends APIController
{
    public $UserTypes = ["", "Super Admin", "Admin", "Visitor"];
    function __construct() {
        parent::__construct();
    }
    //Personal Workbench
    public function personal() {
        $this->check_access('List Workbench');
        if(auth()->user()->user_type == 1) {
            $data['notification'] = Notification::orderBy('id','DESC')->take(6)->get();
        }else{
            $data['notification'] = Notification::where('from_id',auth()->user()->id)->orderBy('id','DESC')->take(6)->get();
        }
        $socials = Social::all();
        $social = [];
        foreach ($socials as $soc){ array_push($social,$soc->name);}
        $data['social'] = $social;
        $countries = Country::all();
        $country = [];
        foreach ($countries as $coun){ array_push($country,$coun->name);}
        $data['countries'] = array_combine($country,$country);
        $data['rate_set'] = ['statdard','experimental'];
        $data['product_type'] = ['Secure File Access','AllState Fraud Activity','Claim Activity Production','Claims workflow','Demo claims workflow','Continuous Evaluation','Fraud Activity', 'Fraud Score','Neo Search','New york life clains activity','QA Copy of NY Life Claims','QA Claims Activity Monitoring','QA Copy of Fraud Activity DOL','Risk Analytics','State Farm Claims Workflow', 'Workbench'];
        $data['risk_char_comp'] = ['Accenture','Allstate claims','Allstate Test','Ashleys Company','Carpe claims','Carpe claims demo','Carpe Data Deleted subject','Carpe Data Demo','Carpe Fraud Activity','Chubb Insurance','Cindy\'s Test Company','Commercial Eligiblity','Commercial Loss Score','Data Science Test Cases','DIA Ams Test Company','Great American Insurance Company','HavenLife', 'IDI Data'];
        $data['schema'] = ['Default Person'];
        $data['source_opt'] = ['bing address','bing alias','bing contact','bing name','bing name address','bing name dob','bing name keyword','byteplant','clearbit person','Fliptop','Full Contact','Google custom address 1','Google custom contact','Google custom name','Google custom name dob','Google custom username','Google site address 1','Google site contact','Google site name','Google site DOB','Google site Obit','Google site username','Pipl','Piplv5 full','Qa test','TowerData','TowerData EVP','TowerData Phone','Twitter','Twitter tweet','URL','Whitepages'];
        return view('admin.administrator.workbench.personal', $data);
    }
    public function personalSave(Request $request) {
        $this->check_access('Add Workbench');
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'p_email'=>'required',
            'phone_locale' => 'required'
        ];
        $v = Validator::make(Input::all(), $rules, [
            "first_name.required" => "Please enter first name.",
            "last_name.required" => "Please enter last name.",
            "p_email.required" => "Please enter email.",
        ]);
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }else {
            //Name
            $first_name = escape(Input::get('first_name'));
            $middle_name = escape(Input::get('middle_name'));
            $last_name = escape(Input::get('last_name'));
            if ($middle_name != '') {
                $names = $first_name . ' ' . $middle_name . ' ' . $last_name;
            }
            else {
                $names = $first_name . ' ' . $last_name;
            }
            //Date of Birth
            $birth_date = escape(Input::get('birth_date'));
            //Alias
            $alias_fname = Input::get('a_first_name');
            $alias_mname = Input::get('a_middle_name');
            $alias_lname = Input::get('a_last_name');
            $name = [];
            foreach ($alias_fname as $key => $f_n) {
                array_push($name, escape($f_n) . ' ' . escape($alias_mname[$key]) . ' ' . escape($alias_lname[$key]));
            }
            //Email Address
            $email = Input::get('p_email');
            $p_email = [];
            foreach ($email as $resp) {
                array_push($p_email, escape($resp));
            }
            //Social
            $social_name = Input::get('username');
            $social_url = Input::get('social_url');
            $social_forum = Input::get('site');
            $s_name = [];
            $s_url = [];
            $s_forum = [];
            if ($social_name != []) {
                foreach ($social_name as $key => $resp) {
                    if ($resp != '') {
                        array_push($s_name, escape($resp));
                    }
                    if ($social_url[$key] != '') {
                        array_push($s_url, escape($social_url[$key]));
                    };
                    if ($social_forum[$key] != '') {
                        array_push($s_forum, escape($social_forum[$key]));
                    };
                }
            }
            //Phone Number
            $phone_number = Input::get('phone_number');
            $p_phone_number = [];
            foreach ($phone_number as $resp) {
                array_push($p_phone_number, escape($resp));
            }
            //Address
            $address = Input::get('current_address');
            $country = Input::get('p_country');
            $state = Input::get('p_state');
            $city = Input::get('p_city');
            $zip = Input::get('p_zip');
            //School
            $school = Input::get('school_name');
            $p_school = [];
            foreach ($school as $resp) {
                array_push($p_school, escape($resp));
            }
            //Employee
            $company_name = escape(Input::get('emp_cmp_name'));
            $job_title = escape(Input::get('job_title'));
            //Spouse
            $sp_fname = Input::get('sp_first_name');
            $sp_mname = Input::get('sp_middle_name');
            $sp_lname = Input::get('sp_last_name');
            $sp_name = [];
            if ($sp_fname != []) {
                foreach ($sp_fname as $key => $resp) {
                    if ($resp != '') {
                        array_push($p_emp_title, escape($resp));
                    }
                }
            }
            $lang_code = Input::get('phone_locale');
            $c_code = Input::get('phone_code');
            //Have I Been Pwned
                //$hibp_response = $this->hibp($p_email);
                //dd($hibp_response);
            //Rocket Reach API
                //$rocket_reach_response = $this->rocket_reach($names,$company_name,$job_title);
                //dd($rocket_reach_response);
            //Block Dispossal Emails
                //$bd_response = $this->block_dispossal($p_email);
                //dd($bd_response);
            //Byte Plant Phone Validator
                //$validate_phone = $this->byteplant_phone_validate($p_phone_number,$country,$lang_code);
                //dd($validate_phone);
            //Byte Plant Address Validator
                //$validate_address = $this->byteplant_address_validate($address,$country,$zip,$state,$country,$lang_code);
                //dd($validate_address);
            //Everyone API
                //$e_api_result = $this->everyoneAPI($c_code,$p_phone_number);
                //dd($e_api_result);
            //Social Searcher
            return redirect()->back()->with('success', "User has been added successfully.");
        }
    }
    public function personalResult() {
        $this->check_access('List Workbench');
        if(auth()->user()->user_type == 1) {
            $data['notification'] = Notification::orderBy('id','DESC')->take(6)->get();
        }else{
            $data['notification'] = Notification::where('from_id',auth()->user()->id)->orderBy('id','DESC')->take(6)->get();
        }
        return view('admin.administrator.workbench.result-personal', $data);
    }

    //Business Workbench
    public function business() {
        $this->check_access('List Workbench');
        if(auth()->user()->user_type == 1) {
            $data['notification'] = Notification::orderBy('id','DESC')->take(6)->get();
        }else{
            $data['notification'] = Notification::where('from_id',auth()->user()->id)->orderBy('id','DESC')->take(6)->get();
        }
        $socials = Social::all();
        $social = [];
        foreach ($socials as $soc){ array_push($social,$soc->name);}
        $data['social'] = $social;
        $countries = Country::all();
        $country = [];
        foreach ($countries as $coun){ array_push($country,$coun->name);}
        $data['risk_char'] = ['Beauty Shops','Deli and Sandwich Shop','Eating or Drinking Places','Electrical Machinery, Equipment, and Supplies','Employment Agencies','General','Hotels and Motels','Medical Office','Personal Trainer','Photography and Videography'];
        $data['index_seg'] = ['Construction','Construction / Contracter','Contracter','Entertainment','General','Habitational','Health/Fitness','Hotel/Motel','Professional Office','Restraunt','Retail','Technology'];
        $data['countries'] = array_combine($country,$country);
        $data['rate_set'] = ['statdard','experimental'];
        $data['product_type'] = ['Secure File Access','AllState Fraud Activity','Claim Activity Production','Claims workflow','Demo claims workflow','Continuous Evaluation','Fraud Activity', 'Fraud Score','Neo Search','New york life clains activity','QA Copy of NY Life Claims','QA Claims Activity Monitoring','QA Copy of Fraud Activity DOL','Risk Analytics','State Farm Claims Workflow', 'Workbench'];
        $data['risk_char_comp'] = ['Accenture','Allstate claims','Allstate Test','Ashleys Company','Carpe claims','Carpe claims demo','Carpe Data Deleted subject','Carpe Data Demo','Carpe Fraud Activity','Chubb Insurance','Cindy\'s Test Company','Commercial Eligiblity','Commercial Loss Score','Data Science Test Cases','DIA Ams Test Company','Great American Insurance Company','HavenLife', 'IDI Data'];
        $data['schema'] = ['Default Business 1.28.16'];
        $data['source_opt'] = ['Bing Business Address','Bing Business Address 1','Bing Business Address 2','Bing Business Email','Bing Business Name','Bing Business Name Address','Bing Business Name Industry','Bing Business Phone','Bing Business Ticker','Bing Business Website','Bizapedia','Byteplant','Chain Business','City Grid','Clearbit','DOL OSHA','DOL WHD','Facebook Elastic Search','Foursquare','Full contact business','Glassdoor','Google Custom Business','Google Custom Business Images','Google Custom Business Phone','Google Custom Business Website','Google Custom Targeted Business','Google Custom Targeted Business Address1','Google Custom Targeted Business Address2','Google Custom Targeted Business Address3','Google Custom Targeted Business Email','Google Custom Targeted Business Phone','Google Places','Indeed','Infoconnect','TowerData','TowerData EVP',' TowerData Phone','USZip','Whitepages','Yellowpages','Yelp','Yelp Partner'];
        return view('admin.administrator.workbench.business', $data);
    }
    public function businessSave(Request $request) {
        $this->check_access('Add Workbench');
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'p_email'=>'required',
            'phone_locale' => 'required'
        ];
        $v = Validator::make(Input::all(), $rules, [
            "first_name.required" => "Please enter first name.",
            "last_name.required" => "Please enter last name.",
            "p_email.required" => "Please enter email.",
        ]);
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }else {
            //Name
            $first_name = escape(Input::get('first_name'));
            $middle_name = escape(Input::get('middle_name'));
            $last_name = escape(Input::get('last_name'));
            if ($middle_name != '') {
                $names = $first_name . ' ' . $middle_name . ' ' . $last_name;
            }
            else {
                $names = $first_name . ' ' . $last_name;
            }
            //Date of Birth
            $birth_date = escape(Input::get('birth_date'));
            //Alias
            $alias_fname = Input::get('a_first_name');
            $alias_mname = Input::get('a_middle_name');
            $alias_lname = Input::get('a_last_name');
            $name = [];
            foreach ($alias_fname as $key => $f_n) {
                array_push($name, escape($f_n) . ' ' . escape($alias_mname[$key]) . ' ' . escape($alias_lname[$key]));
            }
            //Email Address
            $email = Input::get('p_email');
            $p_email = [];
            foreach ($email as $resp) {
                array_push($p_email, escape($resp));
            }
            //Social
            $social_name = Input::get('username');
            $social_url = Input::get('social_url');
            $social_forum = Input::get('site');
            $s_name = [];
            $s_url = [];
            $s_forum = [];
            if ($social_name != []) {
                foreach ($social_name as $key => $resp) {
                    if ($resp != '') {
                        array_push($s_name, escape($resp));
                    }
                    if ($social_url[$key] != '') {
                        array_push($s_url, escape($social_url[$key]));
                    };
                    if ($social_forum[$key] != '') {
                        array_push($s_forum, escape($social_forum[$key]));
                    };
                }
            }
            //Phone Number
            $phone_number = Input::get('phone_number');
            $p_phone_number = [];
            foreach ($phone_number as $resp) {
                array_push($p_phone_number, escape($resp));
            }
            //Address
            $address = Input::get('current_address');
            $country = Input::get('p_country');
            $state = Input::get('p_state');
            $city = Input::get('p_city');
            $zip = Input::get('p_zip');
            //School
            $school = Input::get('school_name');
            $p_school = [];
            foreach ($school as $resp) {
                array_push($p_school, escape($resp));
            }
            //Employee
            $company_name = escape(Input::get('emp_cmp_name'));
            $job_title = escape(Input::get('job_title'));
            //Spouse
            $sp_fname = Input::get('sp_first_name');
            $sp_mname = Input::get('sp_middle_name');
            $sp_lname = Input::get('sp_last_name');
            $sp_name = [];
            if ($sp_fname != []) {
                foreach ($sp_fname as $key => $resp) {
                    if ($resp != '') {
                        array_push($p_emp_title, escape($resp));
                    }
                }
            }
            $lang_code = Input::get('phone_locale');
            $c_code = Input::get('phone_code');
            //Have I Been Pwned
                //$hibp_response = $this->hibp($p_email);
                //dd($hibp_response);
            //Rocket Reach API
                //$rocket_reach_response = $this->rocket_reach($names,$company_name,$job_title);
                //dd($rocket_reach_response);
            //Block Dispossal Emails
                //$bd_response = $this->block_dispossal($p_email);
                //dd($bd_response);
            //Byte Plant Phone Validator
                //$validate_phone = $this->byteplant_phone_validate($p_phone_number,$country,$lang_code);
                //dd($validate_phone);
            //Byte Plant Address Validator
                //$validate_address = $this->byteplant_address_validate($address,$country,$zip,$state,$country,$lang_code);
                //dd($validate_address);
            //Everyone API
                //$e_api_result = $this->everyoneAPI($c_code,$p_phone_number);
                //dd($e_api_result);
            //Social Searcher
            $output = 'success'; $code = 'User has been added successfully';
            return response()->json($output, $code);
            // return redirect()->back()->with('success', "User has been added successfully.");
        }
    }
    public function businessResult() {
        $this->check_access('List Workbench');
        if(auth()->user()->user_type == 1) {
            $data['notification'] = Notification::orderBy('id','DESC')->take(6)->get();
        }else{
            $data['notification'] = Notification::where('from_id',auth()->user()->id)->orderBy('id','DESC')->take(6)->get();
        }
        return view('admin.administrator.workbench.result-business', $data);
    }
    //claim search
    public function claim() {
        $this->check_access('List Workbench');
        if(auth()->user()->user_type == 1) {
            $data['notification'] = Notification::orderBy('id','DESC')->take(6)->get();
        }else{
            $data['notification'] = Notification::where('from_id',auth()->user()->id)->orderBy('id','DESC')->take(6)->get();
        }
        $socials = Social::all();
        $social = [];
        foreach ($socials as $soc){ array_push($social,$soc->name);}
        $data['social'] = $social;
        $countries = Country::all();
        $country = [];
        foreach ($countries as $coun){ array_push($country,$coun->name);}
        $data['countries'] = array_combine($country,$country);
        $data['rate_set'] = array_combine($social,$social);
        $data['product_type'] = array_combine($social,$social);
        $data['risk_char_comp'] = array_combine($social,$social);
        return view('admin.administrator.claim.index', $data);
    }
    public function claimSave(Request $request) {
        $this->check_access('Add Workbench');
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'p_email'=>'required',
            'phone_locale' => 'required'
        ];
        $v = Validator::make(Input::all(), $rules, [
            "first_name.required" => "Please enter first name.",
            "last_name.required" => "Please enter last name.",
            "p_email.required" => "Please enter email.",
        ]);
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }else {
            //Name
            $first_name = escape(Input::get('first_name'));
            $middle_name = escape(Input::get('middle_name'));
            $last_name = escape(Input::get('last_name'));
            if ($middle_name != '') {
                $names = $first_name . ' ' . $middle_name . ' ' . $last_name;
            }
            else {
                $names = $first_name . ' ' . $last_name;
            }
            //Date of Birth
            $birth_date = escape(Input::get('birth_date'));
            //Alias
            $alias_fname = Input::get('a_first_name');
            $alias_mname = Input::get('a_middle_name');
            $alias_lname = Input::get('a_last_name');
            $name = [];
            foreach ($alias_fname as $key => $f_n) {
                array_push($name, escape($f_n) . ' ' . escape($alias_mname[$key]) . ' ' . escape($alias_lname[$key]));
            }
            //Email Address
            $email = Input::get('p_email');
            $p_email = [];
            foreach ($email as $resp) {
                array_push($p_email, escape($resp));
            }
            //Social
            $social_name = Input::get('username');
            $social_url = Input::get('social_url');
            $social_forum = Input::get('site');
            $s_name = [];
            $s_url = [];
            $s_forum = [];
            if ($social_name != []) {
                foreach ($social_name as $key => $resp) {
                    if ($resp != '') {
                        array_push($s_name, escape($resp));
                    }
                    if ($social_url[$key] != '') {
                        array_push($s_url, escape($social_url[$key]));
                    };
                    if ($social_forum[$key] != '') {
                        array_push($s_forum, escape($social_forum[$key]));
                    };
                }
            }
            //Phone Number
            $phone_number = Input::get('phone_number');
            $p_phone_number = [];
            foreach ($phone_number as $resp) {
                array_push($p_phone_number, escape($resp));
            }
            //Address
            $address = Input::get('current_address');
            $country = Input::get('p_country');
            $state = Input::get('p_state');
            $city = Input::get('p_city');
            $zip = Input::get('p_zip');
            //School
            $school = Input::get('school_name');
            $p_school = [];
            foreach ($school as $resp) {
                array_push($p_school, escape($resp));
            }
            //Employee
            $company_name = escape(Input::get('emp_cmp_name'));
            $job_title = escape(Input::get('job_title'));
            //Spouse
            $sp_fname = Input::get('sp_first_name');
            $sp_mname = Input::get('sp_middle_name');
            $sp_lname = Input::get('sp_last_name');
            $sp_name = [];
            if ($sp_fname != []) {
                foreach ($sp_fname as $key => $resp) {
                    if ($resp != '') {
                        array_push($p_emp_title, escape($resp));
                    }
                }
            }
            $lang_code = Input::get('phone_locale');
            $c_code = Input::get('phone_code');
            //Have I Been Pwned
                //$hibp_response = $this->hibp($p_email);
                //dd($hibp_response);
            //Rocket Reach API
                //$rocket_reach_response = $this->rocket_reach($names,$company_name,$job_title);
                //dd($rocket_reach_response);
            //Block Dispossal Emails
                //$bd_response = $this->block_dispossal($p_email);
                //dd($bd_response);
            //Byte Plant Phone Validator
                //$validate_phone = $this->byteplant_phone_validate($p_phone_number,$country,$lang_code);
                //dd($validate_phone);
            //Byte Plant Address Validator
                //$validate_address = $this->byteplant_address_validate($address,$country,$zip,$state,$country,$lang_code);
                //dd($validate_address);
            //Everyone API
                //$e_api_result = $this->everyoneAPI($c_code,$p_phone_number);
                //dd($e_api_result);
            //Social Searcher
            return redirect()->back()->with('success', "User has been added successfully.");
        }
    }
}
