<?php
/**
 * Created by IntelliJ IDEA.
 * User: Johannes
 * Date: 08.12.2018
 * Time: 14:33
 */

class PlayFaker extends \Faker\Provider\Base {
    public function playTitle()
    {
        $title='myPlay';
        return $title;
    }

}