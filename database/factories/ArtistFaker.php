<?php
/**
 * Created by IntelliJ IDEA.
 * User: Johannes
 * Date: 08.12.2018
 * Time: 14:33
 */

use Faker\Provider\Base;


class ArtistFaker extends \Faker\Provider\Base {

    private $names = ['Jörg Bohn','Thomy Truttmann'];

    public function artistName()
    {
        $name=randomElement($names);
        return $name;
    }

}