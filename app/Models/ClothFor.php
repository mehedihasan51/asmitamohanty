<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClothFor extends Model
{
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'cloth_for_id');
    }
}
