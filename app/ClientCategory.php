<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientCategory extends Model
{
    protected $table = "ad_client_categories";

    protected  $fillable = [
        'id',
        'name',
        'classification',
        'status',
    ];

}
