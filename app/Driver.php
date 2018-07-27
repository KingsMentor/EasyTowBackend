<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Geographical;

class Driver extends Model
{
    use Notifiable;

    protected static $kilometers = true;

    public $guarded = [];

    public function truck(){
        return $this->hasOne(Vehicle::class, 'vehicle_id','id');
    }

}
