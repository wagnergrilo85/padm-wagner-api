<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = "ad_states";

    protected $fillable = [
        'id',
        'state',
        'uf',
    ];
}
