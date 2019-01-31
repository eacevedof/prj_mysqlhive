<?php
// en: /<project>/backend 
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests/ArrayTest.php --color=auto
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests
use PHPUnit\Framework\TestCase;
use TheFramework\Components\ComponentLog;
//use TheFramework\Components\Db\ComponentMysql;

class ArrayTest extends TestCase
{    
    private function log($mxVar,$sTitle=NULL)
    {
        $oLog = new ComponentLog("logs",__DIR__);
        $oLog->save($mxVar,$sTitle);
    }
    
    public function test_array_shuffle()
    {
        $arOrig = [
            "r1" => ["field1"=>"val-11","field2"=>"val-12","field3"=>"val-13"],
            "r2" => ["field1"=>"val-21","field2"=>"val-22","field3"=>"val-23"],
            "r3" => ["field1"=>"val-31","field2"=>"val-32","field3"=>"val-33"],
            "r4" => ["field1"=>"val-41","field2"=>"val-42","field3"=>"val-43"],
            "r5" => ["field1"=>"val-51","field2"=>"val-52","field3"=>"val-53"]
        ];
        $iCountO = count($arOrig);
        $this->log($arOrig,"arOrig $iCountO");
        
        shuffle($arOrig);
        $iCountSh = count($arOrig);
        $this->log($arOrig,"shuffled1 $iCountSh");
        
        shuffle($arOrig);
        $iCountSh = count($arOrig);
        $this->log($arOrig,"shuffled2 $iCountSh");     
        
        $this->assertEquals(TRUE,(is_array($arOrig) && ($iCountO === $iCountSh)));
    }


    
}//ArrayTest