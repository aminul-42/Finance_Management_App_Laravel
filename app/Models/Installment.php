<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'payment_month',
        'payment_year',
        'payment_date',
        'payment_method',
        'transaction_id',
        'status',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'status' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}