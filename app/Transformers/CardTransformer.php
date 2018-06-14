<?php
/**
 * Created by PhpStorm.
 * User: gem
 * Date: 7/13/17
 * Time: 5:35 PM
 */

namespace App\Transformers;



use App\Card;
use App\Driver;
use App\User;
use  \League\Fractal\TransformerAbstract;

class CardTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Card $card)
    {
        return [
            'id' =>  $card->id,
            'card_no' => $card->card_no,
            'default' => $card->default
        ];
    }

    public function collect($collection)
    {
        $transformer = new CardTransformer();
        return collect($collection)->map(function ($model) use ($transformer) {
            return $transformer->transform($model);
        });
    }

}