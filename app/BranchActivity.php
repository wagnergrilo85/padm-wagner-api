<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchActivity extends Model
{
    protected $table = "ad_branch_activities";

    protected $fillable = [
        'id',
        'name',
        'classification',
        'status',
    ];
}


