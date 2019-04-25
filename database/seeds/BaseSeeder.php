<?php
/**
 * Created by IntelliJ IDEA.
 * User: Johannes
 * Date: 14.12.2018
 * Time: 14:15
 */

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class BaseSeeder extends Seeder
{
    private const FAKER_SEED=9775; //Keep getting the same results

    protected $faker;
    //protected $populator;

    public function __construct(string $language='de_CH')
    {
        $this->faker = Faker\Factory::create($language);
        $this->faker->seed(self::FAKER_SEED);
    }

    protected function attachRelatedModel(Model $item, array $seedRelation)
    {
        foreach ($seedRelation as $relationField => $relationKey) {
            $relatedClass = $item->{$relationField}()->getRelated();
            $relatedObject = $relatedClass::where('name', $relationKey)->first();
            if (!$relatedObject) {
                $relatedObject = $relatedClass::create(['name' => $relationKey]);
                $this->command->warn(
                    sprintf(
                        '%1$s: %2$s not found in %3$s. Created New Entry in table %3$s',
                        get_class($item),
                        $relationKey,
                        get_class($relatedClass)
                    )
                );
            }
            $item->{$relationField}()->associate($relatedObject);
        }
    }

    protected function createAttached($modelClass, array $seederItems)
    {
        foreach ($seederItems as $seedItem) {
            $item = new $modelClass;
            $item->fill(array_key_exists('item', $seedItem)?$seedItem['item']:$seedItem);

            if (array_key_exists('relation', $seedItem)) {
                $this->attachRelatedModel($item, $seedItem['relation']);
            }
            $item->push();
        }
    }
}
