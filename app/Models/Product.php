<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $guarded = [];

    protected $appends = [
        'total_reviews',
        'is_favorite'
    ];

    public function getThumbAttribute($value): string | null
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

    public function getIsFavoriteAttribute(){
        return auth('api')->check() && Favorite::where('product_id', $this->id)->where('user_id', auth('api')->user()->id)->exists();
    }

    public function getTotalReviewsAttribute(){
        return $this->reviews()->count();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function favorite(){
        return $this->hasMany(Favorite::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }

    public function unavailables()
    {
        return $this->hasMany(Unavailable::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }
    public function measurement()
    {
        return $this->belongsTo(Measurement::class);
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function clothFor()
    {
        return $this->belongsTo(ClothFor::class);
    }
    
}
