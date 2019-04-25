<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingAgent extends BaseModelClass
{
    protected $fillable = [
        'name', 'active',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
