<?php
/**
 * Created by IntelliJ IDEA.
 * User: Johannes
 * Date: 08.12.2018
 * Time: 14:54
 */

use Illuminate\Database\Eloquent\Model;

class PlaysTableSeeder extends BaseSeeder
{
     public function run(){
        $seedData=require('PlaySeedData.php');
        foreach($seedData as $seedClass => $seedItemsArray){
            $this->command->info('...'.$seedClass);
            $this->createAttached('App\\'.$seedClass, $seedItemsArray);
        }
    }
}