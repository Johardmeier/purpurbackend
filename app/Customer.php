<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends BaseModelClass
{
    protected $fillable = [
        'name', 'forename','address','city','area_code','email','phone','mobile','remarks',
    ];

    public function bookings(){
        return $this->hasMany(Booking::class);
    }

}
