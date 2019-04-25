<?php

namespace App;

class Artist extends BaseModelClass
{
    protected $fillable = ['active','name','url'];

    public function plays(){
        return $this->hasMany(Play::class);
    }
}
