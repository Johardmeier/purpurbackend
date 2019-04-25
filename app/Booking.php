<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends BaseModelClass
{
    protected $fillable = [
        'remarks', 'processed',
    ];

    public function performance()
    {
        return $this->belongsTo(Performance::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function booking_agent()
    {
        return $this->belongsTo(BookingAgent::class);
    }

    public function booking_means()
    {
        return $this->belongsTo(BookingMeans::class);
    }

    //Calculated
    /*
    public function play()
    {
        return $this->performance()->play();
    }
*/
}
