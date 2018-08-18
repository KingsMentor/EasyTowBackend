<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    public $table = "topics";

    public $fillable = ['name','user_id'];
}
