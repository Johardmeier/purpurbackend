<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayPricestructure extends BaseModelClass
{

    protected $fillable=['name','adult_price','junior_price','remarks','active'];


    public function plays()
    {
        return $this->hasMany(Play::class);
    }

    public function PlayPricediscountAdult()
    {
        return $this->hasMany(PlayPricediscountAdult::class,"pricestructure_id");
    }

    public function PlayPricediscountJunior()
    {
        return $this->hasMany(PlayPricediscountJunior::class,"pricestructure_id");
    }

    public function PlayPricediscountGroup()
    {
        return $this->hasMany(PlayPricediscountGroup::class,"pricestructure_id");
    }

}

