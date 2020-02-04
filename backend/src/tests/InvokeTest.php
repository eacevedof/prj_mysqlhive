<?php
// en: /<project>/backend 
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests/InvokeTest.php --color=auto
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests
use PHPUnit\Framework\TestCase;
use TheFramework\Components\ComponentLog;

class Obj 
{
    
}

function get_requestobj($string)
{
    return new Obj($string);
}

class MyInvoke
{
    public function __invoke($objreq,$objresp, callable $objinvoke)
    {
        switch ($objreq) 
        {
            case "/":
                $objresp = get_requestobj("c.index()");
            break;
        
            case "/page":
                $objresp = get_requestobj("c.page()");
            break;
        
            default:
                $objresp = get_requestobj("c.404()");
            break;
        }
        
        return $objinvoke($objreq,$objresp);
    }
}

class InvokeTest extends TestCase
{    
    private function log($mxVar,$sTitle=NULL)
    {
        $oLog = new ComponentLog("logs",__DIR__);
        $oLog->save($mxVar,$sTitle);
        if($sTitle) print_r("\n$sTitle\n");
        print_r("\n$mxVar\n");
    }
    
    public function __invoke() {
        $this->log("this.invoke called");
    }
    
    private function caller(callable $objinv)
    {
        $this->log("this.caller called");
        $objreq = new Obj();
        $objresp = new Obj();
        
        $objinv($objreq, $objresp, $this);
        return "end";
    }
    
    public function test_invokecall()
    {
        $omyinv = new MyInvoke();
        $r = $this->caller($omyinv);
        $this->assertEquals(TRUE, is_string($r));
    }  
    
}//InvokeTest