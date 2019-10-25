<?php
namespace App\TraitsFolder;
use App\PersonalResult;
use App\SourceOptionDetail;
use App\Workbench_Result;
use App\WorkbenchResultDetail;
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
//        dd($response);
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

    /*
     *

        *   Clearbit API  CURL & Response Handling Starts Here
    */
    public function clearbit($workbench_id)
    {
        global $final_res;
        /*
             The supported parameters are:
                email, webhook_url, given_name(First name of person), family_name, ip_address, location, company, company_domain
                linkedin, twitter, facebook
        */

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
                "Accept: */*",
//                    "Accept-Encoding: gzip, deflate",
                "Authorization: Basic c2tfNWIyODdiZmZmNWU0ZmUzYWMxOGJlZGUwNmU1NmYxZTU6",
                "Cache-Control: no-cache",
                "Connection: keep-alive",
                "Host: person-stream.clearbit.com",
//                    "Postman-Token: 703c392e-fbc8-40a5-b331-aad5707b4d6f,0448b996-1469-4480-a47f-6a9701fef06c",
//                    "User-Agent: PostmanRuntime/7.18.0",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
            die;
        }
        else {
            global $error;
            // Get match score
            if($response != null || $response != "")
            {
                if (array_key_exists('error', json_decode($response))) {
                    $error = true;
                    print_r('Error while proceeding request');
                    return redirect()->back()->with('warning_msg', "Error while proceeding request.");
                }
                else{
                    $error = false;
                    $score = $this->calc_score(json_decode($response, true));
                    $final_res = $this->getResults($workbench_id,$score,$response);
                    Notification::Notify(
                        (Auth::user()->user_type == 1)  ? 1 : Auth::user()->user_type,
                        $this->to_id,
                        "User: ".Auth::user()->name." (Having Role: ".Auth::user()->role->name.") "."searched person record against name: ".$names." successfully using Clearbit API",
                        '/admin-dashboard/workbench/personal/result/'.$workbench_id,
                        Auth::user()->id,
                        ' bg-inverse-secondary text-info',
                        'mdi mdi-account-search'
                    );
                }

            }
            else{
                print_r('Error while proceeding request');
                return redirect()->back()->with('warning_msg', "Error while proceeding request.");
            }
        }
    }
    //  Calculate Clearbit API result
    function parse_clearbit_json($item, $key,$arr_values)
    {
        global $result_api;
        global $final_res;
        global $i;
        $i++;
        $current_res = $arr_values['res_key'];
        $identifier = $arr_values['key'];
        $sub_array = ['phone', 'github', 'twitter', 'facebook', 'linkedin', 'gravatar', "crunchbase"];

//    echo '<br/>Iteration Number: ' . $i . ' has object <b>' . $current_res . '</b> with keyname: <b>' . $identifier . '</b> with key <b>' . $key . '</b> has <b>' . $item . '</b>';

        if (!is_array($result_api[$current_res])) {
            return false;
        }
        else {
            foreach ($result_api[$current_res] as $r_key => $r_val) {
                if ($r_key == $key) {
                    if (!is_array($r_val)) {
                        $final_res["$current_res"][$identifier][$r_key] = $r_val;
                    }
                    else if (in_array($key, $sub_array)) {
                        $final_res[$current_res][$identifier][$r_key][$item] = $r_val[$item];
                    }
                    else {
                        if ($item == "") {
                            $final_res["$current_res"][$identifier][$item] = "";
                        }
                        elseif ($item == []) {
                            $final_res["$current_res"][$identifier][$item] = [];
                        }
                        else {
                            if (array_key_exists($item, $r_val) == 1) {
                                $final_res["$current_res"][$identifier][$item] = $r_val[$item];
                            }
                            else {

                                $final_res["$current_res"][$identifier][$item] = "";
                            }
                        }
                    }


                }
            }
        }
    }

    public function getResults($workbench_id,$score,$result)
    {
        global $result_api;
        global $final_res;
//         dd($result);
//        foreach ($result as $item) {

            $result_api = json_decode($result,true);
//            $result_api = $result;
            $final_res = [];
            foreach ($result_api as $res_key => $v)
            {
                if($res_key == "person")
                {
                    $json  = '{"personal":{"name":{"person":{"name":"fullName"}},"bio":{"person":{"bio":"bio"}},"site":{"person":{"site":"site"}},"avatar":{"person":{"avatar":"avatar"}}},"email":{"email":{"person":{"email":"email"}}},"geo_location":{"latitude":{"person":{"geo":"lat"}},"longitude":{"person":{"geo":"lng"}},"state":{"person":{"geo":"state"}},"stateCode":{"person":{"geo":"stateCode"}},"city":{"person":{"geo":"city"}},"country":{"person":{"geo":"country"}},"countryCode":{"person":{"geo":"countryCode"}},"timezone":{"person":{"timeZone":"timeZone"}}},"location":{"location":{"person":{"location":"location"}}},"employment":{"name":{"person":{"employment":"name"}},"role":{"person":{"employment":"role"}},"title":{"person":{"employment":"title"}},"domain":{"person":{"employment":"domain"}},"subRole":{"person":{"employment":"subRole"}},"seniority":{"person":{"employment":"seniority"}}},"social_profile":{"github":{"id":{"person":{"github":"id"}},"blog":{"person":{"github":"blog"}},"avatar":{"person":{"github":"avatar"}},"handle":{"person":{"github":"handle"}},"company":{"person":{"github":"company"}},"followers":{"person":{"github":"followers"}},"following":{"person":{"github":"following"}}},"twitter":{"id":{"person":{"twitter":"id"}},"bio":{"person":{"twitter":"bio"}},"site":{"person":{"twitter":"site"}},"avatar":{"person":{"twitter":"avatar"}},"handle":{"person":{"twitter":"handle"}},"statuses":{"person":{"twitter":"statuses"}},"favorites":{"person":{"twitter":"favorites"}},"followers":{"person":{"twitter":"followers"}},"following":{"person":{"twitter":"following"}}},"facebook":{"handle":{"person":{"facebook":"handle"}}},"gravatar":{"urls":{"person":{"gravatar":"urls"}},"avatar":{"person":{"gravatar":"avatar"}},"handle":{"person":{"gravatar":"handle"}},"avatars":{"person":{"gravatar":"avatars"}}},"linkedin":{"person":{"linkedin":"handle"}}}}';
                }
                elseif ($res_key == "company")
                {
                    $json  = '{"geo_location":{"latitude":{"company":{"geo":"lat"}},"longitude":{"company":{"geo":"lng"}},"suitNumber":{"company":{"geo":"subPremise"}},"streetNumber":{"company":{"geo":"streetNumber"}},"streetName":{"company":{"geo":"streetName"}},"state":{"company":{"geo":"state"}},"stateCode":{"company":{"geo":"stateCode"}},"city":{"company":{"geo":"city"}},"country":{"company":{"geo":"country"}},"countryCode":{"company":{"geo":"countryCode"}},"timeZone":{"company":{"timeZone":"timeZone"}}},"email":{"company":{"site":"emailAddresses"}},"phone":{"phone_number":{"company":{"site":"phoneNumbers"}},"phone":{"company":{"phone":"phone"}}},"location":{"company":{"location":"location"}},"business":{"name":{"company":{"name":"name"}},"logo":{"company":{"logo":"logo"}},"tags":{"company":{"tags":"tags"}},"type":{"company":{"type":"type"}},"domain":{"company":{"domain":"domain"}},"legalName":{"company":{"legalName":"legalName"}},"foundedYear":{"company":{"foundedYear":"foundedYear"}},"description":{"company":{"description":"description"}},"parent_domain":{"company":{"parent":"domain"}}},"stock_reports":{"company":{"ticker":"ticker"}},"technology":{"company":{"tech":"tech"}},"metrics":{"raised":{"company":{"metrics":"raised"}},"annualRevenue":{"company":{"metrics":"annualRevenue"}},"market_cap":{"company":{"metrics":"marketCap"}},"alexa_rank":{"company":{"metrics":"alexaUsRank"}},"alexa_global_rank":{"company":{"metrics":"alexaGlobalRank"}},"fiscalYearEnd":{"company":{"metrics":"fiscalYearEnd"}},"employee_range":{"company":{"metrics":"employeesRange"}},"estimatedAnnualRevenue":{"company":{"metrics":"estimatedAnnualRevenue"}}},"category":{"sector":{"company":{"category":"sector"}},"sicCode":{"company":{"category":"sicCode"}},"industry":{"company":{"category":"industry"}},"naicsCode":{"company":{"category":"naicsCode"}},"subIndustry":{"company":{"category":"subIndustry"}},"industryGroup":{"company":{"category":"industryGroup"}}},"social":{"twitter":{"id":{"company":{"twitter":"id"}},"bio":{"company":{"twitter":"bio"}},"site":{"company":{"twitter":"site"}},"avatar":{"company":{"twitter":"avatar"}},"handle":{"company":{"twitter":"handle"}},"location":{"company":{"twitter":"location"}},"followers":{"company":{"twitter":"followers"}},"following":{"company":{"twitter":"following"}}},"facebook":{"likes":{"company":{"facebook":"likes"}},"handle":{"company":{"facebook":"handle"}}},"linkedin":{"handle":{"company":{"linkedin":"handle"}}},"crunchbase_handle":{"company":{"crunchbase":"handle"}}}}';
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
//            return $final_res;
//        dump($result);
//        dump($final_res);
//        dd(json_encode($final_res));
        // Save record in a Database

        $result = Workbench_Result::create([
            'workbench_id' => $workbench_id,
            'response' => $result,
            'result' => json_encode($final_res),
            'source_options_id' => 14,
            'score' => $score,
            'workbench_id' => $workbench_id,
            "type" => 0,
        ]);

//        $final_res
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
//        Final Result Manipulation
        $res_det = [];
        //  Name
        $res_det['name'] = [];
        if (array_key_exists('person', $final_res))
        {
            array_push($res_det['name'], $final_res['person']['personal']['fullName']);
        }
        $res_det['name'] = array_unique($res_det['name']);
        //  Email
        $res_det['email'] = [];
        if (array_key_exists('person', $final_res))
        {
            if($final_res['person']['email']['email'] != null) {
                array_push($res_det['email'], $final_res['person']['email']['email']);
            }
        }
        if(array_key_exists('company', $final_res))
        {
            foreach($final_res['company']['email']['emailAddresses'] as $em)
            {
                if($em != null)
                {
                    array_push($res_det['email'], $em);
                }
            }
        }
        $res_det['email'] = array_unique($res_det['email']);
        //Avatar
        $res_det['avatar'] = [];
        if (array_key_exists('person', $final_res))
        {
            array_push($res_det['avatar'], $final_res['person']['personal']['avatar']);
        }
        //Bio
        $res_det['bio'] = [];
        if (array_key_exists('person', $final_res))
        {
            array_push($res_det['bio'], $final_res['person']['personal']['bio']);
        }
        //site
        $res_det['site'] = [];
        if (array_key_exists('person', $final_res))
        {
            array_push($res_det['site'], $final_res['person']['personal']['site']);
        }
        //location
        $res_det['location'] = [];
        if (array_key_exists('person', $final_res))
        {
            if($final_res['person']['location']['location'] != null) {
                array_push($res_det['location'], $final_res['person']['location']['location']);
            }
        }
        if (array_key_exists('company', $final_res))
        {
            if($final_res['company']['location']['location'] != null)
            {
                array_push($res_det['location'], $final_res['company']['location']['location']);
            }
        }
        $res_det['location'] = array_unique($res_det['location']);
        //longitude
        $res_det['longitude'] = [];
        if (array_key_exists('person', $final_res))
        {
            if($final_res['person']['geo_location']['lng'] != null) {
                array_push($res_det['longitude'], $final_res['person']['geo_location']['lng']);
            }
        }
        if (array_key_exists('company', $final_res))
        {
            if($final_res['company']['geo_location']['lng'] != null) {
                array_push($res_det['longitude'], $final_res['company']['geo_location']['lng']);
            }
        }
        $res_det['longitude'] = array_unique($res_det['longitude']);
        //latitude
        $res_det['latitude'] = [];
        if (array_key_exists('person', $final_res))
        {
            if($final_res['person']['geo_location']['lat'] != null) {
                array_push($res_det['latitude'], $final_res['person']['geo_location']['lat']);
            }
        }
        if (array_key_exists('company', $final_res))
        {
            if($final_res['company']['geo_location']['lat'] != null) {
                array_push($res_det['latitude'], $final_res['company']['geo_location']['lat']);
            }
        }
        $res_det['latitude'] = array_unique($res_det['latitude']);
        //city
        $res_det['city'] = [];
        if (array_key_exists('person', $final_res))
        {
            if($final_res['person']['geo_location']['city'] != null) {
                array_push($res_det['city'], $final_res['person']['geo_location']['city']);
            }
        }
        if (array_key_exists('company', $final_res))
        {
            if($final_res['company']['geo_location']['city'] != null) {
                array_push($res_det['city'], $final_res['company']['geo_location']['city']);
            }
        }
        $res_det['city'] = array_unique($res_det['city']);
        //state
        $res_det['state'] = [];
        if (array_key_exists('person', $final_res))
        {
            if($final_res['person']['geo_location']['state'] != null) {
                array_push($res_det['state'], $final_res['person']['geo_location']['state']);
            }
        }
        if (array_key_exists('company', $final_res))
        {
            if($final_res['company']['geo_location']['state'] != null) {
                array_push($res_det['state'],$final_res['company']['geo_location']['state']);
            }
        }
        $res_det['state'] = array_unique($res_det['state']);
        //country
        $res_det['country'] = [];
        if (array_key_exists('person', $final_res))
        {
            if($final_res['person']['geo_location']['country'] != null) {
                array_push($res_det['country'],$final_res['person']['geo_location']['country']);
            }
        }
        if (array_key_exists('company', $final_res))
        {
            if($final_res['company']['geo_location']['country'] != null) {
                array_push($res_det['country'],$final_res['company']['geo_location']['country']);
            }
        }
        $res_det['country'] = array_unique($res_det['country']);
        //timezone
        $res_det['timezone'] = [];
        if (array_key_exists('person', $final_res))
        {
            if($final_res['person']['geo_location']['timeZone'] != null) {
                array_push($res_det['timezone'],$final_res['person']['geo_location']['timeZone']);
            }
        }
        if (array_key_exists('company', $final_res))
        {
            if($final_res['company']['geo_location']['timeZone'] != null) {
                array_push($res_det['timezone'],$final_res['company']['geo_location']['timeZone']);
            }
        }
        $res_det['timezone'] = array_unique($res_det['timezone']);
        //career
        $res_det['career'] = [
            'name' => [],
            'logo' => [],
            'title' => [],
            'domain' => [],
            'role' => [],
            'description' => [],
            'foundedYear' => [],
            'type' => [],
        ];
        if (array_key_exists('person', $final_res))
        {
            if (array_key_exists('employment', $final_res['person'])) {
                array_push($res_det['career']['name'],$final_res['person']['employment']['name']);
                array_push($res_det['career']['title'],$final_res['person']['employment']['title']);
                if($final_res['person']['employment']['domain'] != null) {
                    array_push($res_det['career']['domain'], $final_res['person']['employment']['domain']);
                }
                array_push($res_det['career']['role'],$final_res['person']['employment']['role']);
            }
        }
        if (array_key_exists('company', $final_res))
        {
            if (array_key_exists('business', $final_res['company'])) {
                if($final_res['company']['business']['name'] != null) {
                    array_push($res_det['career']['name'], $final_res['company']['business']['name']);
                }
                array_push($res_det['career']['logo'],$final_res['company']['business']['logo']);
                if($final_res['company']['business']['domain'] != null) {
                    array_push($res_det['career']['domain'], $final_res['company']['business']['domain']);
                }
                array_push($res_det['career']['type'],$final_res['company']['business']['type']);
                array_push($res_det['career']['description'],$final_res['company']['business']['description']);
                array_push($res_det['career']['foundedYear'],$final_res['company']['business']['foundedYear']);
            }
        }
        $res_det['career'] = array_unique_recursive($res_det['career']);

        //social
        $res_det['social'] = [
            'github' => [
                "company" => [],
                "handle" => [],
                "follower" => [],
                "following" => []
            ],
            'twitter' => [
                "bio" => [],
                "handle" => [],
                "site" => [],
                "follower" => [],
                "following" => []
            ],
            'facebook' => [
                "likes" => [],
                "handle" => []
            ],
            'linkedin' => [
                "handle" => []
            ],
            'crunchbase' => [
                "handle" => []
            ]
        ];
        if (array_key_exists('person', $final_res))
        {
            if (array_key_exists('social_profile', $final_res['person'])) {
                //  Github
                if($final_res['person']['social_profile']['github']['company'] != null)
                {
                    array_push($res_det['social']['github']['company'],$final_res['person']['social_profile']['github']['company']);
                }
                if($final_res['person']['social_profile']['github']['handle'] != null) {
                    array_push($res_det['social']['github']['handle'], $final_res['person']['social_profile']['github']['handle']);
                }
                if($final_res['person']['social_profile']['github']['followers'] != null) {
                    array_push($res_det['social']['github']['follower'], $final_res['person']['social_profile']['github']['followers']);
                }
                if($final_res['person']['social_profile']['github']['following'] != null) {
                    array_push($res_det['social']['github']['following'],$final_res['person']['social_profile']['github']['following']);
                }
                //  Twitter
                if($final_res['person']['social_profile']['twitter']['bio'] != null) {
                    array_push($res_det['social']['twitter']['bio'], $final_res['person']['social_profile']['twitter']['bio']);
                }
                if($final_res['person']['social_profile']['twitter']['handle'] != null) {
                    array_push($res_det['social']['twitter']['handle'], $final_res['person']['social_profile']['twitter']['handle']);
                }
                if($final_res['person']['social_profile']['twitter']['site'] != null) {
                    array_push($res_det['social']['twitter']['site'], $final_res['person']['social_profile']['twitter']['site']);
                }
                if($final_res['person']['social_profile']['twitter']['followers'] != null) {
                    array_push($res_det['social']['twitter']['follower'], $final_res['person']['social_profile']['twitter']['followers']);
                }
                if($final_res['person']['social_profile']['twitter']['following'] != null) {
                    array_push($res_det['social']['twitter']['following'], $final_res['person']['social_profile']['twitter']['following']);
                }
                //  Facebook
                if($final_res['person']['social_profile']['facebook']['handle'] != null) {
                    array_push($res_det['social']['facebook']['handle'], $final_res['person']['social_profile']['facebook']['handle']);
                }
                // Linkedin
                if($final_res['person']['social_profile']['facebook']['handle'] != null) {
                    array_push($res_det['social']['linkedin']['handle'], $final_res['person']['social_profile']['linkedin']['handle']);
                }
            }
        }
        if (array_key_exists('company', $final_res))
        {
            if (array_key_exists('social', $final_res['company'])) {
                //  Twitter
                if($final_res['company']['social']['twitter']['bio'] != null) {
                    array_push($res_det['social']['twitter']['bio'], $final_res['company']['social']['twitter']['bio']);
                }
                if($final_res['company']['social']['twitter']['handle'] != null) {
                    array_push($res_det['social']['twitter']['handle'], $final_res['company']['social']['twitter']['handle']);
                }
                if($final_res['company']['social']['twitter']['site'] != null) {
                    array_push($res_det['social']['twitter']['site'], $final_res['company']['social']['twitter']['site']);
                }
                if($final_res['company']['social']['twitter']['followers'] != null) {
                    array_push($res_det['social']['twitter']['follower'], $final_res['company']['social']['twitter']['followers']);
                }
                if($final_res['company']['social']['twitter']['following'] != null) {
                    array_push($res_det['social']['twitter']['following'], $final_res['company']['social']['twitter']['following']);
                }
                //  Facebook
                if($final_res['company']['social']['facebook']['likes'] != null) {
                    array_push($res_det['social']['facebook']['likes'], $final_res['company']['social']['facebook']['likes']);
                }
                if($final_res['company']['social']['facebook']['handle'] != null) {
                    array_push($res_det['social']['facebook']['handle'], $final_res['company']['social']['facebook']['handle']);
                }
                // Linkedin
                if($final_res['company']['social']['linkedin']['handle'] != null) {
                    array_push($res_det['social']['linkedin']['handle'], $final_res['company']['social']['linkedin']['handle']);
                }
                // Crunchbase
                if($final_res['company']['social']['crunchbase']['handle'] != null) {
                    array_push($res_det['social']['crunchbase']['handle'],$final_res['company']['social']['crunchbase']['handle']);
                }

            }
        }
        $res_det['social'] = array_unique_recursive($res_det['social']);

//        dd($res_det);

        $result_save = new PersonalResult();
        $result_save->workbench__results_id = $result->id;
        $result_save->name = ($res_det['name'] == []) ? NULL : json_encode($res_det['name']);
        $result_save->email = ($res_det['email'] == []) ? NULL : json_encode($res_det['email']);
        $result_save->age = NULL;
        $result_save->gender = NULL;
        $result_save->language = NULL;
        $result_save->dob = NULL;
        $result_save->avatar = ($res_det['avatar'] == []) ? NULL : json_encode($res_det['avatar']);
        $result_save->bio = ($res_det['bio'] == []) ? NULL : json_encode($res_det['bio']);
        $result_save->site = ($res_det['site'] == []) ? NULL : json_encode($res_det['site']);
        $result_save->phone_number = NULL;
        $result_save->images = NULL;
        $result_save->urls = NULL;
        $result_save->ethnicity = NULL;
        $result_save->origin_country = NULL;
        $result_save->relations = NULL;
        $result_save->location = ($res_det['location'] == []) ? NULL : json_encode($res_det['location']);
        $result_save->longitude = ($res_det['longitude'] == []) ? NULL : json_encode($res_det['longitude']);
        $result_save->latitude = ($res_det['latitude'] == []) ? NULL : json_encode($res_det['latitude']);
        $result_save->state = ($res_det['state'] == []) ? NULL : json_encode($res_det['state']);
        $result_save->city = ($res_det['city'] == []) ? NULL : json_encode($res_det['city']);
        $result_save->country = ($res_det['country'] == []) ? NULL : json_encode($res_det['country']);
        $result_save->zip_code = NULL;
        $result_save->timezone = ($res_det['timezone'] == []) ? NULL : json_encode($res_det['timezone']);
        $result_save->career = ($res_det['career'] == []) ? NULL : json_encode($res_det['career']);
        $result_save->education = NULL;
        $result_save->social = ($res_det['social'] == []) ? NULL : json_encode($res_det['social']);
        $result_save->save();
    }


    /*
        *   Clearbit API  CURL & Response Handling Ends Here
    */



    /*
        *   Piple API  CURL & Response Handling Ends Here
    */

    /*
    public function piple($workbench_id)
    {
        global $final_res;
        global $error;
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
                $phone_number = implode(', ',Input::get('phone_number'));
                $f_name = Input::get('first_name');
                $m_name = Input::get('middle_name');
                $l_name = Input::get('last_name');
                $age = Input::get('age');
                $city = Input::get('p_city');
                $state = Input::get('p_state');
                $username = Input::get('username');
                //$linkedin = Input::get('p_email');        The LinkedIn URL for the person.
                //$twitter = Input::get('p_email');         The Twitter handle for the person.
                //$facebook = Input::get('p_email');        The Facebook URL for the person.

                $secret_key= env('PIPLE_BUSINESS_KEY');
                $endpoint= 'https://api.pipl.com/search/?';
                $endpoint.= 'country=US&minimum_probability=0.85';
                if(!empty($email))
                {
                    $endpoint.= 'email='.$email;
                }
                if(!empty($phone_number))
                {
                    $endpoint.= '&phone='.$phone_number;
                }
                if(!empty($f_name))
                {
                    $endpoint.= '&first_name='.$f_name;
                }
                if(!empty($m_name))
                {
                    $endpoint.= '&middle_name='.$m_name;
                }
                if(!empty($l_name))
                {
                    $endpoint.= '&family_name='.$l_name;
                }
                if(!empty($age))
                {
                    $endpoint.= '&age='.$age;
                }
                if(!empty($city))
                {
                    $endpoint.= '&city='.$city;
                }
                if(!empty($state))
                {
                    $endpoint.= '&state='.$state;
                }
                if(!empty($username))
                {
                    $endpoint.= '&username='.$username;
                }
                $endpoint.='&key='.$secret_key;

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
                        "cache-control: no-cache"
                    ),
                ));
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                    // Get match score
                    $decoded_response = json_decode($response);
                    if(is_array($decoded_response))
                    {
                        if($decoded_response != null || $decoded_response != "")
                        {
                            if (array_key_exists('error', $decoded_response)) {
                                $error = true;
                                return redirect()->back()->with('warning_msg', "Error while proceeding request.");
                            }elseif (array_key_exists('possible_persons', json_decode($response))) {
                                $error = true;
                                return redirect()->back()->with('warning_msg', "Show Multiple Profile Result is in progress.");
                            }
                            else{
                                $error = false;
                                $score = $this->calc_score(json_decode($response, true));
                                $final_res = $this->getPipleResults($workbench_id,$score,$response);
                                //                    dd($final_res);
                                Notification::Notify(
                                    (Auth::user()->user_type == 1)  ? 1 : Auth::user()->user_type,
                                    $this->to_id,
                                    "User: ".Auth::user()->name." (Having Role: ".Auth::user()->role->name.") "."searched person record against name: ".$names." successfully using Clearbit API",
                                    '/admin-dashboard/workbench/personal/result/'.$workbench_id,
                                    Auth::user()->id,
                                    ' bg-inverse-secondary text-info',
                                    'mdi mdi-account-search'
                                );
                            }
                        }
                        else{
                            $error = true;
                            return redirect()->back()->with('warning_msg', "Error while proceeding request.");
                        }
                    }
                    else{
                        $error = true;
                        return redirect()->back()->with('warning_msg', strip_tags($decoded_response));
                    }
            }
    */


    public function piple($workbench_id)
    {
        global $final_res;
        global $error;
        $response = '{
    "@http_status_code": 200,
    "@visible_sources": 45,
    "@available_sources": 183,
    "@persons_count": 1,
    "@search_id": "1910241758091794811399602564384551795",
    "warnings": [
        "Provided state `MAMMOTH` is not a valid state in country US. It is ignored.",
        "City `CA` provided without a valid state. This may lead to wrong searches.",
        "City `CA` does not exist in provided country US. It is ignored."
    ],
    "query": {
        "names": [
            {
                "first": "Kent",
                "last": "Rianda",
                "display": "Kent Rianda"
            }
        ],
        "emails": [
            {
                "address": "kent@thetroutfitter.com",
                "address_md5": "18e92321e2898b159a03e7fc3fb2418f"
            }
        ],
        "addresses": [
            {
                "country": "US",
                "display": "United States"
            }
        ]
    },
    "available_data": {
        "premium": {
            "relationships": 4,
            "jobs": 4,
            "addresses": 10,
            "phones": 8,
            "mobile_phones": 1,
            "landline_phones": 7,
            "educations": 1,
            "languages": 1,
            "user_ids": 6,
            "social_profiles": 2,
            "names": 1,
            "dobs": 1,
            "images": 2,
            "genders": 1,
            "emails": 5,
            "origin_countries": 1
        }
    },
    "person": {
        "@id": "31a087de-79a4-4e80-8235-779585401cac",
        "@match": 1.0,
        "@search_pointer": "342a12efb05a46ea6c7fcde63eaa9516a65198bcc352841a4e561eb3c75c7bb1ffe3a849e198083d41fecd8234e027fc797d7b206ab26b9f519376bad2a886d066ecb8669e2d787f4fd3ddb9b26b9d4456938685bebf09c417a9efcdba6aa5c42639fcb6187548cbf37b11fe4bef6c5f1aca3e5b284837a36b586202b266e53800d2a215c875efb0f96ee0c7e28c3c6db6beab20a3d5619a464a6aecceef39da99d7350c254f69ec8f46e514b1c3788b37d515ead35fd04c78d9d346a4b8658269fdb79416ce040f483b129f521893d0618ada047aa8f425c004dd6c70611a883f3bc12aefdb73f94ce4c008e395fb09d0a86a392da8acda3f0e6a4cb076edb4d0c53d2e6d7f6be4db354b0c96b8c15219e6ff5a1e230d81cc67d750653357463d60598ee285c3e4538f580942f240b7f43e9652669b17d690fd0dc8e2a2166a31c12c10cbe40ac81097bed1f66b7fc01ffd09eb48e22713830afd3428ef71e1fc443cc4a10ec356d02ec805af5123594e2c0c1288019db8d37579fcd7c6289e4a5b30af0e8df95020c863c730a8d43c5ba463a40a79e1ccbb27ca92bf9279408416674569ea754825d28074c170775b467df491472243a86197463beec809755e3c25e7b61f16f882d4f45de2086ecffafff9a5cb1ea144bc08576d54cf9a271fc539e400dd4eeadabb8dbc718164d6bca66988a3ff66dc3c84abf0737b7329fb6fab7dc1ffa87f8fad1f3011ca8d8f2e8d604d67ede85b32890b1848b9391144ff327d5abb132c2f8c725de8346c03da38e08d7a57a51ce7534a2979c2af2142753b0aa636eb787c6f7d32e87090e63d5eabbd629ed191fdbad8bd0962cd1a131d5de5035dfc2176a7e10eb482af6be9c16f27c7316c14555b8140f691e430aa31f7e9540012501fac4b1914e665a0898e66465a57b97d2bf4c706c1b7367b7911fc15d86e468afcacc36132f2712d54b7f8fb573d91bcc6d0c312071819d06f4a0e31c144e0ce3abaac9a1a36c32ac2ed60be3d026d1aff9d15f2541a3630a2c8de761a56e56c7babd722b2456ad179b723bff84b1acd8aff8a5ea470ccc617085aaed5a1722374aeaab79043c1f66317ab1af1c6aefa48b0f003d167706e7a47de7db85494d3543d05be4878b42413204ccd91ae9946ef157e0fab2dd602403849d701eae8b4aa78d8420d0edf56c66bf5eade753d58e42b3d52b2895618779dbf38d9de18166a055e3218eefd30e5788bc31cc0df1669b6a8339de6537f21ce13b2a46264eaf25d928f3a56fce36800b2e6bc51169872c2e896a608ea8cb251b9021f4c54dff75e8c29183e1f5c67797cfbb1c84829f44c82d9762662d43da7d3bab1d1deacdf7b2c824335000f7f4b1fc8663427488e38fe79ca1a3e9639591ed7901929b5e1937bbc7cfe13ce48a18c80d661f682ecda02952d7fb0c496b9d4b81f37876bba01673650bb8f95db4b5a889b9f4f4bf05ed51e65f3464386ec8eeca414a75e6e600559786a11fe179bce50155a72a2f38333e192c90043b68d1c9fe2c77a988e8deedf956f8e4ff0730960297a154baa644265f9207f386d1605542ad56abdb1ccbee70596221384bdc6b15f4ec472e2929a57219a8d411c34c3d979349682a940230c08e461408a7ef9518cd6280b5476e171222e4fdd62f461c2b4e01d1f67dee5913ab864aea11d5c0c814e99abc324019cdb920bca7208a02fcf2b061baa71268ea2dda543841a25000443ce97337ba9c5fdbbbdf6a86af78161512bc787297618a2e939eaaa509692c40c02db6ef88f2a2566d546933b37fcb3ab9c9c2654442387c2c44bbd800b802fb29a65efdd3a985c9b6d767ce3ffb4ac22a76175c0b8371327a66beeebe0a37e48c146aa1d8b4435e2e9ca487f37ae262f04b865615b7bf9c6b16be079d4c30befcf7f2e72e05d6e6d9b0461e964a9645778f951638c7ccb30358302b129cf93344f2542ce768261c9620767cb678f87a1e470d671f4882f37aaa5fd711a4269b07b1d05f01e13c0741c7f282e3ed3354f325b7920eebde4d2be7883c658c7172004585b5a5afd28866a2e149fe8523100fd32854f50558a4aab751f157295ad42f433cbf84b3f39b59fb738cb2e5f88f8533c12011e89a8fd79c7267e250d46090f9d0b61252a27e9f4616922b06464639b3c082549bf97fe90eb832ba266698c43372bba183149f2becbd0ef6b9bfbc1bdf707020792acb88f4b3e6be18c9b828df02c93daa6c2681abec42c41a080eaa4dcc65bf9b2d2fda7b7bd48d406b51874a7b72b521b20ed4fbd89e8c860a9abbf95cba66f5b7ad087dcce2f733c36fd040737da868e5fa79c59b82a817f90d9a07dfaf5321a5f483d1c8521dd1018897e0cb9de7d3dc5095e6e5edf5810d3fb8d91faee6fb52c9ca8747e8bb1150e09ca6e848b6b915d8f45fafb32eb60c6ac28d2691824461f521270f9f8579e617d34c40368d895a3e65a1a09d718e4c83ec2e380eae63a7c8ccf6ff0b9bf2efc17d803147f875e9259ba86c601c19239410d2c6654ec8c8d909dc91e44c721105a941548e6e94f0f4f16521b56d359696812cb8a9f7225b71fff9c50436ffb4e37cb9d04b4023161b36a3c4e76765a8eb6c409c507387f4d2aa540db47c49ee23addc95862609c5e14f107f6be202062125c42f40f61b02704d1308297c2141e1d6231bd9b7c343ca86b1b686b1a4d42cb1fe7bf099894410402693a9e94dd4f38579adc33c9c31a71e38501e4dec15a8402848a8ce5231d85181e0bc03c8b29d18d4f7b44598689eb523b4bb27a4a74e5d7b1d3b6cf1fff247460336f66f08f509199aaf4de4486cb64d8e02daef137f8bc1f12449ffde4c8480523bf96a2cb970be5ef32bdb40efa5c629c0ac5dc140185a900b46c094687f2c3964127a61a64e69ce6dcd1d808d59f146e3201aa3b43cec9377203e70a127558f204599632071de2068c69b25c4a9425abe586d670d8e455f73f650887ef45070f561b1d09339acd8e96b3c0dc42b79410597761c8081f030ae44004fe99674197b4650486176eb4536a5f48d4dcd0dbb90620c34319865c3b0938cdc364beb7fc14aca1e98976a0f55391cc5b88980bd2651bf32ef790eeeee348e0795b849d69776e016902d959253ca600abdc378174fa34e64a5e5507c5407f0b3833216418540f67c09c01f4de580b307da993c60ad484e859cbed35d83c3621033373db10db9b08ca9ed985cfafe7c55cfcf82848c3cb69da7e993a8e91c04ab00d25cd0b77885980b12cf7ca2417b6221660cef40cf583742ca2d6a87f2362dc849c2b1dca8fdae89631a39b6e0c429d68d85846ddb6437ccabdddfbff699ea3837d8db58c9aa48cff45bcfc9b4596e1779c1eba9c134a93ab6d971489b162632d2df442fbf18bb47342c896404cd618e715873178848bdd1146cde923864819bd02161a42d2e72027385f862830817373a347a43d88c6da92437fa66339cd4f7bc94a8239c618db4fe971b1cb7ade5920945a3e66f29ef662df5c398def6efe073d3df9459069d2662af9cae8f0d1d012e1732a09717ba100e0c8e77b4781b97a505a19b833fa4f969407bf55d4b1cc7abd1f985e183e739d873aa54afd6e76f3b0d9f3135348a2c1c82fad632b7c209f03314d1b20d9c8d14c8c3aceb508ae510dbf0b5c6a31f611e8e43d05ef088090ca6149149c1047ed9fa893b424e92746a89837ba332279070ecee7926e23424fd58610b942ef9a99db44e91bb8c18f2d29e9037c1bff3e39560582c9f2a0a2a77dc7a786d57ff1e329b1aa244f07248fd22d0a737dd08173e3bb86b70d53a76168a355338eeb93b4fdd98e5953c5cb696669f52cd7070435406bea2bffeafeace91e6c3e494d813fae9f6b503f00987b194203b89edd7e1aa7e6d45d81de0a6b64cd1b58c0cf55edb5a2c1851297fb0a0b819c3381e80aeffdf0cbc63a99eca69d34e4b0caf1cf9862853af99c535a7779328c3db09a00d5cf3281e1cb916a94edf8015ca64f7143ef02be0a4496ea4fecb386f0110997d5668a88efb5a4fb644d622051801dc8862fb07a9a31d20edc06b980c196e0cbe7c2faf5a9b832fc29adf0c9b147c710eeaff800dc799ff896c970c367060cf7e5bae0950d631ce1fef38906eef2921b3d3d7e8a88dffceb7a5354d58bb371b69c1fca4d532875e14789c3096610f54d30a473ec9ca33b61f9dfae667b1c6255771e63e967f20984ee362b8d9cc772b6d61e5d47b75ea0f4edcb203669a887267b4d1f57e5fcb8abdab2726236f01e675ecf9c0814953b4451bb79b1d4417773e2193784dd8e6fdb139c95b436ebb011444b7f206009855131d1a45c07e25897fded88352beb1c176fd2db87f80a45d82752ada977adc5edbc867a4c6cf93472b56bfbc5fb9915bf3dfe3a50e147c099f56beec99adce7f872e6f60696de9b5eee9f9b8225a8390d286958fa77239545eefd1a0c149580255474f683aee2e744a7029c15a26ec792909981bf1cf060ba364f5b7eb9d65b5bf2da8cf20a46cde522f10d7a08363f32b183d24ee1783646ffe3e9c4a4f338856523bc384a90b88bc25dfddbb06aff9633340d1fcae0cec72973e81f72072afd7e5416fdac434bb06243a3fd79379c80501355e24526750afdd9e266119dca6c3eeda94279b4f2415991bfb2f5ccd436d1e4faf357a223cceca8395549b93dc5701a356e623fcbc415d94c07417c8d0ce5d2944e025cbe296c5c419f1cc412bc423ec681e79a3bcb2d215b97e4f8851218d530314917674e564214f49165191f6c36322b4ef9393f0aed163d3d02c7bd0aacad559ba8018d22d33b7b41e8e6442b3573d350561c7890b02c41d380c72343035e147120894d434687ffe7885613aacc6c264d93b7412c9bd27cb844de7e85e26c3bd6e22f0a6c5bdb428263a6b471b2aa28953f5a0a3ec303411e72afe2e96df33717188644019371946fe0a7fbd7100b62508d9088a7f212bac53dc09594292f755a02a228ad15cb808f820fad92ea6519aee3f44f154e10b0adee4f09527c5fcecc1b5cba69cad59bbcd77dcf350beba74e7d044a22a184f74729c6b628ee630f26e6dc2d73bab2f2d7ed537231f03eff8b8cf519379047ab3fd9fcab7dfbac1cbd5a4f35bce9bb27301c7bb587058dfb9151004a28cb47124ef334a78673a112ea6bb71c7fb8372c916a264fdb542da60c0fa14f1d8e052f33576ae71532cd8889ef41aa3204f7046fce83764dddca6d90259a3a0c21b42fb8285667f69e209a4ff1f826678ce48e4057e8702cc8108e7c59a23613edaa74518d35f9ff8e8932e3bc2b6f8461fb6870fe0109052eb179be2c6f6c63ce36c8c72cd5805945e50ed702fe13359ff062a4c7995dbd42118f4b1393f71882c8954e27c707f19d10344047fe6c45027e0819eccd2c23f049f9f1350905f0dbb52211daef046ba9af6eb7fb32990bf7c87967a32b3cd34df08a3d56556ac0fc6dda5cda28727d266ae76281ae5f387f7027aec637fb05ea1a1e06c54af6516e13348db597771095274d90b2cd71bc254423547e9010a8703fc002380add13ffcb5662d00e9dc296d123a69e8a6948477fc0a7a7d390be48eb6b5bb328393126435a432856bf2d04f4f62edb465b015df1f040c4be118bfd988c627b19cde4513c7ff783073dedea70d10abcf9a9854c9e4292bac2b28801c04531557e86c06dce37d6be5d41de45d61b3bb58a00519b43322c1c65df6758564bd5c02691fd2422a0663c2e90aa357b1f971ce098f8b5a39f4a7504e91ea010720ee6857809b5caf299a890c2452fbbd4c352433c9cdf7f80d09934d930683df6fe890dc39fdafc875b1364329e28967b8560b7bee03eeb65cc8b6978906b3865fbdee44927e28761a00226b125508ddc386b52675b38aa41212fe7c1cced63381500ef784a2b640c338d7d946b0d66165605920fcd9a017a1d8d93ca02d5cb077809db87efe89ce97543790bb142730a15358e987639e95fdf0419dc9f814e7c05da76eb843d469dea574662dcf2cdfc066796ce650c9962c44712e350c42f3f4c32d7e68473bc7eabbe78537da779e25fea05ad929e14550901d3cf609e28c58bb382926952418198ceb61fb6b820592dad3d7eb83bc56f03e2f633dd9be0c46807011323fd01d5c442374a60bd6d7177672c588c86a816109acea253c9cbd4e922af27d3e31d1c055ea800524d3210bef4f3f92362aa94bec3cb568fc0bbd96393641ed71bf7af4098662856beb7e872406c6db8ba80a160cb062f1d4d7ef093ddd76e05b7ea854148f76521acf51dad5e92b7ff64294022f2eea7eed3a53db3186fb823fcc4136c8629f57563b704436e5abe6c19eb1a716a2f1d4bb6adb2a5ca378b2de62363720f02120f4ee85c8867635e284687342574ed95e129842683ceb60a37f145e4733d8594adb406c5452dfdc887f47cdad7826394c9a65f066101f2d6fcd36b31b419b505344587da52d7c95112b3fb2053faa8cd8dc54277f280456e8933fcf83897eb623ab2f8be2bfc1baf41a02f0d95700b92db2a7af77bfc2c64bd892270f31082d61e48f301c587cf867e39305cbcb08216aed56b586fdbb4299a4e97d77e3c495095c7ebe66800b9aad58078295eea7a3335cd0bcc38beb5b306e19672a0d3ebd1c2f07305e265bfbf5eefb27027499b73d31d173895d1d2ff8040bff925ccc0eb96a4621c7ac5e1084d4103795fa6197f72071c9afd84de551ca183eb41b120d58483e3329f699316b268a4d14b967f7444e2436cffa65a822d629e4429b3ed1d56c26113b09bcac34a95124e9d9d5b3fd8e6e2e196d014119395a60d010f834150c725f52cc3f144ce93f7fb61ac31af225e047cc06ec72910e23c94f94fa63f9dada6606e8d07ef7aba2ea9b93e9f628bf72f5ac020605567a3f5a0b0040c5fac59655b2aaa8b89e950fd056a0d2181f154ea50f2a6a4ed3657494e4c89a434b63c11a00aa6460f817f8e038c492f53c4ecd261c1e26f359b46a43610148ff39ca1ac00ae20f419ee8bb5938594e3e288251d377f90d323806a0535047c64ffcfbb6dc07311e8c39a523542ba5f136ab86b33705842cae25ca7c5e257396c6a8722cf046276b488c017e805d6583b6ea6eb788a1c9ed206f5617bd399bc098befc20794300e3e0c192c358f958eff62d5d0a74aad5bd67ab58990657f2231b3f9b7dceddc271a80a3c1f5c0522eb0c97c175375d2f756446b6c16acf0a952659fefb7db1fadeeabf2b722eebb7ade1ee6ad4f7030c7c1a5b57405c8c99396954b9164d40f1747534ca6d425acafd2bad8a66d0a0f9e82a197d2c9b6492bb9ef4b628479894120ac62f103b47eecfc11038a6c680076d0d570e63f0b18aaa92858209b2bc12afe9586d6c2d334b81523659abd2821022c8aa6a1b5eb70f150cbea620e0895b43aa784da4734dfe9ebb227c41d15a28a8c976587029f4e1e9e6ef358b19ee4fe83d1088c9059f5a6145a895d69c17703a31d08300773ecee7487668e8393d287eb61725bf3f401aac972d27ba01128d59217edfb07fda66d449359e7fc51493f042570124690593ff5aa43045d062dd98977aa9e7052fb40fdccf54b7fd4ece122071b5a7667873be1be2f4ad992462ef6652d9e071dc3c846a2323d48557f171531422261bffeb4168cc1d94a2efea54078e820a72aa305c97cbbc9e9bb63ed0deebac4ad4912273769085eebef0fa7d8ab8b0be080ec91eaaff8344924dc7ab66c404a9adb6027dcaa556fcb912f8eec50e262baae6dfc589f44a474bf74eadd07a5623bcb76314691a889e85ff42cde8dd0ca2b68349585314e5ffa7885e7616fe50580b9f9b4f4338f5aef1eadba743b79f6da4c538755b924149bfe74fb1d00ac8db20e6dda8c99c39dba21a971e9b467be15cf6df78591370a257a3e32e89ab04c65946a3e117d3065ec7118a890cce8faf0eea0ba365a498a5dff0171c270e6b87552558db8346cdb6e6ce14f36ede5efdbc03f6c690944b614f617516f03b5f822e00ee374555e3fff332c8add068737ffbbebf2cc7cda8c90b9d312a5d4dfbc835aed9c65b1fe818d4fb6edc20518a47ea4fc9985ea11f40dd0deaab336247714737d4f7de8c4152b53743629eb47976a39791bc89a21633585991b9444359a398dce2c459e0fd9eb942ff0f094e11e62e5529d52e9a9110bd09ae63d906b6bd77bf8e980369bca4a3329ddcf6d1b0a610e6765c368e83fa6c5e9d63d5090425a7e6f69ecc70026f853b44b5046d53655b96e5c626d40e94f4bb718024887ae9125a39b5c4794c837e2896e0062701a2d52a5edf450cfd7d7a0eb82d8a2860b04052e15546ae98244f5aae94fe7de1340a0e11c7980d2b11ebfe4143a924056b7bad3a50c526333cd7d4a56279f7f663300f19b03811256dbb87263182bbd143d2f23d09bbe97bc11a6817a8de559f6e428706c89a9af964849b1aeff3b13de3270ed4d015907887778464c34506f5c22016b28f5016c16aab0f02ecd4199c6913d85a4ac319c5f5b9932fd2247871d52ce3748e5abeac83db067ab87556d3c259be6dd5445f0241a820503ec6cec2ad10f8f36712f8254e23bd7ee011563d4518961178f5787a3f599f907abe8d282cc2cea1f6a527f3b4c18da313f05d1b868d301694efa23ec4a6ec3877717a946a2b9cd093e77c96b1d343a4c61268243d8117fb2fd1ee5c5eba4b3f91b4690d01d2844729e90469e0c13d9166bb5e461a524a5f7ca50e3305a531ce392f5dbc66957d36b38b89cd8928c47ad9c3171b781973518a55ef980b5913b64c13cbe5a640f65154589004d35cc3f9a5a86026b482da8d81a011f6e92be5e4b4cab22ae1a3f6347ef1f5270596260f55773678898ccb84a545d23adb4c6ffd709477f088a6c1a33efeeb956e11fba2ff990c5581ce641cbd86b8fb39b7eda51bb4fa94024e40f02c5bfec7f79b2a5ca88d42d71f4d7443068c02c27b7c956c5148efcb937d5f7260dad63a458285d9d3dcd80798d321525b43afcb84230996a063b757c98cd4c487bb829ccb93acb491341c69ba90c71cbb55eae98322e1892f8ae9f7fef6792215cebd09e5045ee3e4b061dad102e10fc5c01db8eee416a81673d67955e73fa1a32f33f581d74c0ded3f3eb3ca53007e2033a8d9826289d345531f0edc820d7813bd83823084bd1cee76c1973e4ba46421e9f4f4502c7d2e3a9339e21237d5c321d8baab5e5da019dd67174a492fa48cb77a62a78d9fe0d26c5e327447071ea3ee7925b75a5b41f673fec394417645ea3a80685886846de3fdc1c5319d18dbff4453d4a3f9172788a66f3021a407cd881257fddd2516ccd0a97cf9f19a1764b7b49776c5f050ea1b94588d0641861e6c6f60b237940400e6d70350b51890ddc3194c47af5c273758f2e6a86de04afe56f9e543ef74c07ca0942bd667b5399f932f8322fc221dbfcc4943d5f0ac406056e3f1ee6a8dced25ff896eb27c92e97b838c4bbf571468657ba1c319cef2746e878f3e75d8f905104118afaeccf090844e0aa16db7029b28108634c785ea3db6e338c25ebf90f0c1bdb93a00138f6ea579fd9c1033ddcf537123638d9ec995d542917af55547d7a3ed48ba8035933b362c0fedc87eed1ec2f39d728e69d36c7e040af79648b7e879a18e4a9b24f08347d637719e88517a3ed8bed7b346eda8bd458badc0e9a8",
        "names": [
            {
                "@valid_since": "2001-02-24",
                "@last_seen": "2019-07-15",
                "prefix": "Mr",
                "first": "Kent",
                "middle": "Allen",
                "last": "Rianda",
                "display": "Kent Allen Rianda"
            }
        ],
        "emails": [
            {
                "@valid_since": "2008-01-01",
                "@last_seen": "2019-04-26",
                "@type": "work",
                "@email_provider": false,
                "address": "sales@fluidixinc.com",
                "address_md5": "19c96899dd162233bae639b65cc50970"
            },
            {
                "@valid_since": "2008-01-01",
                "@last_seen": "2019-07-16",
                "@type": "personal",
                "@email_provider": true,
                "address": "altitude8200@aol.com",
                "address_md5": "bb32ec8f6a2c89a4fe3651ff01ba803a"
            },
            {
                "@valid_since": "2018-02-02",
                "@last_seen": "2019-02-02",
                "@type": "personal",
                "@email_provider": true,
                "address": "jerijump@aol.com",
                "address_md5": "bb03a092a2366fc5be6d7becedf9c4c2"
            },
            {
                "@valid_since": "2012-10-04",
                "@type": "personal",
                "@email_provider": true,
                "address": "fluidix@aol.com",
                "address_md5": "87703752b3ea93eb7e0f09c93443a65e"
            },
            {
                "@valid_since": "2012-10-06",
                "@last_seen": "2019-06-24",
                "@email_provider": false,
                "address": "kent@thetroutfitter.com",
                "address_md5": "18e92321e2898b159a03e7fc3fb2418f"
            }
        ],
        "phones": [
            {
                "@valid_since": "2011-11-03",
                "@last_seen": "2018-10-12",
                "@type": "mobile",
                "@do_not_call": true,
                "country_code": 1,
                "number": 7609141476,
                "display": "760-914-1476",
                "display_international": "+1 760-914-1476"
            },
            {
                "@valid_since": "2004-03-07",
                "@type": "home_phone",
                "@do_not_call": true,
                "country_code": 1,
                "number": 7609354243,
                "display": "760-935-4243",
                "display_international": "+1 760-935-4243"
            },
            {
                "@valid_since": "2019-03-25",
                "@last_seen": "2019-03-25",
                "country_code": 1,
                "number": 7609342314,
                "display": "760-934-2314",
                "display_international": "+1 760-934-2314"
            },
            {
                "@valid_since": "2001-02-24",
                "@type": "home_phone",
                "@do_not_call": true,
                "country_code": 1,
                "number": 7609346405,
                "display": "760-934-6405",
                "display_international": "+1 760-934-6405"
            },
            {
                "@valid_since": "2006-02-19",
                "@last_seen": "2019-07-15",
                "@type": "work_phone",
                "@do_not_call": true,
                "country_code": 1,
                "number": 7609354242,
                "display": "760-935-4242",
                "display_international": "+1 760-935-4242"
            },
            {
                "@valid_since": "2006-11-07",
                "@type": "work_phone",
                "country_code": 1,
                "number": 7609352016,
                "display": "760-935-2016",
                "display_international": "+1 760-935-2016"
            },
            {
                "@valid_since": "2016-09-27",
                "@last_seen": "2018-03-24",
                "@type": "work_fax",
                "country_code": 1,
                "number": 7609236979,
                "display": "760-923-6979",
                "display_international": "+1 760-923-6979"
            },
            {
                "@valid_since": "2004-06-06",
                "@type": "work_fax",
                "country_code": 1,
                "number": 7609243772,
                "display": "760-924-3772",
                "display_international": "+1 760-924-3772"
            }
        ],
        "gender": {
            "@valid_since": "2010-03-01",
            "content": "male"
        },
        "dob": {
            "date_range": {
                "start": "1947-01-22",
                "end": "1947-01-22"
            },
            "display": "72 years old"
        },
        "languages": [
            {
                "@inferred": true,
                "language": "en",
                "display": "en"
            }
        ],
        "origin_countries": [
            {
                "@inferred": true,
                "country": "ID"
            }
        ],
        "addresses": [
            {
                "@valid_since": "2009-11-11",
                "@last_seen": "2019-06-19",
                "country": "US",
                "state": "CA",
                "city": "Mammoth Lakes",
                "po_box": "1807",
                "street": "Meadow View Drive",
                "house": "108",
                "zip_code": "93546",
                "display": "108 Meadow View Drive, Mammoth Lakes, California"
            },
            {
                "@valid_since": "2016-05-07",
                "@last_seen": "2019-06-19",
                "country": "US",
                "state": "CA",
                "city": "Mammoth Lakes",
                "po_box": "1734",
                "street": "Pearson Road",
                "house": "356",
                "zip_code": "93546",
                "display": "356 Pearson Road, Mammoth Lakes, California"
            },
            {
                "@valid_since": "2010-03-01",
                "@last_seen": "2019-07-15",
                "country": "US",
                "state": "CA",
                "city": "Mammoth Lakes",
                "po_box": "1734",
                "street": "Sierra Springs Drive",
                "house": "629",
                "zip_code": "93546",
                "display": "629 Sierra Springs Drive, Mammoth Lakes, California"
            },
            {
                "@valid_since": "2018-07-15",
                "@last_seen": "2019-04-26",
                "@type": "work",
                "country": "US",
                "state": "CA",
                "city": "Mammoth Lakes",
                "street": "Crowle Lake Drive",
                "house": "85",
                "zip_code": "93546",
                "display": "85 Crowle Lake Drive, Mammoth Lakes, California"
            },
            {
                "@valid_since": "2018-10-19",
                "@last_seen": "2019-07-15",
                "@type": "work",
                "country": "US",
                "state": "CA",
                "city": "Mammoth Lakes",
                "street": "Crowley Lake Drive",
                "house": "85",
                "zip_code": "93546",
                "display": "85 Crowley Lake Drive, Mammoth Lakes, California"
            },
            {
                "@valid_since": "2009-10-02",
                "@type": "work",
                "country": "US",
                "state": "CA",
                "city": "Crowley Lake",
                "street": "Tavern Road",
                "house": "1422",
                "apartment": "C6",
                "zip_code": "93546",
                "display": "1422-C6 Tavern Road, Crowley Lake, California"
            },
            {
                "@valid_since": "2014-01-01",
                "@last_seen": "2019-04-27",
                "country": "US",
                "state": "CA",
                "city": "Fresno",
                "display": "Fresno, California"
            },
            {
                "@valid_since": "2009-09-04",
                "@last_seen": "2019-06-19",
                "country": "US",
                "state": "CA",
                "city": "Huntington Beach",
                "street": "Nordina Drive",
                "house": "5952",
                "zip_code": "92649",
                "display": "5952 Nordina Drive, Huntington Beach, California"
            },
            {
                "@valid_since": "2009-11-11",
                "@last_seen": "2019-06-19",
                "@type": "old",
                "country": "US",
                "state": "CA",
                "city": "Irvine",
                "display": "Irvine, California"
            },
            {
                "@valid_since": "2009-11-11",
                "@last_seen": "2019-06-19",
                "@type": "old",
                "country": "US",
                "state": "CA",
                "city": "Mcarthur",
                "display": "Mcarthur, California"
            }
        ],
        "jobs": [
            {
                "@valid_since": "2012-10-04",
                "@last_seen": "2019-05-01",
                "title": "President",
                "organization": "Fluidix, Inc.",
                "date_range": {
                    "start": "1982-10-01"
                },
                "display": "President at Fluidix, Inc. (since 1982)"
            },
            {
                "@valid_since": "2014-01-01",
                "@last_seen": "2019-05-01",
                "title": "Manager of Engineering",
                "organization": "Polyflow Engineering",
                "date_range": {
                    "start": "1980-03-01",
                    "end": "1982-10-01"
                },
                "display": "Manager of Engineering at Polyflow Engineering (1980-1982)"
            },
            {
                "@valid_since": "2014-01-01",
                "@last_seen": "2019-05-01",
                "title": "Product Manager",
                "organization": "+GF+ Georg Fischer, Ltd",
                "date_range": {
                    "start": "1978-06-01",
                    "end": "1980-03-01"
                },
                "display": "Product Manager at +GF+ Georg Fischer, Ltd (1978-1980)"
            },
            {
                "@valid_since": "2004-06-06",
                "title": "Owner",
                "organization": "Fluidix Inc",
                "industry": "Sign Mfg",
                "display": "Owner at Fluidix Inc"
            }
        ],
        "educations": [
            {
                "@valid_since": "2014-01-01",
                "@last_seen": "2019-05-01",
                "degree": "Master of Science, Chemical Engineering",
                "school": "University of California, Berkeley",
                "date_range": {
                    "start": "1975-01-01",
                    "end": "1978-12-31"
                },
                "display": "Master of Science, Chemical Engineering from University of California, Berkeley (1975-1978)"
            }
        ],
        "relationships": [
            {
                "@type": "family",
                "names": [
                    {
                        "first": "Jerri",
                        "middle": "Jo",
                        "last": "Rianda",
                        "display": "Jerri Jo Rianda"
                    }
                ]
            },
            {
                "@type": "family",
                "names": [
                    {
                        "first": "Vickie",
                        "middle": "Ann",
                        "last": "Rianda",
                        "display": "Vickie Ann Rianda"
                    }
                ]
            },
            {
                "@type": "family",
                "names": [
                    {
                        "first": "Cheryl",
                        "middle": "Diane",
                        "last": "Kaufman",
                        "display": "Cheryl Diane Kaufman"
                    }
                ]
            },
            {
                "@valid_since": "2009-11-11",
                "@type": "other",
                "@subtype": "Co-Participent",
                "names": [
                    {
                        "@valid_since": "2009-11-11",
                        "first": "Arlene",
                        "last": "Rianda",
                        "display": "Arlene Rianda"
                    }
                ]
            }
        ],
        "user_ids": [
            {
                "@valid_since": "2013-01-20",
                "@last_seen": "2019-04-27",
                "content": "81400807@linkedin"
            },
            {
                "@valid_since": "2012-10-04",
                "@last_seen": "2019-05-01",
                "content": "40712886@linkedin"
            },
            {
                "@valid_since": "2013-01-20",
                "@last_seen": "2019-04-27",
                "content": "23/316/b47@linkedin"
            },
            {
                "@valid_since": "2012-10-04",
                "@last_seen": "2019-05-01",
                "content": "11/774/846@linkedin"
            },
            {
                "@valid_since": "2013-01-20",
                "@last_seen": "2019-04-27",
                "content": "#b4731623@linkedin"
            },
            {
                "@valid_since": "2012-10-04",
                "@last_seen": "2019-05-01",
                "content": "#84677411@linkedin"
            }
        ],
        "images": [
            {
                "@valid_since": "2019-05-01",
                "@last_seen": "2019-05-01",
                "url": "https://media.licdn.com/dms/image/C5603AQHZx24raVSe9Q/profile-displayphoto-shrink_200_200/0?e=1562198400&v=beta&t=4SRYL-VzZra585e30WPjSq1MhJ1MnJyCiNz3ZP-4UZ4",
                "thumbnail_token": "AE2861B20B7D6E22D4C9479C5C7387EF9C9CE823D35EABEA73B2CFB4863058AE4E7CF680C08DE8100FE2AD69462990450F2056BB8F128708CC9F784005054530B6D99C6148A128E5131BFBA8CFF5F9BDB5A8E97CF99A12DD7A9948B1D92730DCE2C2B34A55546211CCC892B90151753EF50232DAFA8BEB440D32DCB513C4A8F04372EC1D071A8C6C4B3AB76B2A0C9806396C8F300D26D55067FBB3368D3EB38D8D8373FBD7"
            },
            {
                "@valid_since": "2019-04-27",
                "@last_seen": "2019-04-27",
                "url": "https://static.licdn.com/sc/h/djzv59yelk5urv2ujlazfyvrk",
                "thumbnail_token": "AE2861B20B7D6E22CAD84281543EC5EA969BE2639E52A9A838ACDFB487725DA35125808C8FD8B73A6BDF856746688848380955FBA84F9C5CC78A78485D1D14"
            }
        ],
        "urls": [
            {
                "@source_id": "1e2eb2066d14c936432b5110682137f6",
                "@domain": "linkedin.com",
                "@name": "LinkedIn",
                "@category": "professional_and_business",
                "url": "https://www.linkedin.com/in/kent-rianda-84677411"
            },
            {
                "@source_id": "523e0e8bd24f41b296200f344c5160a0",
                "@sponsored": true,
                "@domain": "tracking.instantcheckmate.com",
                "@name": "Instant Checkmate",
                "@category": "background_reports",
                "url": "http://tracking.instantcheckmate.com/?a=60&c=148&city=Huntington+Beach&cmp=SB_MultiR&fname=Kent&lname=Rianda&mdm=api&oc=5&s1=Mshortcut_results&s1=SB_MultiR&s2=3&s4=results&s5=09292017-01&src=pipl&state=CA"
            },
            {
                "@source_id": "0beb70b32dbb7121b6b7eb020e8341c1",
                "@domain": "shop.mattressgrab.com",
                "@name": "shop.mattressgrab.com",
                "@category": "web_pages",
                "url": "http://shop.mattressgrab.com/"
            },
            {
                "@source_id": "1d9b8619498c264625f75a0bd9358919",
                "@domain": "fluidixinc.com",
                "@name": "fluidixinc.com",
                "@category": "web_pages",
                "url": "http://fluidixinc.com/gauge_isolators.html"
            },
            {
                "@source_id": "c338e8e17698d1ed5de10f9eded2cc65",
                "@domain": "digital.cemag.us",
                "@name": "digital.cemag.us",
                "@category": "web_pages",
                "url": "http://digital.cemag.us/controlledenvironments/2015_buyers_guide?pg=25"
            },
            {
                "@source_id": "6dfc7c62b18a145b78e82a37e7b1a5e6",
                "@domain": "sierrayellowpages.com",
                "@name": "sierrayellowpages.com",
                "@category": "web_pages",
                "url": "https://sierrayellowpages.com/Business-Services/Signs.html?ft_id=12936"
            },
            {
                "@source_id": "a3ddd8bec531f9bcac7d3efd8dbefb22",
                "@domain": "chamberofcommerce.com",
                "@name": "chamberofcommerce.com",
                "@category": "web_pages",
                "url": "https://www.chamberofcommerce.com/mammoth-lakes-ca/32241696-fluidix-inc"
            },
            {
                "@source_id": "508fefb00f9df63e7f1be8efa278ce08",
                "@domain": "int.thetroutfitter.com",
                "@name": "int.thetroutfitter.com",
                "@category": "web_pages",
                "url": "https://www.int.thetroutfitter.com/Guide-Staff.html"
            },
            {
                "@source_id": "e03e4fc7283faf97450e87ed8e15441d",
                "@domain": "easternsierrafishreports.com",
                "@name": "easternsierrafishreports.com",
                "@category": "web_pages",
                "url": "https://www.easternsierrafishreports.com/fish_reports/13038/the-crowley-lake-stillwater-classic-report.php"
            },
            {
                "@source_id": "d413a2acfb33f8cd204be44000fcda0f1235e91bf496d693a28ea524669989e9",
                "@domain": "sportfishingreport.com",
                "@name": "sportfishingreport.com",
                "@category": "web_pages",
                "url": "http://www.sportfishingreport.com/pages/detail_fresh.php?id=13790"
            },
            {
                "@source_id": "5cc0cc6bc8c9aae6c111a788e59e7bac",
                "@domain": "thetroutfly.com",
                "@name": "thetroutfly.com",
                "@category": "web_pages",
                "url": "http://thetroutfly.com/fishreport.html"
            },
            {
                "@source_id": "ba1896736b0d89493c604f492b79bbbc",
                "@domain": "mattressdaddy.com",
                "@name": "mattressdaddy.com",
                "@category": "web_pages",
                "url": "http://mattressdaddy.com/"
            },
            {
                "@source_id": "2c709c30522e8e3b6f199fad5257312d",
                "@domain": "whitepages.plus",
                "@name": "WhitePages.plus",
                "@category": "contact_details",
                "url": "https://whitepages.plus/n/Kent_Rianda/Mammoth_lakes_CA/825f36446aa59c51ec9d4ece2d68bea9"
            },
            {
                "@source_id": "761481c8e9e3a28b2aa788c9ac5724d8",
                "@domain": "linkedin.com",
                "@name": "LinkedIn",
                "@category": "professional_and_business",
                "url": "https://www.linkedin.com/in/kent-rianda-b4731623"
            },
            {
                "@source_id": "9701caaefaca8d7929f3b413cd1d41507ec8c932fb10cc420aa7bf269bced259",
                "@domain": "shop.mattressgrab.com",
                "@name": "shop.mattressgrab.com",
                "@category": "web_pages",
                "url": "https://shop.mattressgrab.com/login.sc"
            },
            {
                "@source_id": "ea96359092acbfe322eef218af37f5627ec8c932fb10cc420aa7bf269bced259",
                "@domain": "fluidixinc.com",
                "@name": "fluidixinc.com",
                "@category": "web_pages",
                "url": "http://www.fluidixinc.com/"
            },
            {
                "@source_id": "3024fc2588ad168dd2ac89addd5b0bf9",
                "@domain": "digital.cemag.us",
                "@name": "digital.cemag.us",
                "@category": "web_pages",
                "url": "http://digital.cemag.us/controlledenvironments/march_april_2016?pg=50"
            },
            {
                "@source_id": "ea80d93e4959692a610f39895fb97898",
                "@domain": "digital.cemag.us",
                "@name": "digital.cemag.us",
                "@category": "web_pages",
                "url": "http://digital.cemag.us/controlledenvironment/march_2014?pg=52&lm=1514999074000"
            },
            {
                "@source_id": "098963f3ddbfdaa20df3610d1d7dfd931235e91bf496d693a28ea524669989e9",
                "@domain": "sportfishingreport.com",
                "@name": "sportfishingreport.com",
                "@category": "web_pages",
                "url": "http://www.sportfishingreport.com/pages/detail_fresh.php?id=13038"
            },
            {
                "@source_id": "1b0b899538a30fabccd5b4cf995c6fcb",
                "@domain": "int.thetroutfitter.com",
                "@name": "int.thetroutfitter.com",
                "@category": "web_pages",
                "url": "https://www.int.thetroutfitter.com/help.html"
            },
            {
                "@source_id": "8fd667622f07b5f822910da6efad04617ec8c932fb10cc420aa7bf269bced259",
                "@domain": "fluidixinc.com",
                "@name": "fluidixinc.com",
                "@category": "web_pages",
                "url": "http://www.fluidixinc.com/dimensional_information.html"
            },
            {
                "@source_id": "b5201079fce1d9935b7ca62869076b52",
                "@domain": "fluidixinc.com",
                "@name": "fluidixinc.com",
                "@category": "web_pages",
                "url": "http://fluidixinc.com/"
            },
            {
                "@source_id": "8b06bd2751e9b1c07d63d473509c92f0",
                "@domain": "easternsierrafishreports.com",
                "@name": "easternsierrafishreports.com",
                "@category": "web_pages",
                "url": "https://www.easternsierrafishreports.com/fish_reports/17237/crowley-lake-fish-report--update-by-kent-rianda-6-5-09.php"
            },
            {
                "@source_id": "523e0e8bd24f41b296200f344c5160a0",
                "@sponsored": true,
                "@domain": "tracking.instantcheckmate.com",
                "@name": "Instant Checkmate",
                "@category": "background_reports",
                "url": "http://tracking.instantcheckmate.com/?a=60&c=148&city=Huntington+Beach&cmp=SB_MultiR&fname=Kent&lname=Rianda&mdm=api&oc=5&s1=Mshortcut_results&s1=SB_MultiR&s2=3&s4=results&s5=09292017-01&src=pipl&state=CA"
            },
            {
                "@valid_since": "2014-01-01",
                "@last_seen": "2019-05-01",
                "@domain": "fasthandle.com",
                "@category": "personal_profiles",
                "url": "http://www.Fasthandle.com"
            },
            {
                "@valid_since": "2014-01-01",
                "@last_seen": "2019-05-01",
                "@domain": "thetroutfitter.com",
                "@category": "personal_profiles",
                "url": "http://www.thetroutfitter.com"
            },
            {
                "@valid_since": "2019-05-01",
                "@last_seen": "2019-05-01",
                "@domain": "sg.linkedin.com",
                "@category": "personal_profiles",
                "url": "https://sg.linkedin.com/edu/university-of-california-berkeley-17939"
            }
        ]
    }
}';
        $decoded_response = json_decode($response);
            if($decoded_response != null || $decoded_response != "")
            {
                if (array_key_exists('error', $decoded_response)) {
                    $error = true;
                    return redirect()->back()->with('warning_msg', "Error while proceeding request.");
                }elseif (array_key_exists('possible_persons', json_decode($response))) {
                    $error = true;
                    return redirect()->back()->with('warning_msg', "Show Multiple Profile Result is in progress.");
                }
                else{
                    $error = false;
                    $score = $this->calc_score(json_decode($response, true));
                    $final_res = $this->getPipleResults($workbench_id,$score,$response);
                    //                    dd($final_res);
                }
            }
            else{
                $error = true;
                return redirect()->back()->with('warning_msg', "Error while proceeding request.");
            }
    }

    public function parse_piple_json($item, $key,$arr_values)
            {
                global $result_api;
                global $final_res;
                global $i;
                $i++;
                $current_res = $arr_values['res_key'];
                $parent_key = $arr_values['parent_key'];
                $sub_array = ['phones', 'emails', 'twitter', 'facebook', 'linkedin', 'gravatar', "crunchbase"];
        //    echo '<br/>Iteration Number: ' . $i . ' has object <b>' . $current_res . '</b> with parent keyname: <b>' . $parent_key . '</b>  with key <b>' . $key . '</b> has <b>' . $item . '</b>';
                if (!is_array($result_api[$current_res])) {
                    return false;
                }
                else {
                    foreach ($result_api[$current_res] as $r_key => $r_val) {

                        if($r_key == $key && $key == "dob")
                        {
                            if($item == "start" || $item == "end")
                            {
                                $final_res[$current_res][$parent_key][$key][$item] = $r_val['date_range'][$item];
                            }elseif($item == "display"){
                                $final_res[$current_res][$parent_key][$key][$item] = $r_val[$item];
                            }
                        }
                        if($r_key == $key && $parent_key == "relations" && array_key_exists("relationships",$r_val))
                        {
                            if($item == "display")
                            {
                                $final_res[$current_res][$parent_key][$key] = $r_val['names'][$item];
                            }elseif($item == "@type"){
                                if($r_val[$item] != "")
                                {
                                    $final_res[$current_res][$parent_key][$key] = $r_val[$item];
                                }else{
                                    $final_res[$current_res][$parent_key][$key] = "";
                                }
                            }
                        }
                        if ($r_key == $key && $r_key != "dob" && $parent_key != "relations" && !array_key_exists("relationships",$r_val)) {
                            if (in_array($key, $sub_array)) {
                                foreach ($r_val as $item_key => $items)
                                {
                                    if (array_key_exists($item, $items) == 1) {
                                        $final_res[$current_res][$parent_key][$item][$item_key] = $items[$item];
                                    }else{
                                        $final_res[$current_res][$parent_key][$item][$item_key] = "";
                                    }
                                }
                            }
                            else if (array_key_exists($item, $r_val) == 1) {
                                $final_res["$current_res"][$parent_key][$key] = $r_val[$item];
                            }
                            else {
                                foreach ($r_val as $r_key => $r_value)
                                {
                                    if(array_key_exists($item,$r_value))
                                    {
                                        if($key == 'addresses'){
                                            if(empty($r_value[$item]))
                                            {
                                                $final_res["$current_res"][$parent_key][$item][$r_key] ="" ;
                                            }else{
                                                $final_res["$current_res"][$parent_key][$item][$r_key] = $r_value[$item];
                                            }
                                        }else{

                                            if(empty($r_value[$item]))
                                            {
                                                $final_res["$current_res"][$parent_key][$key][$r_key] = "";
                                            }else{
                                                $final_res["$current_res"][$parent_key][$key][$r_key] = $r_value[$item];
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
    public function getPipleResults($workbench_id,$score,$result)
            {
                global $result_api;
                global $final_res;
        //         dd($result);
        //        foreach ($result as $item) {

                $result_api = json_decode($result, true);
        //            $result_api = $result;
                $final_res = [];
                if (is_array($result_api)) {
                    foreach ($result_api as $res_key => $v) {
                        if ($res_key == "person") {
        //                    $json = '{"personal":{"name":{"person":{"names":{"names":"display"}}},"email":{"person":{"emails":"address"}},"phone_number":{"person":{"phones":"display_international"}},"gender":{"person":{"gender":"content"}},"age":{"person":{"dob":"display"}},"date_of_birth_start":{"person":{"dob":"start"}},"date_of_birth_end":{"person":{"dob":"end"}},"languages":{"person":{"languages":"language"}}},"geo_location":{"location":{"person":{"addresses":"display"}},"zip_code":{"person":{"addresses":"zip_code"}},"state":{"person":{"addresses":"state"}},"city":{"person":{"addresses":"city"}},"country":{"person":{"addresses":"country"}}},"employment":{"career":{"person":{"jobs":"organization"}},"domain":{"person":{"jobs":"industry"}},"from":{"person":{"jobs":{"date_range":"start"}}},"to":{"person":{"jobs":{"date_range":"end"}}},"role":{"person":{"jobs":"display"}}},"education":{"education":{"person":{"educations":"display"}}},"social":{"domain":{"person":{"urls":"domain"}},"domain_name":{"person":{"urls":"name"}},"domain_category":{"person":{"urls":"category"}},"domain_url":{"person":{"urls":"url"}}}}';
                            $json = '{"personal":{"name":{"person":{"names":{"names":"display"}}},"gender":{"person":{"gender":"content"}},"age":{"person":{"dob":"display"}},"date_of_birth_start":{"person":{"dob":"start"}},"date_of_birth_end":{"person":{"dob":"end"}},"languages":{"person":{"languages":"language"}},"origin_countries":{"person":{"origin_countries":"country"}},"images":{"person":{"images":"url"}}},"emails":{"email":{"person":{"emails":"address"}},"email_type":{"person":{"emails":"@type"}},"email_last_seen":{"person":{"emails":"@last_seen"}}},"phones":{"phone_number":{"person":{"phones":"display_international"}},"phone_type":{"person":{"phones":"@type"}},"phone_last_seen":{"person":{"phones":"@last_seen"}}},"geo_location":{"location":{"person":{"addresses":"display"}},"type":{"person":{"addresses":"@type"}},"zip_code":{"person":{"addresses":"zip_code"}},"po_box":{"person":{"addresses":"po_box"}},"state":{"person":{"addresses":"state"}},"city":{"person":{"addresses":"city"}},"country":{"person":{"addresses":"country"}}},"employment":{"career":{"person":{"jobs":"organization"}},"title":{"person":{"jobs":"title"}},"domain":{"person":{"jobs":"industry"}},"from":{"person":{"jobs":{"date_range":"start"}}},"to":{"person":{"jobs":{"date_range":"end"}}},"role":{"person":{"jobs":"display"}}},"education":{"education":{"person":{"educations":"display"}}},"relations":{"type":{"person":{"relationships":"@type"}},"names":{"person":{"relationships":{"names":"display"}}}},"user_ids":{"last_seen":{"person":{"user_ids":"@last_seen"}},"content":{"person":{"user_ids":"content"}}},"social":{"domain":{"person":{"urls":"domain"}},"domain_name":{"person":{"urls":"name"}},"domain_category":{"person":{"urls":"category"}},"domain_url":{"person":{"urls":"url"}}}}';

                            $result_json = json_decode($json, true);
                            foreach ($result_json as $key => $v) {
                                if ($res_key == "person") {
                                    foreach ($result_json as $key => $val) {
                                        $send = ["parent_key" => $key, "res_key" => $res_key];
                                        array_walk_recursive($result_json[$key], 'self::parse_piple_json', $send);
                                    }
                                }
                            }
                        }

                    }
                }
        //            return $final_res;
        //        dump($result);
                dd($final_res);
        //        dd(json_encode($final_res));
                // Save record in a Database

                $result = Workbench_Result::create([
                    'workbench_id' => $workbench_id,
                    'response' => $result,
                    'result' => json_encode($final_res),
                    'source_options_id' => 14,
                    'score' => $score,
                    'workbench_id' => $workbench_id,
                    "type" => 0,
                ]);
        //        $final_res
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
        //        Final Result Manipulation
                $res_det = [];
                //  Name
                $res_det['name'] = [];
                if (array_key_exists('person', $final_res))
                {
                    if(array_key_exists('personal', $final_res['person']))
                    {
                        if(array_key_exists('names',$final_res['person']['personal']))
                        {
                            $res_det['name'] = array_values($final_res['person']['personal']['names']);
                        }
                    }
                }
                $res_det['name'] = array_unique($res_det['name']);
                //  Email
                $res_det['email'] = [];
                if (array_key_exists('person', $final_res))
                {
                    if(array_key_exists('emails', $final_res['person']))
                    {
                        foreach ($final_res['person']['emails']['address'] as $addr_key => $addr)
                        {
                            $res_det['email'][$addr_key] = "<p>".$addr;
                            if(!empty($final_res['person']['emails']['@type'][$addr_key]))
                            {
                                $res_det['email'][$addr_key] .= ' ('.$final_res['person']['emails']['@type'][$addr_key].')</p>';
                            }else{
                                $res_det['email'][$addr_key] .= "</p>";
                            }
                            if(!empty($final_res['person']['emails']['@last_seen'][$addr_key])) {
                                $res_det['email'][$addr_key] .= '<i>Last seen at: ' . $final_res['person']['emails']['@last_seen'][$addr_key].'</i>';
                            }
                        }
                    }
                }
                //  Age
                $res_det['age'] = [];
                $res_det['dob'] = [];
                if (array_key_exists('person', $final_res))
                {
                    if(array_key_exists('personal', $final_res['person']))
                    {
                        if(array_key_exists('dob',$final_res['person']['personal']))
                        {
                            $res_det['age'] = $final_res['person']['personal']['dob']['display'];
                            $res_det['dob'] = $final_res['person']['personal']['dob']['start'].' - '.$final_res['person']['personal']['dob']['end'];
                        }
                    }
                }
                //Gender
                $res_det['gender'] = "";
                if (array_key_exists('person', $final_res)) {
                    if (array_key_exists('personal', $final_res['person'])) {
                        if (array_key_exists('gender', $final_res['person']['personal'])) {
                            $res_det['gender'] = $final_res['person']['personal']['gender'];
                        }
                    }
                }
                //Languages
                $res_det['language'] = [];
                if (array_key_exists('person', $final_res)) {
                    if (array_key_exists('personal', $final_res['person'])) {
                        if (array_key_exists('languages', $final_res['person']['personal'])) {
                            $res_det['language'] = array_values($final_res['person']['personal']['languages']);
                        }
                    }
                }
                $res_det['language'] = array_unique($res_det['language']);
                //Avatar
                $res_det['avatar'] = [];
                //Bio
                $res_det['bio'] = [];
                //Site
                $res_det['site'] = [];
                //Phone Numbers
                $res_det['phone_number'] = [];
                if (array_key_exists('person', $final_res))
                {
                        if(array_key_exists('phones',$final_res['person']))
                        {
                            foreach ($final_res['person']['phones']['display_international'] as $ph_key => $ph)
                            {
                                $res_det['phone_number'][$ph_key] = "<p>".$ph;
                                if(!empty($final_res['person']['emails']['@type'][$ph_key]))
                                {
                                    $res_det['phone_number'][$ph_key] .= ' ('.$final_res['person']['emails']['@type'][$ph_key].')</p>';
                                }else{
                                    $res_det['phone_number'][$ph_key] .= "</p>";
                                }
                                if(!empty($final_res['person']['emails']['@last_seen'][$ph_key])) {
                                    $res_det['phone_number'][$ph_key] .= '<i> Last seen at: ' . $final_res['person']['emails']['@last_seen'][$ph_key].'</i>';
                                }
                            }
                        }
                }
                $res_det['phone_number'] = array_unique($res_det['phone_number']);
                //Images
                $res_det['images'] = [];
                if (array_key_exists('person', $final_res)) {
                    if (array_key_exists('personal', $final_res['person'])) {
                        if(array_key_exists('images',$final_res['person']['personal']))
                        {
                            $res_det['images'] = array_values($final_res['person']['personal']['images']);
                        }
                    }
                }
                //URL
                $res_det['urls'] = [];
                //ethnicity
                $res_det['ethnicity'] = [];
                //origin_country
                $res_det['origin_country'] = [];
                if (array_key_exists('person', $final_res)) {
                    if (array_key_exists('personal', $final_res['person'])) {
                        if(array_key_exists('origin_countries',$final_res['person']['personal']))
                        {
                            $res_det['origin_country'] = array_values($final_res['person']['personal']['origin_countries']);
                        }
                    }
                }
                $res_det['origin_country'] = array_unique($res_det['origin_country']);
                //location
                $res_det['location'] = [];
                if (array_key_exists('person', $final_res))
                {
                    if(array_key_exists('geo_location', $final_res['person']))
                    {
                        if(array_key_exists('display', $final_res['person']['geo_location']))
                        {
                            foreach ($final_res['person']['geo_location']['display'] as $loc_key => $display)
                            {
                                $res_det['location'][$loc_key] = '<p>'.$display;
                                if(array_key_exists($loc_key,$final_res['person']['geo_location']['@type']))
                                {
                                    $res_det['location'][$loc_key] .= '( '.$final_res['person']['geo_location']['@type'][$loc_key].' )</p>';
                                }else{
                                    $res_det['location'][$loc_key] .= '</p>';
                                }
                            }

                        }
                    }
                }
                $res_det['location'] = array_unique($res_det['location']);
                //Longitude
                $res_det['longitude'] = [];
                //latitude
                $res_det['latitude'] = [];
                //city
                $res_det['city'] = [];
                if (array_key_exists('person', $final_res))
                {
                    if($final_res['person']['geo_location']['city'] != null) {
                        $res_det['city'] = array_values($final_res['person']['geo_location']['city']);
                    }
                }
                $res_det['city'] = array_unique($res_det['city']);
                //pobox
                $res_det['pobox'] = [];
                if (array_key_exists('person', $final_res))
                {
                    if(array_key_exists('pobox',$final_res['person']['geo_location']))
                    {
                        if($final_res['person']['geo_location']['pobox'] != null) {
                            $res_det['pobox'] = array_values($final_res['person']['geo_location']['pobox']);
                        }
                    }
                }
                $res_det['pobox'] = array_unique($res_det['pobox']);
                //state
                $res_det['state'] = [];
                if (array_key_exists('person', $final_res))
                {
                    if($final_res['person']['geo_location']['state'] != null) {
                        $res_det['state'] = array_values($final_res['person']['geo_location']['state']);
                    }
                }
                $res_det['state'] = array_unique($res_det['state']);
                //country
                $res_det['country'] = [];
                if (array_key_exists('person', $final_res))
                {
                    if($final_res['person']['geo_location']['country'] != null) {
                        $res_det['country'] = array_values($final_res['person']['geo_location']['country']);
                    }
                }
                $res_det['country'] = array_unique($res_det['country']);
                //timezone
                $res_det['timezone'] = [];
                // Relations
                $res_det['relationships'] = [];
                //Zip Code
                $res_det['zip_code'] = [];
                if (array_key_exists('person', $final_res))
                {
                    if($final_res['person']['geo_location']['zip_code'] != null) {
                        $res_det['zip_code'] = array_values($final_res['person']['geo_location']['zip_code']);
                    }
                }
                $res_det['zip_code'] = array_unique($res_det['zip_code']);
                //career
                $res_det['career'] = [
                    'name' => [],
                    'logo' => [],
                    'title' => [],
                    'domain' => [],
                    'role' => [],
                    'description' => [],
                    'foundedYear' => [],
                    'type' => [],
                ];
                if (array_key_exists('person', $final_res))
                {
                    if (array_key_exists('employment', $final_res['person']))
                    {
                        if (array_key_exists('jobs', $final_res['person']['employment']))
                        {
                            if($final_res['person']['employment']['jobs'] != null) {
                                $res_det['career']['name'] = array_values($final_res['person']['employment']['jobs']);
                            }
                        }
                    }
                }
                $res_det['zip_code'] = array_unique($res_det['zip_code']);
                //social
                $res_det['education'] = [];
                if (array_key_exists('person', $final_res))
                {
                    if (array_key_exists('education', $final_res['person']))
                    {
                        if (array_key_exists('educations', $final_res['person']['education']))
                        {
                            if($final_res['person']['education']['educations'] != null) {
                                $res_det['education'] = array_values($final_res['person']['education']['educations']);
                            }
                        }
                    }
                }
                //social
                $res_det['social'] = [];
                if (array_key_exists('person', $final_res))
                {
                    if (array_key_exists('social', $final_res['person'])) {
                        if(array_key_exists('urls',$final_res['person']['social']))
                        {
                            $res_det['urls'] = array_values($final_res['person']['social']['urls']);
                        }
                    }
                }
                $res_det['social'] = array_unique($res_det['social']);
                $res_det['urls'] = array_unique($res_det['urls']);

                $result_save = new PersonalResult();
                $result_save->workbench__results_id = $result->id;
                $result_save->name = ($res_det['name'] == []) ? NULL : json_encode($res_det['name']);
                $result_save->email = ($res_det['email'] == []) ? NULL : json_encode($res_det['email']);
                $result_save->age = ($res_det['age'] == []) ? NULL : json_encode($res_det['age']);
                $result_save->gender = ($res_det['gender'] == "") ? NULL : json_encode($res_det['gender']);
                $result_save->language = ($res_det['language'] == []) ? NULL : json_encode($res_det['language']);
                $result_save->dob = ($res_det['dob'] == []) ? NULL : json_encode($res_det['dob']);
                $result_save->avatar = ($res_det['avatar'] == []) ? NULL : json_encode($res_det['avatar']);
                $result_save->bio = ($res_det['bio'] == []) ? NULL : json_encode($res_det['bio']);
                $result_save->site = ($res_det['site'] == []) ? NULL : json_encode($res_det['site']);
                $result_save->phone_number = ($res_det['phone_number'] == []) ? NULL : json_encode($res_det['phone_number']);
                $result_save->images = ($res_det['images'] == []) ? NULL : json_encode($res_det['images']);
                $result_save->urls = ($res_det['urls'] == []) ? NULL : json_encode($res_det['urls']);
                $result_save->ethnicity = ($res_det['ethnicity'] == []) ? NULL : json_encode($res_det['ethnicity']);
                $result_save->origin_country = ($res_det['origin_country'] == []) ? NULL : json_encode($res_det['origin_country']);
                $result_save->relations = ($res_det['relationships'] == []) ? NULL : json_encode($res_det['relationships']);
                $result_save->location = ($res_det['location'] == []) ? NULL : json_encode($res_det['location']);
                $result_save->longitude = ($res_det['longitude'] == []) ? NULL : json_encode($res_det['longitude']);
                $result_save->latitude = ($res_det['latitude'] == []) ? NULL : json_encode($res_det['latitude']);
                $result_save->state = ($res_det['state'] == []) ? NULL : json_encode($res_det['state']);
                $result_save->city = ($res_det['city'] == []) ? NULL : json_encode($res_det['city']);
                $result_save->country = ($res_det['country'] == []) ? NULL : json_encode($res_det['country']);
                $result_save->zip_code = ($res_det['zip_code'] == []) ? NULL : json_encode($res_det['zip_code']);
                $result_save->timezone = ($res_det['timezone'] == []) ? NULL : json_encode($res_det['timezone']);
                $result_save->career = ($res_det['career'] == []) ? NULL : json_encode($res_det['career']);
                $result_save->education = ($res_det['education'] == []) ? NULL : json_encode($res_det['education']);
                $result_save->social = ($res_det['social'] == []) ? NULL : json_encode($res_det['social']);
                $result_save->save();
            }
            /*
                *   Piple API  CURL & Response Handling Ends Here
            */
}