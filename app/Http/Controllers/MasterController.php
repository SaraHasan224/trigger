<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
class MasterController extends BaseController {

    public $data = [];

    function __construct() {

        $this->data["OpenIn"] = [0 => "_self", 1 => "_blank"];
        \View::share($this->data);
    }

    public function SendEmail($to, $to_name, $from, $from_name, $subject, $body, $cc = null, $bcc = null, $attachment = null) {
        $email = new \SendGrid\Mail\Mail();

        $email->setFrom($from, $from_name);
        $email->setSubject($subject);
        if(is_array($to)) {
            for($i = 0; $i<count($to); $i++) {
                $email->addTo($to[$i], (is_array($to_name) ? $to_name[$i] : $to_name));
            }
        } else {
            $email->addTo($to, $to_name);
        }
        if($cc !== null) {
            if (is_array($cc)) {
                for ($i = 0; $i < count($cc); $i++) {
                    $email->addCC($cc[$i]);
                }
            } else {
                $email->addCC($cc);
            }
        }

        if($bcc !== null) {
            if (is_array($bcc)) {
                for ($i = 0; $i < count($bcc); $i++) {
                    $email->addBcc($bcc[$i]);
                }
            } else {
                $email->addBcc($bcc);
            }
        }

        $email->addContent("text/plain", strip_tags($body));
        $email->addContent("text/html", $body);
        if($attachment != null) {
            $file_encoded = base64_encode(file_get_contents($attachment));
            $fl = explode("/", $attachment);
            $filename = end($fl);
            $mime_type = \File::mimeType($attachment);

            $email->addAttachment($file_encoded, $mime_type, $filename, 'attachment');
        }

        $sendgrid = new \SendGrid(env('SENDGRID_API_KEY'));

        try {
            $response = $sendgrid->send($email);
        } catch (Exception $e) {
            //echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }
}
