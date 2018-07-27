<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TruckCategory extends Model
{
    public $table = "truck_categories";


    public function category(){
        return $this->belongsTo(TruckCategoryType::class, 'type_id','id');
    }
}
