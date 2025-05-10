<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // person being followed
    }

    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id'); // the follower
    }
}
