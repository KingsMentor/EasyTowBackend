<?php
/**
 * Created by PhpStorm.
 * User: gem
 * Date: 7/13/17
 * Time: 5:35 PM
 */

namespace App\Transformers;


use App\Address;
use App\Driver;
use App\User;
use be\kunstmaan\multichain\MultichainClient;
use  \League\Fractal\TransformerAbstract;

class DriverTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Driver $user)
    {
        return [
            'id' =>  $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'profile_pic' => $user->profile_pic,
            'phone_no' => $user->phone_no,
            'gps_lat' => $user->gps_lat,
            'gps_lon' => $user->gps_lon
        ];
    }

    public function collect($collection)
    {
        $transformer = new DriverTransformer();
        return collect($collection)->map(function ($model) use ($transformer) {
            return $transformer->transform($model);
        });
    }

}