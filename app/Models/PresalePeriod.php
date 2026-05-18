<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PresalePeriod extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'discount',
        'badge',
        'starts_at',
        'ends_at',
        'is_active',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
