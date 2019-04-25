<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayPricediscountGroup extends BaseModelClass
{
    protected $fillable = [
        'name', 'formula','remarks'
    ];

    protected $table = 'play_pricediscounts_group';

    public function PlayPricestructure()
    {
        return $this->belongsTo(PlayPricestructure::class);
    }

}
