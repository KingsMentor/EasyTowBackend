<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    public $guarded = [];

    public function driver(){
       return $this->belongsTo(Driver::class,'driver_id','id');
    }
}
