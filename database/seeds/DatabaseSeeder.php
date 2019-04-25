<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Model::unguard();
        $this->call(UsersTableSeeder::class);
        $this->call(PlaysTableSeeder::class);
        $this->call(PerformanceTableSeeder::class);
        //Model::reguard();
    }
}
