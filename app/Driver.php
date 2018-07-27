<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Malhal\Geographical\Geographical;

class Driver extends Authenticatable
{
    use Notifiable;

    protected static $kilometers = true;

    public $guarded = [];

    public function truck(){
        return $this->hasOne(Vehicle::class, 'vehicle_id','id');
    }

}
