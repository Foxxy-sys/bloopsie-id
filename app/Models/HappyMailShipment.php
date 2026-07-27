<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HappyMailShipment extends Model
{
    protected $fillable = [
        'membership_order_id',
        'happy_mail_id',
        'address_id',
        'tracking_number',
        'courier',
        'status',
        'shipped_at',
        'delivered_at',
    ];

    protected $casts = [
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];
}
