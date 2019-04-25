<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Performance extends BaseModelClass
{
    protected $fillable = [
        'date_time', 'additional_webpage_message','remarks','play_id'
    ];

    public function play()
    {
        return $this->belongsTo(Play::class);
    }

    public function divergingPricestructure()
    {
        return $this->belongsTo(PlayPricestructure::class);
    }

    public function divergingCapacity()
    {
        return $this->belongsTo(PlayCapacity::class);
    }

    public function performanceType()
    {
        return $this->belongsTo(PerformanceType::class);
    }
}
