<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriverTopic extends Model
{
    public $table = "driver_topics";

    public $fillable = ['driver_id','topic_id'];
}
