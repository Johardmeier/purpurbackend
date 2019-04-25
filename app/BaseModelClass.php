<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModelClass extends Model
{
    protected $preventTouch=['active'];

    public function save(array $options = [])
    {
        $needsUpdate=array_diff(
            array_keys($this->getDirty()),
            $this->preventTouch
        );
        $this->timestamps = count($needsUpdate) > 0;

        parent::save($options);
    }
}
