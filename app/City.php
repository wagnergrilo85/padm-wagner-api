<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = "ad_cities";

    protected $fillable = [
        'id',
        'city',
        'code',
        'uf',
        'status',
    ];

}
