<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkbenchResultDetail extends Model
{
    protected $fillable = ['workbench__results_id','type'];
}
