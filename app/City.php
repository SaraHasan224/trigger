<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';
    protected $fillable = ['name', 'state_id', 'AddedBy'];
    public function state()
    {
        return $this->belongsTo(State::class,'state_id');
    }

}
