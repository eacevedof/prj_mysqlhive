<?php
// en: /<project>/backend 
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests/StringTest.php --color=auto
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests
use PHPUnit\Framework\TestCase;
use TheFramework\Components\ComponentLog;

class StringTest extends TestCase
{    
    private function log($mxVar,$sTitle=NULL)
    {
        $oLog = new ComponentLog("logs",__DIR__);
        $oLog->save($mxVar,$sTitle);
    }
    
    public function test_str_ireplace()
    {
        $string = "where 1=1  and cdr_fecha>=? and cdr_fecha<? and cdr_numero_publico = ? and stats.operador_saliente_id not in ('481','482','522','562','567')"
                . " esto es más texto in() fin de linea and otro_campo in (a,b,c)";
        //$string = "where 1=1  and cdr_fecha>=? and cdr_fecha<? and cdr_numero_publico = ? "
        //        . "and stats.operador_saliente_id not in ('481','482','522','562','567','589','590','619','636','642','645','647','648','656','660','665','699','709','714','717','743','751','774','782','801','814','836','837','838')";    
        
        print_r("\n\n");
        print_r($string);
        
        //$changed = str_ireplace("and stats.operador_saliente_id  not in  (?)","and coalesce(cdr_numeroc_tarifa_id,0) not in (".implode(',',[1,2,3,4,5]).")",$string);
        //print_r("\n\n");
        //print_r($changed);
/*
$cadena = 'Abril 15, 2003';
$patrón = '/(\w+) (\d+), (\d+)/i';
$sustitución = '${1}1,$3';
echo preg_replace($patrón, $sustitución, $cadena);
*/       
        $rep = "and coalesce(cdr_numeroc_tarifa_id,0) not in (".implode(',',[1,2,3,4,5]).")";
        $changed2 = preg_replace("/and stats.operador_saliente_id\s+not\s+in\s+\((.*[^\(\)])\)/i",$rep,$string);
        print_r("\n\n");
        print_r($changed2);
        
        $this->assertEquals(TRUE,is_string($changed2));
    }


    
}//StringTest