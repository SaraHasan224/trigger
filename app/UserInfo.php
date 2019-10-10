<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    //
    protected $fillable = [
                            'user_id',
                            'holder_name',
                            'acc_num',
                            'iban_num',
                            'bank_name',
                            'bank_code',
                            'dc_name',
                            'dc_num',
                            'dc_exp',
                            'd_cvv',
                            'cc_name',
                            'cc_num',
                            'cc_exp',
                            'c_cvv',
                          ];
}
