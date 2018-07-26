<?php
/**
 * Created by PhpStorm.
 * User: gem
 * Date: 7/13/17
 * Time: 5:35 PM
 */

namespace App\Transformers;


use App\Address;
use App\User;
use App\Vehicle;
use be\kunstmaan\multichain\MultichainClient;
use  \League\Fractal\TransformerAbstract;

class VehicleTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Vehicle $vehicle)
    {
        return [
            'id' =>  $vehicle->id,
            'name' => $vehicle->manufacturer,
            'plate_no' => $vehicle->plate_no,
            'type' => $vehicle->type,
            'default' => ($vehicle->default == 0) ? true : false
        ];
    }

    public function collect($collection)
    {
        $transformer = new VehicleTransformer();
        return collect($collection)->map(function ($model) use ($transformer) {
            return $transformer->transform($model);
        });
    }

}