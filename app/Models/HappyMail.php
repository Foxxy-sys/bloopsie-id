<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HappyMail extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'month',
        'year',
        'description',
        'cover_image',
    ];

    protected $casts = [
        'month' => 'integer',
    ];
}
