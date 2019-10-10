<?php
namespace App\TraitsFolder;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Auth;
use App\Notification;

trait CommonTrait
{
    public function singleEmail($recipient,$subject,$from,$message,$attachment)
    {
        $logoUrl = asset('admin/assets/images/logo-email.png');
        $mail_val = [
            'name' => "Customer",
            'email' => $recipient,
            'g_email' => $from,
            'g_title' => "Trigger",
            'subject' => $subject,
        ];
        /*Notification::create([
            'from_id' => Auth::user()->id,
            'message' => Auth::user()->name.' send email to recipient '.escape(Input::get("recipient"))
        ]);*/

        // Firebase Notification sent
        Notification::Notify(
            auth()->user()->user_type,
            $this->to_id,
            Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." sent email to recipient: ".escape(Input::get("recipient")),
            '/admin-dashboard/email/',
            Auth::user()->id,
            '  bg-inverse-secondary text-warning',
            'mdi mdi-security'
        );

        Mail::send('emails.sample', ['msg'=>$message, 'logoUrl'=>$logoUrl], function ($m) use ($mail_val,$attachment) {
            $m->from($mail_val['g_email'], $mail_val['g_title']);
            if($attachment != [])
            {
                $m->attach($attachment['path'],[
                    'as' => $attachment['name'],
                    'mime' => 'application/'.$attachment['extension'],
                ]);
            }
            $m->to($mail_val['email'], $mail_val['name'])->subject($mail_val['subject']);
        });
    }
    public function bulkEmail($recipient,$subject,$from,$message,$attachment)
    {
            $bcc = [];
            $logoUrl = asset('admin/assets/images/logo-email.png');
            foreach ($recipient as $key => $email) {
                if ($key > 0) {
                    array_push($bcc, $email);
//                    Notification::create([
//                        'from_id' => Auth::user()->id,
//                        'message' => Auth::user()->name.' send email to recipient '.$email
//                    ]);

                    // Firebase Notification sent
                    Notification::Notify(
                        auth()->user()->user_type,
                        $this->to_id,
                        "User: ".Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." sent bulk emails to recipient: ".$email,
                        '/admin-dashboard/bulk-email/',
                        Auth::user()->id,
                        '  bg-inverse-secondary text-warning',
                        'mdi mdi-security'
                    );

                }else{
//                    Notification::create([
//                        'from_id' => Auth::user()->id,
//                        'message' => Auth::user()->name.' send email to recipient '.$recipient[0]
//                    ]);

                    // Firebase Notification sent
                    Notification::Notify(
                        auth()->user()->user_type,
                        $this->to_id,
                        "User: ".Auth::user()->name." ( Having Role: ".Auth::user()->role->name.")"." sent bulk emails to recipient: ".$recipient[0],
                        '/admin-dashboard/bulk-email/',
                        Auth::user()->id,
                        '  bg-inverse-secondary text-warning',
                        'mdi mdi-security'
                    );
                }
            }
            $mail_val = ['name' => "Customer", 'email' => $recipient[0], 'g_email' => $from, 'g_title' => "Trigger", 'subject' => $subject,];
            Mail::send('emails.sample', ['msg' => $message, 'logoUrl' => $logoUrl], function ($m) use ($mail_val, $bcc,$attachment) {
                $m->from($mail_val['g_email'], $mail_val['g_title']);
                $m->bcc($bcc,'');
                if($attachment != [])
                {
                    $m->attach($attachment['path'], [
                    'as' => $attachment['name'],
                    'mime' => 'application/'.$attachment['extension'],
                ]);
                }
                $m->to($mail_val['email'], $mail_val['name'])->subject($mail_val['subject']);
            });
    }
}