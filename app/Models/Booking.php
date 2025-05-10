<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function unavailables()
    {
        return $this->hasMany(Unavailable::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
