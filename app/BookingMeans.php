<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingMeans extends BaseModelClass
{
    protected $table = 'lu_bookingmeans';
    protected $fillable = [
        'value',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
