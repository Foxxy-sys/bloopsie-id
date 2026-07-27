<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HappyMailItem extends Model
{
    protected $fillable = [
        'happy_mail_id',
        'product_id',
        'quantity',
    ];
}
