<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profit extends Model
{
    protected $fillable = [
        'amount',
        'month',
        'year',
        'business_name',
    ];
}