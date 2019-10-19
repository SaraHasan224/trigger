<?php
namespace App\Http\Controllers\Admin\Administrator;
use App\w_phone;
use App\w_school;
use App\w_socialmedia;
use App\w_spouse;
use App\Workbench_Result;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Notification;
use App\Http\Controllers\AdminController;
//  Guzzle Files import
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
// DB
use DB;
//  Import Models
use App\City,
    App\Country,
    App\State,
    App\Social,
    App\User,
    App\SourceOption,
    App\Workbench as APIModel;
// Import roles and permission files
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Input;
use Validator, Hash;
use App\TraitsFolder\APIRequestTrait;
class Workbench extends AdminController
{
    use APIRequestTrait;
    public $UserTypes = ["", "Super Admin", "Admin", "Visitor"];
    function __construct() {
        parent::__construct();
    }
    //Personal Workbench
    public function personal() {
        $this->check_access('List Workbench');

        $socials = Social::all();
        $social = [];
        foreach ($socials as $soc){ $social[strtolower($soc->name)] = $soc->name;}
        $data['social'] = $social;
        $countries = Country::all();
        $country = [];
        foreach ($countries as $coun){ array_push($country,$coun->name);}
        $data['countries'] = array_combine($country,$country);
        $data['rate_set'] = ['statdard','experimental'];
        $data['product_type'] = ['Secure File Access','AllState Fraud Activity','Claim Activity Production','Claims workflow','Demo claims workflow','Continuous Evaluation','Fraud Activity', 'Fraud Score','Neo Search','New york life clains activity','QA Copy of NY Life Claims','QA Claims Activity Monitoring','QA Copy of Fraud Activity DOL','Risk Analytics','State Farm Claims Workflow', 'Workbench'];
        $data['risk_char_comp'] = ['Accenture','Allstate claims','Allstate Test','Ashleys Company','Carpe claims','Carpe claims demo','Carpe Data Deleted subject','Carpe Data Demo','Carpe Fraud Activity','Chubb Insurance','Cindy\'s Test Company','Commercial Eligiblity','Commercial Loss Score','Data Science Test Cases','DIA Ams Test Company','Great American Insurance Company','HavenLife', 'IDI Data'];
        $data['schema'] = ['Default Person'];
        $data['source_opt'] = SourceOption::where('type',0)->get();
        return view('admin.administrator.workbench.personal', $data);
    }

/*    public function personalSave(Request $request) {
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
//            $alias_fname = Input::get('a_first_name');
//            $alias_mname = Input::get('a_middle_name');
//            $alias_lname = Input::get('a_last_name');
//            $name = [];
//            foreach ($alias_fname as $key => $f_n) {
//                array_push($name, escape($f_n) . ' ' . escape($alias_mname[$key]) . ' ' . escape($alias_lname[$key]));
//            }
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
    } */


    public function personalSave(Request $request) {
        $this->check_access('Add Workbench');
        //Get All Form Data
        $data = Input::all();
//        dd($data);

        $workbench_record = new APIModel();
        $workbench_record->first_name = $data['first_name'];
        $workbench_record->middle_name = $data['middle_name'];
        $workbench_record->last_name = $data['last_name'];
        $workbench_record->dob = $data['birth_date'];
        $workbench_record->email = $data['p_email'];
        $workbench_record->street = $data['street_address'];
        $workbench_record->country = 'US';
        $workbench_record->state = $data['state'];
        $workbench_record->zip = $data['zip'];
        $workbench_record->current_emp = $data['employer_name'];
        $workbench_record->job_title = $data['job_title'];
        $workbench_record->comment = $data['comments'];
        $workbench_record->save();
        //  Social
        $social_name = [];
        $social_url = [];
        $social_site = [];
        $social_media = [];
        foreach ($data['social']['username'] as $username){
            if($username != null){ array_push($social_name, $username); }
        }
        foreach ($data['social']['url'] as $url){
            if($url != null){ array_push($social_url, $url); }
        }
        foreach ($data['social']['site'] as $site){
            if($site != null){ array_push($social_site, $site); }
        }
        if(!empty($social_name) || !empty($social_url) || !empty($social_site))
        {
            for ($i = 0;$i < count($social_name); $i++)
            {
                $w_social = new w_socialmedia();
                $w_social->workbench_id = $workbench_record->id;
                $w_social->profile = !empty($social_name[$i]) ? $social_name[$i] : '';
                $w_social->profile_link = !empty($social_url[$i]) ? $social_url[$i] : '';
                $w_social->forum = !empty($social_site[$i]) ? $social_site[$i] : '';
                $w_social->save();

                $social_media[$i] = [
                    "profile" => !empty($social_name[$i]) ? $social_name[$i] : '',
                    "profile_link" => !empty($social_url[$i]) ? $social_url[$i] : '',
                    "forum" => !empty($social_site[$i]) ? $social_site[$i] : ''
                ];
            }
        }
        //  Spouse
        $spouse_fname = [];
        $spouse_mname = [];
        $spouse_lname = [];
        $spouse_maidenname = [];
        foreach ($data['spouse']['first_name'] as $spouse) {    if($spouse != null){ array_push($spouse_fname, $spouse); }   }
        foreach ($data['spouse']['middle_name'] as $spouse) {   if($spouse != null){  array_push($spouse_mname, $spouse); }   }
        foreach ($data['spouse']['last_name'] as $spouse) {   if($spouse != null){  array_push($spouse_lname, $spouse);  }  }
        foreach ($data['spouse']['maiden_name'] as $spouse) {   if($spouse != null){  array_push($spouse_maidenname, $spouse); }   }
        if(!empty($spouse_fname) || !empty($spouse_mname) || !empty($spouse_lname) || !empty($spouse_maidenname))
        {
            for($i=0;$i<count($spouse_fname);$i++)
            {
                $spouse = new w_spouse();
                $spouse->workbench_id = $workbench_record->id;
                $spouse->first_name = $spouse_fname[$i];
                $spouse->middle_name = $spouse_mname[$i];
                $spouse->last_name = $spouse_lname[$i];
                $spouse->maiden_name = $spouse_maidenname[$i];
                $spouse->save();
            }
        }

        // Phone Number
        foreach ($data['phone_number'] as $key => $num) {
            if($num != null){
                $phone_num = new w_phone();
                $phone_num->workbench_id = $workbench_record->id;
                $phone_num->number = $num;
                $phone_num->save();
            }
        }

        // School Name
        foreach ($data['school_name'] as $key => $num) {
            if($num != null){
                $school = new w_school();
                $school->workbench_id = $workbench_record->id;
                $school->name = $num;
                $school->save();
            }
        }



        //Select options checked (APIs that has to be hit
        $checked_option = Input::get('opt');

        $source_opt = SourceOption::where('type',0)->where('default',1)->get();
        foreach ($source_opt as $opt)
        {
            $value_exists = array_key_exists($opt->identifier_name,$checked_option);
//            dd($opt->identifier_name);
            if($value_exists)
            {
                switch ($opt->identifier_name) {
                    case 'bing-address':
                        $this->bingAddress();
                        break;
                    case 'bing-alias':
                        $this->bingAddress();
                        break;
                    case 'bing-contact':
                        $this->bingAddress();
                        break;
                    case 'bing-name':
                        $this->bingAddress();
                        break;
                    case 'bing-name-address':
                        $this->bingAddress();
                        break;
                    case 'bing-name-dob':
                        $this->bingAddress();
                        break;
                    case 'bing-name-keyword':
                        $this->bingAddress();
                        break;
                    case 'byteplant':
                        $this->bingAddress();
                        break;
                    case 'clearbit':
                        $this->clearbit($workbench_record->id);
                        break;
                    case 'flip-top':
                        $this->bingAddress();
                        break;
                    case 'full-contact':
                        $this->bingAddress();
                        break;
                    case 'g-cust_address1':
                        $this->bingAddress();
                        break;
                    case 'g-cust_contact':
                        $this->bingAddress();
                        break;
                    case 'g-cust_name':
                        $this->bingAddress();
                        break;
                    case 'g-cust_dob':
                        $this->bingAddress();
                        break;
                    case 'g-cust_username':
                        $this->bingAddress();
                        break;
                    case 'g-site_address1':
                        $this->bingAddress();
                        break;
                    case 'g-site_contact':
                        $this->bingAddress();
                        break;
                    case 'g-site_name':
                        $this->bingAddress();
                        break;
                    case 'g-site_dob':
                        $this->bingAddress();
                        break;
                    case 'g-site_obit':
                        $this->bingAddress();
                        break;
                    case 'g-site_username':
                        $this->bingAddress();
                        break;
                    case 'piple':
                        $this->bingAddress();
                        break;
                    case 'piplev5':
                        $this->bingAddress();
                        break;
                }
            }
        }
      return redirect('admin-dashboard/workbench/personal/result/'.$workbench_record->id);
    }



    public function recursion($item, $key)
    {
        global $array;
        $array[] = [$key,$item];
    }
    public function personalResult($workbench_id) {
        $this->check_access('List Workbench');
//      Form Data (Person Data Search)
        $this->data['record'] = APIModel::whereId($workbench_id)->first();
//      API Response (Person Data Search)
        $result = Workbench_Result::where('workbench_id',$workbench_id)->orderBy('score','DESC')->first();
        /*
            // This function will return unique values from an array
            function array_unique_recursive($array)
            {
                $array = array_unique($array, SORT_REGULAR);
                foreach ($array as $key => $elem) {
                    if (is_array($elem)) {
                        $array[$key] = array_unique_recursive($elem);
                    }
                }
                return $array;
            }

            // This function will remove empty entries of an array recursively
            function array_remove_empty($haystack)
            {
                foreach ($haystack as $key => $value) {
                    if (is_array($value)) {
                        $haystack[$key] = array_remove_empty($haystack[$key]);
                    }

                    if (empty($haystack[$key])) {
                        unset($haystack[$key]);
                    }
                }

                return $haystack;
            }

            $result_array = [];
            foreach ($result as $key => $r)
            {
                ${"decoded" . $key} = json_decode($r,true);
            }
            //
                $final_res is a variable that will merge all API responses using "array_merge_recursive($decoded0,$decoded1)".

                result of merged array contain repeated records that should not happen thus a
                recursive unique function is set up that will return unique values from an array
                using "array_unique_recursive()"

                result of unique array also contain null values thus "array_remove_empty" function is used
            //
        $final_res = array_remove_empty(array_unique_recursive(array_merge_recursive($decoded0,$decoded1)));
        */
        $result_recieved = '';
        $this->data['result_date'] = Carbon::now();

        if($result != [])
        {
            $this->getResults($result);
            $result_recieved = json_decode($result->result,true);
            $this->data['result_date'] = $result->created_at;
        }

        $result_parsed = [];

        if($result_recieved != "")
        {
            if(!(array_key_exists("person",$result_recieved)) && !(array_key_exists("company",$result_recieved)))
            {
                $result_parsed = [];
            }
            if(array_key_exists("person",$result_recieved))
            {
                $result_parsed['github'] = [
                    'company' => $result_recieved['person']['github']['company'],
                    'avatar' => $result_recieved['person']['github']['avatar'],
                    'handle' => ($result_recieved['person']['github']['handle'] != NULL) ? 'https://twitter.com/' . $result_recieved['person']['github']['handle'] : NULL,
                    'followers' => $result_recieved['person']['github']['followers'],
                    'following' => $result_recieved['person']['github']['following'],
                ];
                if(in_array(null, $result_recieved['person']['twitter'], true)) {
                    $result_parsed['twitter'] = [
                        'bio' => $result_recieved['person']['twitter']['bio'],
                        'avatar' => $result_recieved['person']['twitter']['avatar'],
                        'handle' => ($result_recieved['person']['twitter']['handle'] != NULL) ? 'https://twitter.com/' . $result_recieved['person']['twitter']['handle'] : NULL,
                        'followers' => $result_recieved['person']['twitter']['followers'],
                        'following' => $result_recieved['person']['twitter']['following'],
                    ];
                }
                else{
                    $result_parsed['twitter'] = [];
                }
                $result_parsed['facebook'] = [
                    'handle' => ($result_recieved['person']['facebook']['handle'] != NULL) ? 'https://facebook.com/' . $result_recieved['person']['facebook']['handle'] : NULL,
                ];
                $result_parsed['linkedin'] = [
                    'handle' => ($result_recieved['person']['linkedin']['handle'] != NULL) ? 'https://facebook.com/'.$result_recieved['person']['linkedin']['handle'] : '',
                ];
                $result_parsed['personal'] = [
                    'bio' => $result_recieved['person']['personal']['bio'],
                    'site' => $result_recieved['person']['personal']['site'],
                    'email' => $result_recieved['person']['personal']['email'],
                    'avatar' => $result_recieved['person']['personal']['avatar'],
                    'fullName' => $result_recieved['person']['personal']['fullName'],
                    'works_at' => $result_recieved['person']['employment']['name'],
                    'work_role' => $result_recieved['person']['employment']['title'],
                    'company_domain' => $result_recieved['person']['employment']['domain'],
                    'latitude' => $result_recieved['person']['geo_location']['lat'],
                    'timezone' => $result_recieved['person']['geo_location']['timeZone'],
                    'longitude' => $result_recieved['person']['geo_location']['lng'],
                    'location' => $result_recieved['person']['geo_location']['city'].' , '.$result_recieved['person']['geo_location']['state'].' , '.$result_recieved['person']['geo_location']['country'],
                ];
            }
            if(array_key_exists("company",$result_recieved)){
                $result_parsed['logo'] = $result_recieved['company']['logo']['logo'];
                $result_parsed['alexaGlobalRank'] = $result_recieved['company']['metrics']['alexaGlobalRank'];
                if(in_array(null, $result_recieved['company']['twitter'], true))
                {
                    $result_parsed['twitter'] = [
                        'bio' => $result_recieved['company']['twitter']['bio'],
                        'site' => $result_recieved['company']['twitter']['site'],
                        'avatar' => $result_recieved['company']['twitter']['avatar'],
                        'handle' => ($result_recieved['company']['twitter']['handle'] != NULL) ? 'https://twitter.com/' . $result_recieved['company']['twitter']['handle'] : NULL,

                    ];
                }else{
                    $result_parsed['twitter'] = [];
                }

                $result_parsed['business'] = [
                    'name' => $result_recieved['company']['business']['name'],
                    'location' => $result_recieved['company']['business']['location'],
                    'description' => $result_recieved['company']['business']['description'],
                    'latitude' => $result_recieved['company']['geo_location']['lat'],
                    'longitude' => $result_recieved['company']['geo_location']['lng'],
                ];
                $result_parsed['facebook'] = [
                    'likes' => $result_recieved['company']['facebook']['likes'],
                    'handle' =>  ($result_recieved['company']['facebook']['handle'] != NULL) ?  'https://facebook.com/'.$result_recieved['company']['facebook']['handle'] : ''
                ];
                $result_parsed['linkedin'] = [
                    'handle' => ($result_recieved['company']['linkedin']['handle'] != NULL) ? 'https://linkedin.com/in/'.$result_recieved['company']['linkedin']['handle'] : null
                ];
                $result_parsed['crunchbase_handle'] = [
                    'handle' => $result_recieved['company']['crunchbase_handle']['handle']
                ];
            }
        }

        $this->data['result'] = $result_parsed;
//        dd($this->data);
        return view('admin.administrator.workbench.result-personal', $this->data);
    }

    //Business Workbench
    public function business() {
        $this->check_access('List Workbench');
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
        $data['source_opt'] = SourceOption::where('type',1)->get();
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
        return view('admin.administrator.workbench.result-business', $data);
    }
    //claim search
    public function claim() {
        $this->check_access('List Workbench');
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
