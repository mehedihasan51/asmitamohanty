<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];

    protected $appends = [
        'metadata_json'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function getMetadataJsonAttribute()
    {
        $metadata = json_decode($this->metadata, true);
        $customer = isset($metadata['customer_id']) ? User::find($metadata['customer_id']) : null;
        $owner = isset($metadata['owner_id']) ? User::find($metadata['owner_id']) : null;
        $product = isset($metadata['product_id']) ? Product::find($metadata['product_id']) : null;
        $booking = isset($metadata['booking_id']) ? Booking::find($metadata['booking_id']) : null;

        return [
            'customer' => $customer,
            'owner' => $owner,
            'product' => $product,
            'booking' => $booking,
        ];
    }

}
