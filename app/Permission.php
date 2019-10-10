<?php
/**
 * Created by PhpStorm.
 * User: Azeem
 * Date: 12-Nov-18
 * Time: 8:04 PM
 */
namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Permission extends Model {

    protected $table = 'permissions';

	public function getCreatedAtAttribute($timestamp) {
		return (new Carbon($timestamp))->format('d-M-Y h:i A');
	}

	public function getUpdatedAtAttribute($timestamp) {
		return (new Carbon($timestamp))->format('d-M-Y h:i A');
	}
}