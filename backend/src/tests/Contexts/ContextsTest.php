<?php
// en: /<project>/backend 
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests/Contexts/ContextsTest.php --color=auto
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests
use PHPUnit\Framework\TestCase;
use TheFramework\Components\ComponentLog;
use TheFramework\Components\Db\Context\ComponentContext;

class ContextsTest extends TestCase
{    
    private function log($mxVar,$sTitle=NULL)
    {
        $oLog = new ComponentLog("logs",__DIR__);
        $oLog->save($mxVar,$sTitle);
    }
    
    public function test_get_context()
    {
        $oComp = new ComponentContext();
        $arConfig = $oComp->get_config();
        print_r($arConfig);
        $this->assertEquals(TRUE,is_array($arConfig));
    }



    
}//ContextsTest