<?php
/**
 * Created by IntelliJ IDEA.
 * User: Johannes
 * Date: 12.12.2018
 * Time: 09:56
 */

    return [
    'PlayPricestructure'=>[
        ['name'=>'Standard','adult_price'=>23,'junior_price'=>13,'remarks'=>'Normale Preise ab 2014'],
        ['name'=>'Lesung','adult_price'=>18,'junior_price'=>8],
        ['name'=>'Festival','adult_price'=>0,'junior_price'=>0],
        ['name'=>'Extern','adult_price'=>30,'junior_price'=>16],
    ],
    'PlayPricediscountAdult'=>[
        ['item'=>['name'=>'AHV','price'=>15],'relation'=>['pricestructure'=>'Standard']],
        ['item'=>['name'=>'AHV','price'=>15],'relation'=>['pricestructure'=>'Lesung']],
        ['item'=>['name'=>'Mitglied TV','price'=>21],'relation'=>['pricestructure'=>'Standard']],
        ['item'=>['name'=>'AHV','price'=>15],'relation'=>['pricestructure'=>'Extern']],
    ],
    'PlayPricediscountJunior'=>[
        ['item'=>['name'=>'Kurskind','price'=>8],'relation'=>['pricestructure'=>'Standard']],
        ['item'=>['name'=>'Kurskind','price'=>5],'relation'=>['pricestructure'=>'Lesung']],
        ['item'=>['name'=>'Mitglied TV','price'=>5],'relation'=>['pricestructure'=>'Standard']],
        ['item'=>['name'=>'Kurskind','price'=>12],'relation'=>['pricestructure'=>'Extern']],
    ],
    'PlayPricediscountGroup'=>[
        ['item'=>['name'=>'Hort','formula'=>'To be created'],'relation'=>['pricestructure'=>'Standard']],
    ],
    'PlayCapacity'=>[
        ['name'=>'Standard'],
        ['name'=>'Ohne Gradin'],
        ['name'=>'Reduziert'],
    ],
    'PlayCapacityrow'=>[
        ['item'=>['adults'=>10,'juniors'=>10],'relation'=>['play_capacity'=>'Standard']],
        ['item'=>['adults'=>10,'juniors'=>10],'relation'=>['play_capacity'=>'Standard']],
        ['item'=>['adults'=>11,'juniors'=>15],'relation'=>['play_capacity'=>'Standard']],
        ['item'=>['adults'=>11,'juniors'=>15],'relation'=>['play_capacity'=>'Standard']],
        ['item'=>['adults'=>10,'juniors'=>15],'relation'=>['play_capacity'=>'Standard']],
        ['item'=>['adults'=>10,'juniors'=>15],'relation'=>['play_capacity'=>'Standard']],
        ['item'=>['adults'=>12,'juniors'=>12],'relation'=>['play_capacity'=>'Ohne Gradin']],
        ['item'=>['adults'=>12,'juniors'=>12],'relation'=>['play_capacity'=>'Ohne Gradin']],
        ['item'=>['adults'=>12,'juniors'=>12],'relation'=>['play_capacity'=>'Ohne Gradin']],
        ['item'=>['adults'=>12,'juniors'=>12],'relation'=>['play_capacity'=>'Ohne Gradin']],
        ['item'=>['adults'=>12,'juniors'=>12],'relation'=>['play_capacity'=>'Ohne Gradin']],
        ['item'=>['adults'=>12,'juniors'=>19],'relation'=>['play_capacity'=>'Ohne Gradin']],
        ['item'=>['adults'=>12,'juniors'=>19],'relation'=>['play_capacity'=>'Ohne Gradin']],
        ['item'=>['adults'=>12,'juniors'=>19],'relation'=>['play_capacity'=>'Ohne Gradin']],
        ['item'=>['adults'=>10,'juniors'=>15],'relation'=>['play_capacity'=>'Reduziert']],
        ['item'=>['adults'=>10,'juniors'=>15],'relation'=>['play_capacity'=>'Reduziert']],
        ['item'=>['adults'=>10,'juniors'=>15],'relation'=>['play_capacity'=>'Reduziert']],
        ['item'=>['adults'=>10,'juniors'=>15],'relation'=>['play_capacity'=>'Reduziert']],
    ],
    'Artist'=>[
        ['name'=>'Jörg Bohn', 'url'=>'joergbohn.ch'],
        ['name'=>'Kathrin Leuenberger', 'url'=>'figurentheaterlupine.ch'],
        ['name'=>'Fallalpha', 'url'=>'fallalpha.ch'],
        ['name'=>'Peter Rinderknecht', 'url'=>'peterrinderknecht.ch'],
        ['name'=>'Theater-Pack', 'url'=>'theaterpack.ch'],
        ['name'=>'Ond drom', 'url'=>''],
        ['name'=>'Florschütz & Döhnert', 'url'=>'florschuetz-doehnert.de'],
        ['name'=>'Thomy Truttmann', 'url'=>'thomytruttmann.ch'],
        ['name'=>'Roos und Humbel', 'url'=>'roosundhumbel.ch']
    ],
    'Language'=>[
        ['name'=>'Mundart', 'short'=>'ch'],
        ['name'=>'Hochdeutsch', 'short'=>'de'],
        ['name'=>'Französisch', 'short'=>'frz'],
        ['name'=>'Ohne Worte', 'short'=>'keine'],
    ],
    'Play'=>[
        ['item'=>['name' => 'Frau Meier, die Amsel'],
         'relation'=>['artist' => 'Kathrin Leuenberger','pricestructure'=> 'Standard','capacity'=>'Standard', 'language'=>'Mundart']],
        ['item'=>['name' => 'Bruno aus Bovolino'],
         'relation'=>['artist' => 'Jörg Bohn','pricestructure'=> 'Standard']],
        ['item'=>['name' => 'Dickhäuter'],
         'relation'=>['artist' => 'Fallalpha','pricestructure'=> 'Standard']],
        ['item'=>['name' => 'Schaf'],
         'relation'=>['artist' => 'Peter Rinderknecht','pricestructure'=> 'Extern']],
        ['item'=>['name' => 'Zipp Zapp'],
         'relation'=>['artist' => 'Fallalpha','pricestructure'=> 'Festival']],
        ['item'=>['name' => 'Der Atlantikflug'],
         'relation'=>['artist' => 'Theater-Pack','pricestructure'=> 'Standard']],
        ['item'=>['name' => 'Schmetterlinge im Bauch'],
         'relation'=>['artist' => 'Ond drom','pricestructure'=> 'Standard']],
        ['item'=>['name' => 'Sssst...'],
         'relation'=>['artist' => 'Florschütz & Döhnert','pricestructure'=> 'Standard']],
        ['item'=>['name' => 'Der kleine Riese Stanislav'],
         'relation'=>['artist' => 'Kathrin Leuenberger','pricestructure'=> 'Standard']],
        ['item'=>['name' => 'Örjan'],
         'relation'=>['artist' => 'Thomy Truttmann','pricestructure'=> 'Standard']],
        ['item'=>['name' => 'Das Güggelei'],
         'relation'=>['artist' => 'Thomy Truttmann','pricestructure'=> 'Standard']
        ],
     ]
];
