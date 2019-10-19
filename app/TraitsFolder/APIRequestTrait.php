<?php
namespace App\TraitsFolder;
use App\Workbench_Result;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Auth;
use App\Notification;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Validator;

trait APIRequestTrait
{
    // My custom recursive function for matching score
    public function calc_score($response)
    {
        global $keyCount;
        global $nullCount;
//        $json = json_decode($response,true);
        $json = json_decode(json_encode($response),true);
        $keyCount = $nullCount = 0;
        array_walk_recursive($json, 'self::recursive');

        $percentage = ($keyCount-$nullCount)/$keyCount;
        $percent = number_format($percentage,1);
//        echo "<p>Key: $keyCount, Null: $nullCount, Percentage: $percent";
        return $percent;
    }

    //Call our recursive function for removing null values from responses received.
    public function recursive($item, $key)
    {
        global $keyCount, $nullCount;
        $keyCount++;
        if(empty($item)) {
            $nullCount++;
        }
//        echo "$key holds <b>$item</b>\n";
//        echo "<br/>";
    }

    //
    function parse_clearbit_json($item, $key,$arr_values)
    {
        global $result_api;
        global $final_res;
        global $i;
        $i++;
        $current_res = $arr_values['res_key'];
        $identifier = $arr_values['key'];

        if(is_array($result_api[$current_res]))
        {
            foreach ($result_api[$current_res] as $r_key => $r_val) {
                if ($r_key == $key) {
                    if (!is_array($r_val)) {
                        $final_res["$current_res"][$identifier][$item] = $r_val;
                    }
                    else {
                        if ($item == "") {
                            $final_res["$current_res"][$identifier][$item] = "";
                        }
                        elseif ($item == []) {
                            $final_res["$current_res"][$identifier][$item] = [];
                        }
                        else {
                            if(array_key_exists($item,$r_val) == 1)
                            {
                                $final_res["$current_res"][$identifier][$item] = $r_val[$item];
                            }else{

                                $final_res["$current_res"][$identifier][$item] = "";
                            }
                        }
                    }
                }
            }
        }

    }

    public function getResults($result)
    {
        global $result_api;
        global $final_res;
//        foreach ($result as $item) {
            if($result->source_options_id == 14)
            {
                $result_api = json_decode($result->response,true);

                $final_res = [];

                global $i;
                $i = 0;

                foreach ($result_api as $res_key => $v)
                {
                    if($res_key == "person")
                    {
                        $json  = '{"geo_location":{"latitude":{"person":{"geo":"lat"}},"longitude":{"person":{"geo":"lng"}},"city":{"person":{"geo":"city"}},"state":{"person":{"geo":"state"}},"stateCode":{"person":{"geo":"stateCode"}},"country":{"person":{"geo":"country"}},"countryCode":{"person":{"geo":"countryCode"}},"location":{"person":{"location":"location"}},"timezone":{"person":{"timeZone":"timeZone"}}},"personal":{"name":{"person":{"name":"fullName"}},"bio":{"person":{"bio":"bio"}},"site":{"person":{"site":"site"}},"email":{"person":{"email":"email"}},"avatar":{"person":{"avatar":"avatar"}}},"employment":{"name":{"person":{"employment":"name"}},"role":{"person":{"employment":"role"}},"title":{"person":{"employment":"title"}},"domain":{"person":{"employment":"domain"}},"subRole":{"person":{"employment":"subRole"}},"seniority":{"person":{"employment":"seniority"}}},"github":{"id":{"person":{"github":"id"}},"blog":{"person":{"github":"blog"}},"avatar":{"person":{"github":"avatar"}},"handle":{"person":{"github":"handle"}},"company":{"person":{"github":"company"}},"followers":{"person":{"github":"followers"}},"following":{"person":{"github":"following"}}},"twitter":{"id":{"person":{"twitter":"id"}},"bio":{"person":{"twitter":"bio"}},"site":{"person":{"twitter":"site"}},"avatar":{"person":{"twitter":"avatar"}},"handle":{"person":{"twitter":"handle"}},"statuses":{"person":{"twitter":"statuses"}},"favorites":{"person":{"twitter":"favorites"}},"followers":{"person":{"twitter":"followers"}},"following":{"person":{"twitter":"following"}}},"facebook":{"handle":{"person":{"facebook":"handle"}}},"gravatar":{"urls":{"person":{"gravatar":"urls"}},"avatar":{"person":{"gravatar":"avatar"}},"handle":{"person":{"gravatar":"handle"}},"avatars":{"person":{"gravatar":"avatars"}}},"linkedin":{"person":{"linkedin":"handle"}}}';
                    }
                    elseif ($res_key == "company")
                    {
                        $json  = '{"geo_location":{"latitude":{"company":{"geo":"lat"}},"longitude":{"company":{"geo":"lng"}},"suitNumber":{"company":{"geo":"subPremise"}},"streetNumber":{"company":{"geo":"streetNumber"}},"streetName":{"company":{"geo":"streetName"}},"state":{"company":{"geo":"state"}},"stateCode":{"company":{"geo":"stateCode"}},"city":{"company":{"geo":"city"}},"country":{"company":{"geo":"country"}},"countryCode":{"company":{"geo":"countryCode"}}},"logo":{"company":{"logo":"logo"}},"business":{"name":{"company":{"name":"name"}},"email":{"company":{"site":"emailAddresses"}},"phone_number":{"company":{"site":"phoneNumbers"}},"phone":{"company":{"phone":"phone"}},"location":{"company":{"location":"location"}},"timeZone":{"company":{"timeZone":"timeZone"}},"legalName":{"company":{"legalName":"legalName"}},"bio":{"company":{"description":"description"}},"foundedYear":{"company":{"foundedYear":"foundedYear"}},"tags":{"company":{"tags":"tags"}},"domain":{"company":{"domain":"domain"}},"type":{"company":{"type":"type"}},"technology":{"company":{"tech":"tech"}},"stock_reports":{"company":{"ticker":"ticker"}},"parent_domain":{"company":{"parent":"domain"}}},"metrics":{"raised":{"company":{"metrics":"raised"}},"annualRevenue":{"company":{"metrics":"annualRevenue"}},"market_cap":{"company":{"metrics":"marketCap"}},"alexa_rank":{"company":{"metrics":"alexaUsRank"}},"alexa_global_rank":{"company":{"metrics":"alexaGlobalRank"}},"fiscalYearEnd":{"company":{"metrics":"fiscalYearEnd"}},"employee_range":{"company":{"metrics":"employeesRange"}},"estimatedAnnualRevenue":{"company":{"metrics":"estimatedAnnualRevenue"}}},"category":{"sector":{"company":{"category":"sector"}},"sicCode":{"company":{"category":"sicCode"}},"industry":{"company":{"category":"industry"}},"naicsCode":{"company":{"category":"naicsCode"}},"subIndustry":{"company":{"category":"subIndustry"}},"industryGroup":{"company":{"category":"industryGroup"}}},"twitter":{"id":{"company":{"twitter":"id"}},"bio":{"company":{"twitter":"bio"}},"site":{"company":{"twitter":"site"}},"avatar":{"company":{"twitter":"avatar"}},"handle":{"company":{"twitter":"handle"}},"location":{"company":{"twitter":"location"}},"followers":{"company":{"twitter":"followers"}},"following":{"company":{"twitter":"following"}}},"facebook":{"likes":{"company":{"facebook":"likes"}},"handle":{"company":{"facebook":"handle"}}},"linkedin":{"handle":{"company":{"linkedin":"handle"}}},"crunchbase_handle":{"company":{"crunchbase":"handle"}}}';
                    }

                    $result_json = json_decode($json,true);
                    foreach ($result_json as $key => $v)
                    {
                        $send = [
                            "key" => $key,
                            "res_key" => $res_key
                        ];
//                        dd($result_json[$key],$send);
                        array_walk_recursive($result_json[$key], 'self::parse_clearbit_json',$send);
                    }
                }

                $res = json_encode($final_res);
                Workbench_Result::where('workbench_id',$result->workbench_id)->update([
                    "result" => $res
                ]);
            }
//        }
    }







    /*
    *   API CURL Request Call functions below
    */

    public function rocket_reach($names,$company_name,$job_title)
    {
        $rocket_key = env('ROCKET_REACH_API_KEY', '3E7k0123456789abcdef0123456789abcdef');
        $rocket_client = new Client();
        $rocket_url = 'https://api.rocketreach.co/v1/api/lookupProfile?'.
            'api_key=' . $rocket_key .
            '&name='.urlencode($names);
        if($company_name != "") $rocket_url .= '&current_employer='.urlencode($company_name);
        if($job_title != "") $rocket_url .= '&title='.urlencode($job_title);
        if("" != "") $rocket_url .= '&twitter_handle=';
        if("" != "") $rocket_url .= '&twitter_url=';
        if("" != "") $rocket_url .= '&li_url=';
        $rocket_request = $rocket_client->get($rocket_url);
        $rocket_response = json_decode($rocket_request->getBody()->getContents());

        return ($rocket_response);

        //LookUp
        //li_url    	LinkedIn URL e.g. 'https://www.linkedin.com/in/marcbenioff
        //twitter_handle    	Twitter Handle (e.g. use 'joandoe' instead of '@joandoe')
        //twitter_url    	Twitter Handle (e.g. 'https://twitter.com/joandoe')
        //Search
        //name	Name of the person you are looking for
        //keyword	Keyword: Any keywords in a person's profile
        //title	Title: (e.g. 'VP of Marketing', 'CEO')
        //company	Company: (e.g. 'Google', 'General Electric')
        //location	Location: (e.g. 'San Francisco', 'San Francisco Bay Area')
    }

    public function block_dispossal($p_email)
    {
        $block_response = [];
        for($i=0;$i<count($p_email);$i++){
            // Block Dispossal Emails
            $block_key = env('BLOCK_DISPOSSAL_EMAIL_API_KEY', '34878a526de1cb0e5f0de6a6481204d7');
            $block_client = new Client();
            $block_request = $block_client->get('http://check.block-disposable-email.com/easyapi/json/'.$block_key.'/'.$p_email[$i]);
            $response = $block_request->getBody()->getContents();
            $bd_response[$i] = json_decode($response);
        }
        return ($bd_response);
    }

    public function hibp($p_email)
    {
        // Block Dispossal Emails
        $HIBP_key = env('HAVE_I_BEEN_PWNED_API_KEY', '34878a526de1cb0e5f0de6a6481204d7');
        $HIBP_client = new Client(['headers' => ['hibp-api-key' => $HIBP_key]]);
        // PARAMETER = Adobe
        $HIBP_request = $HIBP_client->get('https://haveibeenpwned.com/api/v3/breachedaccount/ADOBE');
        $response = $HIBP_request->getBody()->getContents();
        $hibp_response = json_decode($response);
        return ($hibp_response);
    }

    public function byteplant_phone_validate($phone_number,$country_code,$country_lang_code)
    {
        //$phone,$code,$locale
        // build API request
        $APIUrl = 'https://api.phone-validator.net/api/v2/verify';
        $CountryCode = $country_code[0];
        $PhoneNumber = $phone_number[0];
        $Params = [
            'PhoneNumber' => $PhoneNumber,
            'CountryCode' => $CountryCode,
            'Locale' => $country_lang_code,
            'APIKey' => env('PHONE_VALIDATOR_API_KEY', 'pv-906e682fb2b260c5ec772b71db168f52')
        ];
        $Request = http_build_query($Params, '', '&');
        $ctxData = array(
            'method'=>"POST",
            'header'=>"Connection: close\r\n".
                "Content-Type: application/x-www-form-urlencoded\r\n".
                "Content-Length: ".strlen($Request)."\r\n",
            'content'=>$Request);
        $ctx = stream_context_create(array('http' => $ctxData));

        // send API request
        $result = json_decode(file_get_contents($APIUrl, false, $ctx));
//        dd($result->{'status'});
        // check API result
        switch($result->{'status'}) {
            case "VALID_CONFIRMED":
                $response = 'valid';
                break;
            case "VALID_UNCONFIRMED":
                $linetype = $result->{'linetype'};
                $location = $result->{'location'};
                $countrycode = $result->{'countrycode'};
                $formatnational = $result->{'formatnational'};
                $formatinternational = $result->{'formatinternational'};
                $response =  'valid';
                break;
            case "INVALID":
                $response = 'invalid';
                break;
            default:
                $response = 'invalid';
        }
        return($response);
    }

    public function byteplant_address_validate($StreetAddress,$City,$PostalCode,$State,$CountryCode,$Locale)
    {
        // build API request
        $APIUrl = 'https://api.address-validator.net/api/verify';
        $Params = [
            'StreetAddress' => $StreetAddress,
            'City' => $City,
            'PostalCode' => $PostalCode,
            'State' => $State,
            'CountryCode' => $CountryCode,
            'Locale' => $Locale,
            'APIKey' => env('ADDRESS_VALIDATOR_API_KEY', 'av-cf6de170ac7cb129b474fd262bd2d37a')
        ];
        $Request = http_build_query($Params, '', '&');
        $ctxData = array(
            'method'=>"POST",
            'header'=>"Connection: close\r\n".
                "Content-Type: application/x-www-form-urlencoded\r\n".
                "Content-Length: ".strlen($Request)."\r\n",
            'content'=>$Request);
        $ctx = stream_context_create(array('http' => $ctxData));

        // send API request
        $result = json_decode(file_get_contents(
            $APIUrl, false, $ctx));

        // check API result
        if ($result && $result->{'status'} == 'VALID') {
            $formattedaddress = $result->{'formattedaddress'};
        } else {
            $formattedaddress = $result;
        }
    }

    public function everyoneAPI($country_code,$number)
    {
        $block_response = [];
        for($i=0;$i<count($number);$i++){
            // Block Dispossal Emails
            $phone_number = '+'.$country_code.$number[0];
            $account_SID = env('EVERYONE_API_ACCOUNT_SID', 'AC38c6e769a11d428d9ba0370c98eb8c71');
            $auth_token = env('EVERYONE_API_AUTH_TOKEN', 'AU6428612b587b4c95a0cbebbd12cbe0db');
            $client = new Client();
            $request = $client->get('https://api.everyoneapi.com/v1/phone/'.$phone_number.'?account_sid='.$account_SID.'&auth_token='.$auth_token.'&data=name,address,location,cnam,carrier,carrier_o,gender,linetype,image,line_provider,profile');
            $response = $request->getBody()->getContents();
            $block_response[$i] = json_decode($response);
        }
        dd($block_response);
        return ($block_response);
    }

    public function clearbit($workbench_id)
    {
        /*
             The supported parameters are:
                email, webhook_url, given_name(First name of person), family_name, ip_address, location, company, company_domain
                linkedin, twitter, facebook
        */
        $rules = [
            'p_email'=>'required|email',
        ];
        $v = Validator::make(Input::all(), $rules, [
            "p_email.required" => "Please enter email.",
        ]);
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }else {
            $first_name = escape(Input::get('first_name'));
            $middle_name = escape(Input::get('middle_name'));
            $last_name = escape(Input::get('last_name'));
            if ($middle_name != '') {
                $names = $first_name . ' ' . $middle_name . ' ' . $last_name;
            }
            else {
                $names = $first_name . ' ' . $last_name;
            }


            $email = Input::get('p_email');
            $company = Input::get('emp_cmp_name');
            $f_name = Input::get('first_name');
            $l_name = Input::get('last_name');
            $location = Input::get('p_city');
            $company = Input::get('employer_name');
            //$linkedin = Input::get('p_email');        The LinkedIn URL for the person.
            //$twitter = Input::get('p_email');         The Twitter handle for the person.
            //$facebook = Input::get('p_email');        The Facebook URL for the person.

            $secret_key= env('CLEARBIT_SECRET_API_KEY');
            $endpoint= 'https://person-stream.clearbit.com/v2/combined/find?';
            if(!empty($email))
            {
                $endpoint.= 'email='.$email;
            }
            if(!empty($company))
            {
                $endpoint.= '&company='.$company;
            }
            if(!empty($f_name))
            {
                $endpoint.= '&given_name='.$f_name;
            }
            if(!empty($l_name))
            {
                $endpoint.= '&family_name='.$l_name;
            }
            if(!empty($location))
            {
                $endpoint.= '&location='.$location;
            }

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $endpoint,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Basic c2tfNWIyODdiZmZmNWU0ZmUzYWMxOGJlZGUwNmU1NmYxZTU6",
                    "Cache-Control: no-cache",
                    "Connection: keep-alive",
                ),
            ));

            $response = json_decode(curl_exec($curl));
            $err = curl_error($curl);
            curl_close($curl);
            if($err != "" && $response != null)
            {
                if ($err) {
                    echo "cURL Error #:" . $err;
                    die;
                }
                else {
                    // Get match score
                    $score = $this->calc_score($response);

                    Notification::Notify(
                        (Auth::user()->user_type == 1)  ? 1 : Auth::user()->user_type,
                        $this->to_id,
                        "User: ".Auth::user()->name." (Having Role: ".Auth::user()->role->name.") "."searched person record against name: ".$names." successfully using Clearbit API",
                        '/admin-dashboard/workbench/personal',
                        Auth::user()->id,
                        ' bg-inverse-secondary text-info',
                        'mdi mdi-account-search'
                    );

                    // Save record in a Database
                    $result = new Workbench_Result();
                    $result->workbench_id = $workbench_id;
                    $result->response = json_encode($response);
                    $result->source_options_id = 14;
                    $result->score = $score;
                    $result->save();
                }
            }else{
                print_r('Error while proceeding request');
                return redirect()->back()->with('success', "Error while proceeding request.");
            }

        }
    }

    public function piplev5($workbench_id)

    {
        /*
             The supported parameters are:
                email, webhook_url, given_name(First name of person), family_name, ip_address, location, company, company_domain
                linkedin, twitter, facebook
        */
        $rules = [
            'p_email'=>'required|email',
        ];
        $v = Validator::make(Input::all(), $rules, [
            "p_email.required" => "Please enter email.",
        ]);
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }else {
            $first_name = escape(Input::get('first_name'));
            $middle_name = escape(Input::get('middle_name'));
            $last_name = escape(Input::get('last_name'));
            if ($middle_name != '') {
                $names = $first_name . ' ' . $middle_name . ' ' . $last_name;
            }
            else {
                $names = $first_name . ' ' . $last_name;
            }


            $email = Input::get('p_email');
            $phone_number = Input::get('phone_number');
            $phone = $phone_number[0];
            $f_name = Input::get('first_name');
            $l_name = Input::get('last_name');
            $location = Input::get('p_city');
            //$linkedin = Input::get('p_email');
            //$twitter = Input::get('p_email');
            //$facebook = Input::get('p_email');
            $secret_key= env('CLEARBIT_SECRET_API_KEY');
            $endpoint= 'https://person-stream.clearbit.com/v2/combined/find?';
            if(!empty($email))
            {
                $endpoint.= 'email='.$email;
            }
            if(!empty($phone))
            {
                $endpoint.= '&phone='.$phone;
            }
            if(!empty($f_name))
            {
                $endpoint.= '&given_name='.$f_name;
            }
            if(!empty($l_name))
            {
                $endpoint.= '&family_name='.$l_name;
            }
            if(!empty($location))
            {
                $endpoint.= '&location='.$location;
            }
//            dd($endpoint);

            //"https://api.pipl.com/search/?email=pags6273@cox.net&phone=+1%20%28860%29%20987-2151&first_name=John&last_name=Pagliaro&middle_name=A&country=US&state=North%20Granby&city=CT&username=sonnypagliaro&age=46&key=q7qn2sly4b5ak5e0h161ur59&minimum_probability=0.8"
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $endpoint,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Accept: */*",
//                    "Accept-Encoding: gzip, deflate",
                    "Cache-Control: no-cache",
                    "Connection: keep-alive",
//                    "Host: api.pipl.com",
//                    "Postman-Token: a810431f-7420-4dbd-8f69-87d46dd2531f,1742065f-e3d0-408d-a842-298033c6912e",
//                    "User-Agent: PostmanRuntime/7.18.0",
//                    "cache-control: no-cache"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
                die;
            } else {
                // Get match score
                $score = $this->calc_score($response);

                Notification::Notify(
                    (Auth::user()->user_type == 1)  ? 1 : Auth::user()->user_type,
                    $this->to_id,
                    "User: ".Auth::user()->name." (Having Role: ".Auth::user()->role->name.") "."searched person record against name: ".$names." successfully using Clearbit API",
                    '/admin-dashboard/workbench/personal',
                    Auth::user()->id,
                    ' bg-inverse-secondary text-info',
                    'mdi mdi-account-search'
                );

                // Save record in a Database
                $result = new Workbench_Result();
                $result->workbench_id = $workbench_id;
                $result->response = json_encode($response);
                $result->score = $score;
                $result->save();
            }
        }
    }
}