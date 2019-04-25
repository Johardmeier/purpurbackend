<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Play extends BaseModelClass
{
    protected $fillable = [
        'name', 'image', 'description','production_infos','min_age','duration','additional_webpage_message','remarks'
    ];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function pricestructure()
    {
        return $this->belongsTo(PlayPricestructure::class);
    }

    public function capacity()
    {
        return $this->belongsTo(PlayCapacity::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function performances()
    {
        return $this->hasMany(Performance::class);
    }

    //ToDo:: ->withdefault() to belongtos
}
