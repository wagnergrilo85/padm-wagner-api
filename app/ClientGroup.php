<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientGroup extends Model
{
    protected $table = "ad_client_groups";

    protected $fillable = [
        'id',
        'name',
        'classification',
        'created_at',
        'status',
    ];

}
