<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Malhal\Geographical\Geographical;

class Driver extends Authenticatable
{
    use Notifiable;
    use Geographical;
    protected static $kilometers = true;

    public $guarded = [];

    public function vehicle(){
        return $this->hasOne(Vehicle::class, 'vehicle_id','id');
    }

}
