<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workbench_Result extends Model
{
    protected $fillable = ['workbench_id','response','result','source_options_id','score','type'];
}
