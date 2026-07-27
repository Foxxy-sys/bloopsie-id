<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'theme',
        'month',
        'year',
        'banner',
        'description',
        'status',
    ];
    protected $casts = [
        'month' => 'integer',
    ];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
