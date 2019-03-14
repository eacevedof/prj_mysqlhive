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
        
        $file = __DIR__.DIRECTORY_SEPARATOR."logs";
        $db_table_from = "tbl_operation";
        $db_table_dest = "tbl_operation_bulk";
        
        $oLog = new ComponentFile(__DIR__.DIRECTORY_SEPARATOR."logs",$db_table_from);
        
        $sSQL = "
        SELECT * 
        FROM db_agregacion.tbl_operation 
        WHERE 1=1'
        ";
        
        $arRows = $oDb->query($sSQL);
        foreach($arRows as $i=>$arRow)
        {
            $fieldvalues = preg_replace("[\n|\r|\n\r]","",implode("\001",$arRow));
            $iSaved = $oLog->save($fieldvalues); 
            $this->log($arRow,"ARROW $i");
            $this->log($fieldvalues,"STRING $i");
        }

/*
 
 
load data local infile '/tmp/ficheros_tmp_descartables/mysql_altas_multiples_1552552174_y5Amej'
replace into table b2c.tmp_formwebpin_sessions_altas_multiples_1552552174
fields terminated by '@@@@'
lines terminated by '####'
*/
        
        $sql="
        load data local infile '$file'
        replace into table $db_table_dest
        CHARACTER SET utf8
        fields terminated by '\001'
        lines terminated by '\n'";        
        $oDb->exec($sql);
        
        $this->assertEquals(FALSE,$oDb->is_error());
    }
    
    
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