<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use DatabaseSeeder as seeder;
//use Gate;
//use Illuminate\Http\Request;

class SeedController extends BaseController
{

    public function DatabaseSeeder()
    {
        $this->authorize('hasPermission','delete');
        $mySeeder=new seeder();
        $mySeeder->run();
        return 'seeded';
    }
}
