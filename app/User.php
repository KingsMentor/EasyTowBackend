<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Authenticatable
{
    use Notifiable;

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
       ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function trucks(){
        return $this->hasMany(Vehicle::class,'user_id','id');
    }

    public function drivers(){
        return $this->hasMany(Driver::class,'user_id','id');
    }

    public function companies(){
        return $this->hasMany(Company::class,'user_id','id');
    }
}
