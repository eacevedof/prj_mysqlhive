<?php
// en: /<project>/backend 
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests/DbTest.php --color=auto
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests
use PHPUnit\Framework\TestCase;
use TheFramework\Components\ComponentFile;
use TheFramework\Components\ComponentLog;
use TheFramework\Components\Db\ComponentMysql;

class DbTest extends TestCase
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
    
    public function test_bulk_insert()
    {
        $sFile = __DIR__."/../config/config.php";
        $arConfig = include($sFile);      
        $arConfig = $arConfig["db"];
        $oDb = new ComponentMysql($arConfig);
                
        $db_table_from = "tbl_operation";
        $db_table_dest = "tbl_operation_bulk";
        
        $folderpath = __DIR__.DIRECTORY_SEPARATOR."logs";
        $file = $folderpath.DIRECTORY_SEPARATOR.$db_table_from;        
        
        $oFile = new ComponentFile($folderpath,$db_table_from);
        
        $sFieldEnd = "@@@@";
        $sLineEnd = "####";
        
        $sSQL = "
        SELECT * 
        FROM db_agregacion.tbl_operation 
        WHERE 1
        ";
        
        $arRows = $oDb->query($sSQL);
        $oFile->save_bulkfile($arRows,$sFieldEnd,$sLineEnd);
        
        $sql="
        load data infile '$file'
        replace into table $db_table_dest
        CHARACTER SET utf8
        fields terminated by '$sFieldEnd'
        lines terminated by '$sLineEnd'";      
        $this->log($sql);
        $oDb->exec($sql);
        
/*
load data local infile 'C:\proyecto\prj_mysqlhive\backend\src\tests\logs\tbl_operation'
replace into table tbl_operation_bulk
CHARACTER SET utf8
fields terminated by '@@@@'
lines terminated by '####'

da error:
1) DbTest::test_bulk_insert
PDO::exec(): LOAD DATA LOCAL INFILE forbidden
*/        
        $this->assertEquals(FALSE,$oDb->is_error());
        
    }//test_bulk_insert
    
    
    /**
     *  @depends test_exists_config_file
     */ 
    public function test_is_env_prod()
    {
        $sFile = __DIR__."/../config/config.php";
        $arConfig = include($sFile);
        $this->assertEquals(TRUE,is_array($arConfig));
        $this->assertEquals(FALSE,ENV=="p");
    }
    
    /**
     *  @depends test_exists_config_file
     */ 
    public function test_connection()
    {
        $sFile = __DIR__."/../config/config.php";
        $arConfig = include($sFile);
        $this->log($arConfig,"arconfig");
        $this->assertEquals(TRUE,is_array($arConfig));
        $arConfig = $arConfig["db"];
        
        $oDb = new ComponentMysql($arConfig);
        $this->assertInstanceOf(ComponentMysql::class,$oDb);
        
        $sSQL = "
        SELECT table_name 
        FROM information_schema.tables 
        WHERE table_schema='{$arConfig["database"]}'";
        
        $arRows = $oDb->query($sSQL);
        $this->log($arRows,"test_connection");
        $this->assertEquals(TRUE,count($arRows)>1);
    }
    
}//DbTest