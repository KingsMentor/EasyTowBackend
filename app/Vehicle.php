<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{

    public $table = "trucks";
    public $guarded = [];

    public function driver(){
       return $this->belongsTo(Driver::class,'driver_id','id');
    }

    public function category(){
        return $this->belongsTo(TruckCategory::class, 'type_id','id');
    }
}
