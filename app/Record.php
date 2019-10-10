<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $table = 'records';
    protected $fillable = [
        'first_name', 'last_name', 'current_city', 'current_state', 'phone_no', 'email', 'middle_name', 'policy_number','loss_date','claim_number' ,'current_street', 'current_zip', 'old_street', 'old_city','old_state', 'old_zip', 'dob', 'current_emp',
        'line_of_business', 'claim_desc', 'AddedBy'
    ];
}