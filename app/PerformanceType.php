<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerformanceType extends BaseModelClass
{
    protected $fillable = [
        'value','remarks','active'
    ];

    public function performances()
    {
        return $this->hasMany(Performance::class);
    }

}
