<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'packages';

    protected $guarded = [];

    protected $appends = [
        'total_price'
    ];

    public function getTotalPriceAttribute()
    {
        return $this->price_per_day * $this->day;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
