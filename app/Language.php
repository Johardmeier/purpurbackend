<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends BaseModelClass
{
    protected $table = 'lu_languages';
    protected $fillable = [
        'name', 'short','active'
    ];

    public function plays()
    {
        return $this->hasMany(Play::class);
    }

}
