<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'base_price',
        'quota',
        'sold',
        'icon',
        'benefits',
        'is_active',
        'is_streaming',
    ];

    protected $casts = [
        'benefits' => 'array',
        'is_active' => 'boolean',
        'is_streaming' => 'boolean',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
