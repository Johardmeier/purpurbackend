<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayPricediscountJunior extends BaseModelClass
{
    protected $fillable = [
        'name', 'price','remarks'
    ];

    protected $table = 'play_pricediscounts_junior';

    public function PlayPricestructure()
    {
        return $this->belongsTo(PlayPricestructure::class);
    }

}
