<?php

namespace App\Http\Controllers\Admin\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
// Guzzle Files import
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;


class APIController extends AdminController
{
    function __construct() {
        parent::__construct();
    }

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
}
