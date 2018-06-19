<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "ad_products";

    protected $fillable = [
        'id',
        'name',
        'description',
        'status',
    ];

}
