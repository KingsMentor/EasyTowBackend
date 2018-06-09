<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class GCMID extends Authenticatable
{
    use Notifiable;

    public $guarded = [];

    public $table  = "gcm_ids";


}
