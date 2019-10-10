<?php

namespace App\Http\Controllers\Admin\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Input;
use Validator, Hash;
use Auth;
use App\Notification;
use App\TraitsFolder\CommonTrait;


class Email extends AdminController
{
    use CommonTrait;
    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->check_access('Send Email');
        return view('admin.administrator.configuration.email.send',$this->data);
    }

    public function save() {
        $this->check_access('Send Email');
        $v = Validator::make(Input::all(), [
            'recipient' => 'required|email',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);

        $v->setAttributeNames([
            'recipient' => "Recipient field is required",
            'subject' => "Subject field is required",
            'message' => "Message field is required",
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        } else {
            $recipient = escape(Input::get("recipient"));
            $subject = escape(Input::get("subject"));
            $from = Auth::user()->email;
            $message = Input::get("message");
            $file = Input::file('attachment');

            $attachment = [];
            if($file != '')
            {
                $extension = $file->getClientOriginalExtension();
                $filename = $file->getClientOriginalName();
                $file_attachment = public_path('admin/emails/attachments/');
                $file->move($file_attachment,$filename);
                $attachment['name'] = $filename;
                $attachment['path'] = public_path('admin/emails/attachments/').'/'.$filename;
                $attachment['extension'] = $extension;
            }
//            dd($attachment);


            $this->singleEmail($recipient,$subject,$from,$message,$attachment);
            return redirect()->back()->with('success',"Mail has been successfully sent.");
        }
    }

    public function bulkIndex() {
        $this->check_access('Send Email');
        return view('admin.administrator.configuration.email.bulk-send',$this->data);
    }

    public function bulkSave() {
        $this->check_access('Send Email');
        $v = Validator::make(Input::all(), [
            'recipient.*' => 'required',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);

        $v->setAttributeNames([
            'recipient.*' => "Recipient field is required",
            'subject' => "Subject field is required",
            'message' => "Message field is required",
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        } else {
            $recipient = Input::get("recipient");
            $subject = escape(Input::get("subject"));
            $from = Auth::user()->email;
            $message = Input::get("message");
            $file = Input::file('attachment');

            $attachment = [];
            if($file != '')
            {
                $extension = $file->getClientOriginalExtension();
                $filename = $file->getClientOriginalName();
                $file_attachment = public_path('admin/emails/attachments/');
                $file->move($file_attachment,$filename);
                $attachment['name'] = $filename;
//                $attachment['path'] = asset('admin/emails/attachments').'/'.$filename;
                $attachment['path'] = public_path('admin/emails/attachments/').'/'.$filename;
                $attachment['extension'] = $extension;
            }
            $this->bulkEmail($recipient,$subject,$from,$message,$attachment);
            return redirect()->back()->with('success',"Mass Mailing has been successfully carried out.");
        }
    }

}
