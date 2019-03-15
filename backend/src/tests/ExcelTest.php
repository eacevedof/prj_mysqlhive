<?php
// en: /<project>/backend 
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests/ExcelTest.php --color=auto
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests
use PHPUnit\Framework\TestCase;
use TheFramework\Components\ComponentLog;
use TheFramework\Components\Db\ComponentMysql;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



class ExcelTest extends TestCase
{    
    private function log($mxVar,$sTitle=NULL)
    {
        $oLog = new ComponentLog("logs",__DIR__);
        $oLog->save($mxVar,$sTitle);
    }
    
    public function test_exists_config_file()
    {
        $sFile = __DIR__."/../config/config.php";
        //$this->log($sFile);
        $isFile = is_file($sFile);
        $this->assertEquals(TRUE,$isFile);
    }
    
    public function test_excel()
    {
        $sFile = __DIR__."/../config/config.php";
        $arConfig = include($sFile);      
        $arConfig = $arConfig["db"];
        $oDb = new ComponentMysql($arConfig);
        
        $sSQL = "
        SELECT *
        FROM ft_campaigns_lines_stats_201902
        UNION ALL
        SELECT *
        FROM ft_campaigns_lines_stats_201903
        LIMIT 10
        ";
        
        $arRows = $oDb->query($sSQL);
        $arCols = array_keys($arRows[0]);
        $arCols = array_flip($arCols);
        $sColumns = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        //print_r($arCols);die;
        $oSpread = new Spreadsheet();
        $oActiveSheet = $oSpread->getActiveSheet();
        foreach($arRows as $i=>$arRow)
        {
            $iR = $i+1;
            foreach($arRow as $f => $v)
            {
                $i = $arCols[$f];
                $cell = $sColumns{$i}.$iR;
                $oActiveSheet->setCellValue($cell,$v);
            }
        }
        
        $oXlsx = new Xlsx($oSpread);
        $oXlsx->save(__DIR__."/logs/hello-world.xlsx");
        $this->assertEquals(TRUE,is_array($arRows));
/*
.PHP Fatal error:  Allowed memory size of 134217728 bytes exhausted (tried to allocate 16777216 bytes) 
in C:\proyecto\prj_mysqlhive\backend\vendor\phpoffice\phpspreadsheet\src\PhpSpreadsheet\Collection\Cells.php on line 421
 * 
Fatal error: Allowed memory size of 134217728 bytes exhausted (tried to allocate 16777216 bytes) in 
C:\proyecto\prj_mysqlhive\backend\vendor\phpoffice\phpspreadsheet\src\PhpSpreadsheet\Collection\Cells.php on line 421
*/        
    }//test_excel

    
}//ExcelTest