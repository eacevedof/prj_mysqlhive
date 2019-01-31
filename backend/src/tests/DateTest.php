<?php
// en: /<project>/backend 
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests/DateTest.php --color=auto
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests
use PHPUnit\Framework\TestCase;
use TheFramework\Components\ComponentLog;
//use TheFramework\Components\Db\ComponentMysql;

class DateTest extends TestCase
{    
    private function log($mxVar,$sTitle=NULL)
    {
        $oLog = new ComponentLog("logs",__DIR__);
        $oLog->save($mxVar,$sTitle);
    }
    
    public function tes_compare()
    {
        $FECHA_PREVIA = "2018-05-01";
        $FECHA_EJECUCION = "2018-12-31"; 
        
        //http://php.net/manual/en/datetime.formats.relative.php
        $oFechaD = new DateTime($FECHA_EJECUCION);
        $oFechaD->modify("first day of previous month");

        $oFechaH = new DateTime($FECHA_EJECUCION);
        $oFechaH->modify("first day of this month"); 
        
        $oFechaMayo = new DateTime($FECHA_PREVIA);
        $this->log($oFechaMayo,"oFecMayo");
        $this->log($oFechaH,"oFecDec");
        $this->assertEquals(TRUE,($oFechaMayo < $oFechaH));
    }
    
    public function test_compare2months()
    {
        //$FECHA_HOY = date("Y-m-d");
        $FECHA_HOY = date("2018-11-01");
        //http://php.net/manual/en/datetime.formats.relative.php
        $oFechaD = new DateTime($FECHA_HOY);
        $oFechaD->modify("first day of previous month");
        $oFechaD->modify("first day of previous month");

        $oFechaH = new DateTime($FECHA_HOY);
        $oFechaH->modify("first day of this month"); 
        
        $this->log($oFechaD,"oFechaD 2 months");
        $this->log($oFechaH,"oFechaH first of this month");
        
        print_r($oFechaD);
        print_r($oFechaH);
        $this->assertEquals(TRUE,($oFechaD < $oFechaH));
    }    

    public function tes_loop()
    {
        $FECHA_PREVIA = "2018-01-05";
        $FECHA_EJECUCION = "2019-12-31";
        
        $oFechaD = new DateTime($FECHA_PREVIA);
        $oFechaD->modify("first day of previous month");

        $oFechaH = new DateTime($FECHA_EJECUCION);
        $oFechaH->modify("first day of this month");         
        
        $this->log($oFechaD,"oFechaD");
        $this->log($oFechaH,"oFechaH");
        
        while($oFechaD < $oFechaH) {
            $oInterval = new DateInterval("P1M");
            //$oInterval = new DateInterval("P1d");
            $oFechaD->add($oInterval);
            $this->log($oFechaD,"oInterval - P1M");
        }
        
        $this->assertEquals(TRUE,($oFechaD === $oFechaH));
    }
    
}//DateTest