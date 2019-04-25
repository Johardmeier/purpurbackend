<?php
/**
 * Created by IntelliJ IDEA.
 * User: Johannes
 * Date: 08.12.2018
 * Time: 14:54
 */

use App\PerformanceType;
use App\Performance;
use App\Play;

class PerformanceTableSeeder extends BaseSeeder
{
    private const firstDate = '01.10.2018';
    private const lastDate = '01.05.2019';
    private const maxPerformanceCount = 8;
    private const standardPerformanceType ='Nachmittagsvorstellung';

    private $performanceTypeVars=[
        //value,active,remarks
        ['value'=>self::standardPerformanceType],
        ['value'=>'Schulvorstellung'],
        ['value'=>'Externe Veranstaltung'],
    ];

    private $firstPerformanceWeekday=['wednesday','saturday','sunday'];
    private $standardPerformanceType;

    private function createPerformanceTypes(){
        foreach($this->performanceTypeVars as $type) {
            //$type['password']=Hash::make($user['password']);
            PerformanceType::create($type);
        }
        $this->standardPerformanceType=PerformanceType::where('value','=',self::standardPerformanceType)->first();
        return PerformanceType::all();
    }

    private function getPerformanceTime(dateTime $date) {
        $quarterHour=$this->faker->numberBetween(32,74);
        if ($quarterHour>45) { //no show from 11:30 to 13:30
            $quarterHour+=8;
        }
        $date->setTime(($quarterHour/4),($quarterHour%4)*15);
        return $date;
    }

    private function getPerformanceType(){
        return $this->faker->optional(
            $weight = 0.2,
            $default = $this->standardPerformanceType
        )->passthrough(PerformanceType::all()->random()->first());
    }


    public function run(){
        Performance::query()->delete();
        PerformanceType::query()->delete();

        $this->createPerformanceTypes();
        $plays=Play::all();
        $date=DateTime::createFromFormat('d.m.Y',self::firstDate);

        foreach($plays as $play){
            $perfCount=$this->faker->biasedNumberBetween(1,self::maxPerformanceCount);
            $date->modify('next '.$this->faker->randomElement($this->firstPerformanceWeekday));

            for ($i=0;$i<$perfCount;$i++) {
                Performance::create(
                    [
                        'play_id' => $play->id,
                        'date_time' => $this->getPerformanceTime($date),
                    ]
                )->performanceType()->associate($this->getPerformanceType())
                ->play()->associate($play)
                ->push();

                $date->modify($this->faker->numberBetween(1,5).' days');
            }
            $date->modify('-'.$this->faker->numberBetween(0,15).' days');
        }
    }
}


