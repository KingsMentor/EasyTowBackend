<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 24 Nov 2017 10:49:55 +0000.
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ApiLog
 *
 * @property int $id
 * @property string $url
 * @property string $method
 * @property string $data_param
 * @property string $response
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class ApiLog extends Model
{
    protected $fillable = [
        'url',
        'method',
        'data_param',
        'response'
    ];
}
