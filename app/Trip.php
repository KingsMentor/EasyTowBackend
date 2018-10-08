<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    public $table = "trips";

    public $fillable = ['driver_id','user_id','to_gps_lat','to_gps_lng','status','payment_type','from_gps_lat','from_gps_lng','truck_type','tow_type','amount'];
}
