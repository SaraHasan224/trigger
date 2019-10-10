<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'states';
    protected $fillable = ['name', 'country_id', 'AddedBy'];


    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }
}
