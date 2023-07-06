<?php

namespace Modules\Shipping\Services\BlueDart;


use Illuminate\Database\Eloquent\Model;

class Bluedartlog extends Model
{
    protected $table = 'bluedartlogs';

    protected $fillable = [
        'request','response','errormesssage'
    ];

}
