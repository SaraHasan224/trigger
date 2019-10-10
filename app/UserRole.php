<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserRole extends Model {
	
	protected $table = 'roles';

    public function getCreatedAtAttribute($timestamp) {
        return (new Carbon($timestamp))->format('d-M-Y h:i A');
    }

    public function getUpdatedAtAttribute($timestamp) {
        return (new Carbon($timestamp))->format('d-M-Y h:i A');
    }
}
