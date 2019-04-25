<?php
/**
 * Created by IntelliJ IDEA.
 * User: Johannes
 * Date: 13.12.2018
 * Time: 11:09
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayCapacityrow extends BaseModelClass
{
    protected $fillable = [
        'adults', 'juniors','description',
    ];

    public function play_capacity()
    {
        return $this->belongsTo(PlayCapacity::class);
    }

}