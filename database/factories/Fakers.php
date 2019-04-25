<?php
/**
 * Created by IntelliJ IDEA.
 * User: Johannes
 * Date: 17.07.2018
 * Time: 14:01
 */

namespace App\Fakers;
use Slim\Http\Request;
use Slim\Http\Response;


class Fakers
{
    private $vars;
    private $startvars=[
        'playdate_start' => '2018-01-01',
        'playdate_end' => '2019-01-01',
        'firstBookingdateOffsetDays' => 45,
        'maxBookings' => 50,
        'defaultNumberOfPerformances' => 6,
        'cachefile' => 'cache_kasse.ser'
    ];

    public function createPerformances( Request $request, Response $response, $args){
        $perfCount=(array_key_exists('count',$args) ? $args['count']:$this->startvars['defaultNumberOfPerformances']);
        $data=[];
        $date=strtotime($this->startvars['playdate_start']);

        for ($i=0;$i<$perfCount/2;$i++){
            array_push($data, $this->createPerformance($date));
        }
        $date=strtotime('today 10pm');
        array_push($data, $this->createPerformance($date));
        for ($j=$i+1;$j<$perfCount;$j++) {
            $date=rand($date,rand($date,strtotime($this->startvars['playdate_end'])));
            array_push($data, $this->createPerformance($date));
        }
        $this->writeToDisk($data);

        return $response->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson(['result'=>'fake performances created']);
    }

//$app->get('/fakeKasse/performances{
//            $date=rand($date, strtotime('today 01am'));', Fakers::class.':getPerformances');
    public function getPerformances( Request $request, Response $response, $args){
        $data=$this->readFromDisk();
        foreach ($data as &$performance){
            unset($performance['bookings']);
        }

        return $response->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson(['result'=>$data]);
    }

//$app->get('/fakeKasse/bookings/{performanceId}', Fakers::class.':getBookings');
    public function getBookings( Request $request, Response $response, $args){
        $alldata=$this->readFromDisk();
        $performance=$alldata[$args['performanceId']];

        $data=$performance['bookings'];
        return $response->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->withJson(['result'=>$data]);
    }

/* *****************************************************************************/

    protected function writeToDisk($data){
        file_put_contents($this->startvars['cachefile'], serialize($data));
    }

    protected function readFromDisk() {
        $data = unserialize(file_get_contents($this->startvars['cachefile']));
        return $data;
    }

    protected function createPerformance($date) {
        static $index = 0;

        $date = round($date / (15 * 60)) * (15 * 60);  //round to quarter hours

        $index++;
        $adultprice=$this->getRandomNumber(12,35,23,80);
        $childrenprice=$this->getRandomNumber(5, $adultprice,13,80);
        $performance=[
            'id' => $index,
            'title' => $this->plays[$index-1],
            'date' => date('Y-m-d H:i',$date),
            'prices' => [
                'adults' => $adultprice,
                'children' => $childrenprice
            ],
            'discounts' => [
                'adults' => $this->getDiscounts('adult',$adultprice),
                'children' => $this->getDiscounts('child',$childrenprice),
                //'groups' => $this->getGroupDiscounts($adultprice,$childrenprice)
            ]
        ];
        $bookings=$this->internal_getBookings(rand(0,$this->startvars['maxBookings']),$performance);
        $performance['bookings'] = $bookings;

        return $performance;
    }

    protected function internal_getBookings($count, $performance) {
        $myid=0;
        $boo=[];
        $endDate=$performance['date'];
        $bookingDate= strtotime($endDate)-$this->startvars['firstBookingdateOffsetDays']*86400;
        for ( $i=0;$i<=$count;$i++){
            $res=[
                'id'=>$myid+rand(1,13),
                'name'=>$this->surName,
                'forename'=>$this->getForename(rand(0,1))
            ];

            $bo=this.getBookingPart($bookingDate,$res);
            $co=this.getCollectedPart($bookingDate,$res);
            $dep=this.getDepositedPart($bookingDate,$res);

            (count($bo)>0 ? $res['booked']=$bo : null);
            (count($co)>0 ? $res['collected']=$co : null);
            (count($dep)>0 ? $res['deposited']=$dep : null);

            // Add specials

            switch ($this->getRandomNumber(0,10,10,95)) {
                case 0:                                                                            // Booking note: use Invoice
                    $this->markSpecial($bo,'Auf Rechnung');
                    $bo['booked']['invoice']=true;
                    break;
                case 1:                                                                            // Booking note: use Discounts
                    $this->markSpecial($bo,'Rabatt gebucht');
                    $this->mergeSpecial($bo['booked'],$this->createDiscounts($performance));
                    break;
                case 2:                                                                            // Already collected with Discounts
                    $this->markSpecial($bo,'mit Rabatt gekauft');
                    $this->mergeSpecial($bo,'collected',$this->createCollectedDiscount($performance,$bookingDate));
                    break;
                case 3:
                    $this->markSpecial($bo,'regulär gekauft');
                    $this->mergeSpecial($bo,'collected',$this->createCollectedRegular($performance,$bookingDate));
                    break;
                case 4:
                    $this->markSpecial($bo,'hinterlegt: mit Rabatt');
                    $this->mergeSpecial($bo,'deposited',$this->createCollectedDiscount($performance,$bookingDate));
                    break;
                case 5:
                    $this->markSpecial($bo,'hinterlegt: regulär');
                    $this->mergeSpecial($bo,'deposited',$this->createCollectedRegular($performance,$bookingDate));
                    break;
            };
            array_push($boo,$bo);
            $bookingDate=$this->getTopHeavyRandom($bookingDate,strtotime($endDate));
        }
        return $boo;
    }
//--------------------------------------get booking parts
    protected function getBookingPart($bookingDate,$res){
        $bMeans=$this->bookingMean;
        return [
            'adults'=>[
                'regular'=>$this->getRandomSeatCount()
            ],
            'children'=>[
                'regular'=>$this->getRandomSeatCount()
            ],
            'date'=>date('Y-m-d H:i',$bookingDate),
            'means'=>$bMeans,
            'contact'=>$this->getBookingContact($bMeans,$res['name'],$res['forename']),
            'remarks'=>(rand(0,100)>90 ? $this->bookingRemark : '')
        ];
    }

//-----------------------------------------------------------------------------------------


    protected function createCollectedDiscount($performance,$bookingDate){
        $d=date('Y-m-d H:i',$bookingDate+rand(0,3*24*60*60));//TODO:: improve
        return ['date'=>$d, 'agent'=>$this->bookingPerson,'discounted'=>$this->createDiscounts($performance)];
    }

    protected function createCollectedRegular($performance,$bookingDate){
        $d=date('Y-m-d H:i',$bookingDate+rand(0,3*24*60*60));//TODO:: improve
        $ar=[];
        switch ($this->getRandomNumber(0,2,0,0)) {
            case 0:
                $ar= ['adults'=>['count'=>$this->getRandomNumber(1,15,1,80),'price'=>$performance['prices']['adults']]];
                break;
            case 1:
                $ar= ['children'=>['count'=>$this->getRandomNumber(1,15,1,80),'price'=>$performance['prices']['children']]];
                break;
            case 2:
                $ar= ['adults'=>['count'=>$this->getRandomNumber(1,15,1,80),'price'=>$performance['prices']['adults']],
                    'children'=>['count'=>$this->getRandomNumber(1,15,1,80),'price'=>$performance['prices']['children']]];
                break;
        }
        return ['date'=>$d, 'agent'=>$this->bookingPerson,'regular'=>$ar];
    }


    protected function createDiscountsA($discArray){
        $disc=$this->getRandomEntries($discArray);
        $ret=[];
        foreach($disc as $d){
            array_push($ret,['tarif'=>$d['name'],'price'=>$d['price'],'count'=>$this->getRandomNumber(1,15,1,80)]);
        }
        return $ret;
    }

    protected function createDiscounts($performance) {
        $possibleDiscounts=$performance['discounts'];
        switch ($this->getRandomNumber(0,2,0,0)) {
            case 0:
                $ar= ['adults'=>$this->createDiscountsA($possibleDiscounts['adults'])];
                break;
            case 1:
                $ar= ['children'=>$this->createDiscountsA($possibleDiscounts['children'])];
                break;
            case 2:
                $ar= ['adults'=>$this->createDiscountsA($possibleDiscounts['adults']),
                     'children'=>$this->createDiscountsA($possibleDiscounts['children'])];
                break;
        }
        return $ar;
        //TODO:: free Discount with text
    }


    protected function mergeSpecial(&$arr,$key,$merg){
//Oooops wie machemer das?
        $arr=array_replace_recursive($arr[$key],$merg);
    }

    protected function markSpecial(&$arr,$mark){
        $arr['booked']['contact']=$mark;
        $arr['booked']['means']='special';
    }

    protected function getBookingContact($means,$surName,$forename){
        switch ($means) {
            case 'tel':
                return $this->getTelNr();
            case 'mail':
                return $this->getMail($surName, $forename);
            case 'web':
                return (rand(0, 1) == 1 ? $this->getTelNr() : $this->getMail($surName, $forename));
            case 'pers':
                return $this->bookingPerson;
        }
        return $this->otherBookingContact;
    }


    protected function getMail($surName, $forename){
        $a=$this->getOneOf([$forename,$forename[0],'']);
        $b=$this->getOneOf([$surName,$surName[0],'']);
        $con=(($a==='')||($b==='') ? '' : $this->getOneOf(['.','_','']));
        $part1=$a.$con.$b;
        $part2=(strlen($part1)>4 ? $part1.'@'.$this->emailProvider : $this->getOneOf([$this->emailName,$forename]).'@'.$surName.'.'.$this->topLevelDomain);
        return $part2;
    }

    protected function getOneOf($arr){
        return $arr[array_rand($arr)];
    }

    protected function getTelNr(){
        $d=(rand(0,20)>19 ? $this->specialAreaCode : $this->areaCode);
        return $d.$this->getTelNrPart().$this->getTelNrPart().$this->getTelNrPart();
    }

    protected function getTelNrPart(){
        return ' '.rand(0,9).rand(0,9);
    }

    protected function getForename($gender){
        $d=($gender ? 'female':'male').'ForeName';
        return $this->$d;
    }

    protected function getGroupDiscounts($adultPrice,$childrenPrice){
        $arr=$this->group_discounts;
        $res=[];
        foreach ($arr as $nam=>$def) {
            $d=[
                'name'=>$nam,
                'description'=>$def['description'],
                'adults'=>$def['adults'],
                'children'=>$def['children']
                ];
            array_push($res,$d);
        }
        return $res;
    }

    protected function getDiscounts($discount,$originalPrice){
        $d=$discount.'_discounts';
        $arr=$this->$d;
        $res=[];
        foreach ($arr as $k=>$v) {
            $price=round($v*$originalPrice,0,PHP_ROUND_HALF_DOWN);
            array_push($res,['name'=>$k,'price'=>$price]);
        }
        return $res;
    }

    protected function getRandomSeatCount(){
        return    $this->getRandomNumber(
            $this->getRandomNumber(0,2,1,60),
            $this->getRandomNumber(3,20,4,50),
            1,20
        );
    }

    protected function getRandomBoolean($break){
        return (rand(0,100)<$break);
    }

    protected function getTopHeavyRandom($from,$to){
        return rand($from,rand($from,$to));
    }

    protected function getRandomNumber($from, $to, $mostly, $break){
        $tally=rand(0,100);
        if ($tally>$break) {
            return rand($from, $to);
        }
        return $mostly;
    }

    function __construct(){
        require_once ('fakevars.php');
        $this->vars=fakevars();
        $this->index=0;
        $this->result=[];
    }


    protected function getRandomEntry($arr){
        return $arr[array_rand($arr)];
    }

    protected function getRandomEntries($arr){
        $ret=[];
        $count=rand(1,count($arr)-1);
        $newArr=(array)array_rand($arr,$count);
        foreach($newArr as $a){
            $ret[$a]=$arr[$a];
        }
        return $ret;
    }

    /* Magic __get: Returns random member of named array*/

    function __get($prop){
        if (($prop[strlen($prop) - 1] === 's'))
        {
            $s=$this->vars[$prop];
            return $s;
        }
        $s=$this->vars[$prop.'s'];
        return $s[array_rand($s)];
    }

}
