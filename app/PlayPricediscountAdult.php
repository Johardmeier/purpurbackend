<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayPricediscountAdult extends BaseModelClass
{
    protected $table = 'play_pricediscounts_adult';
    protected $fillable = [
        'name', 'price','remarks'
    ];

    public function PlayPricestructure()
    {
        return $this->belongsTo(PlayPricestructure::class);
    }

}
