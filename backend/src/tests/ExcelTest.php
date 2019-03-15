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
        LIMIT 8005  -- con 5 se rompe
        ";
        
        $iSizeBef = memory_get_usage();
        print_r("\nmembef: $iSizeBef\n");
        $arRows = $oDb->query($sSQL);
        $iSizeAft = memory_get_usage();
        print_r("memaf: $iSizeAft\n");
        $iSize = abs($iSizeBef - $iSizeAft);
        print_r("memfinal: $iSize\n");
/*
ok:
membef: 2441400
memaf: 13742424
memfinal: 11301024

ya no va:
memfinal: 11302408

con PHPExcel este es lim: 147221968
*/        
        
        $arCols = array_keys($arRows[0]);
        $arCols = array_flip($arCols);
        $sColumns = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        //print_r($arCols);die;
        $oSpread = new Spreadsheet();
        $oActiveSheet = $oSpread->getActiveSheet();
        
        foreach($arCols as $field=>$i)
        {
            //print_r("$field => $i");die;
            $cLetter = $sColumns{$i}."1";            
            //print_r($cLetter);die;
            $oActiveSheet->setCellValue($cLetter,$field);
        }
        
        foreach($arRows as $i=>$arRow)
        {
            $iR = $i+2;
            foreach($arRow as $f => $v)
            {
                $i = $arCols[$f];
                $cell = $sColumns{$i}.$iR;
                $oActiveSheet->setCellValue($cell,$v);
            }
        }

        $file = __DIR__."/logs/hello-world.xlsx";
        if(is_file($file)) unlink($file);
        
        $oXlsx = new Xlsx($oSpread);
        $oXlsx->save($file);
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