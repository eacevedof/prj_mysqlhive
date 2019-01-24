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
    
    public function test_compare()
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

    
}//DateTest