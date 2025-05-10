<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{
    protected $guarded = [];


    protected $appends = [
        'short_content',
        'humanize_date',
        'is_like',
        'reaches_count',
        'comments_count',
    ];


    public function getImageAttribute($value): string | null
    {
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }
        // Check if the request is an API request
        if (request()->is('api/*') && !empty($value)) {
            // Return the full URL for API requests
            return url($value);
        }

        // Return only the path for web requests
        return $value;
    }

    public function getIsLikeAttribute(){
        if (request()->is('api/*') && !empty($value)) {
            return Reach::where('reachable_id', $this->id)->where('user_id', auth('api')->user()->id)->where('reachable_type', self::class)->exists();
        }
        return false;
    }

    public function getReachesCountAttribute(){
        return Reach::where('reachable_id', $this->id)->where('reachable_type', self::class)->count();
    }

    public function getCommentsCountAttribute(){
        return Comment::where('post_id', $this->id)->where('parent_id', null)->count();
    }

    public function getHumanizeDateAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    public function getShortContentAttribute(): string
    {
        return substr($this->content, 0, 100);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reaches(): MorphMany
    {
        return $this->morphMany(Reach::class, 'reachable');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
