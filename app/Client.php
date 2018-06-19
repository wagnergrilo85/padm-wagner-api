<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = "ad_clients";

    protected $fillable = [
        'id',
        'name',
        'document_type',
        'document',
        'address',
        'city_id',
        'state_id',
        'zip_code',
        'complement',
        'im',
        'ie',
        'rg',
        'number',
        'email',
        'site',
        'telephone',
        'cellphone',
        'fax',
        'group_id',
        'category_client',
        'branch_activity',
        'status',
    ];
}
