<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayCapacity extends BaseModelClass
{
    protected $table = 'play_capacities';
    protected $fillable = [
        'name', 'remarks','active'
    ];

    public function plays()
    {
        return $this->hasMany(Play::class);
    }

    public function rows()
    {
        return $this->hasMany(PlayCapacityrow::class);
    }
}
