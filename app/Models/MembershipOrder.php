<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipOrder extends Model
{
    protected $fillable = [
        'user_id',
        'membership_id',
        'invoice',
        'price',
        'payment_method',
        'payment_status',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}
