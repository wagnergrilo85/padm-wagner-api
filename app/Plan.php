<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = "ad_plans";

    protected $fillable = [
        'id',
        'name',
        'description',
        'status',
        'product_id',
        'monthly_price',
        'annual_price',
        'quarterly_price',
        'semi_annual_price',
        'select_period',
        'due_date',
        'date_hiring',
        'days_of_suspension',
    ];

}
