<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessLevel extends Model
{
    protected $table = "ad_access_leves";

    protected $fillable = [
        'id',
        'name',
        'mod_financial',
        'mod_client',
        'mod_user',
        'mod_product',
        'mod_service',
        'mod_plan',
        'mod_report',
        'mod_config',
        'access_type',
        'status',
    ];

}
