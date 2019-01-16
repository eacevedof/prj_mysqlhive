<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Services\Dbs\AgencyService 
 * @file AgencyService.php 1.0.0
 * @date 15-01-2018 19:00 SPAIN
 * @observations
 */
namespace App\Services\Dbs;

use App\Services\AppService;
use App\Behaviours\AgencyBehaviour;

class AgencyService extends AppService
{
    private $oBehav;
    private $sPathTplsDS;
    private $sPathTempDS;//ruta publica donde se guardarán los resultados
    private $arFilesTpl;
    private $arTags;
    
    public function __construct() 
    {
        parent::__construct();
        $this->load();
        $this->load_tags();
    }
    
    private function load()
    {
        $this->oBehav = new AgencyBehaviour();
        
        $sDb = $this->get_config("db","database");
        $sPath = PATH_SRC.DS."Behaviours".DS."templates".DS."$sDb";
        $this->sPathTplsDS = $sPath.DS;
        $this->sPathTempDS = PATH_PUBLIC.DS."temp".DS;
        $this->arFilesTpl = scandir($sPath);
        unset($this->arFilesTpl[0]);unset($this->arFilesTpl[1]);
    }
    
    private function load_tags()
    {
        $sDb = $this->get_config("db","database");
        $sContext = $this->get_config("db","context");
        
        $this->arTags = [ 
            "all"=>[
                "databasename" => $sDb
                ,"contextname" => $sContext
                ,"tablename"=>""
                //,"allfields"=>""
                ,"fieldnamepk"=>""
                //,"fieldsinfo"=>""
            ],
            
            "tpl_build.php" => [
                //"contextname"=>""
                //,"tablename"=>""
                "allfields"=>""
                //,"fieldnamepk"=>""
                ,"fieldsinfo"=>""             
            ],
            "tpl_dw.ddl.sql" => [
                //"tablename"=>""
                "fieldsinfo"=>""
                //,"fieldnamepk"=>""
                ,"fieldsvalue"=>""
            ],
            "tpl_load_cfg.php" => [
                //"contextname"=>""
                //,"tablename"=>""
                "fieldnamedate"=>""
                //,"fieldnamepk"=>""
                ,"tabletype"=>""      
            ],
            "tpl_replicate_conf.php" => [
                "DATABASENAME" =>  strtoupper($sDb)
                ,"servername" => ""
                //,"tablename"=>""
            ],
            "tpl_ssh_cfgbuild.ssh" => [
                //"tablename"=>""               
            ],
            "tpl_staging_tables.ddl.sql" => [
                //"tablename"=>""
                "fieldsinfo"=>""              
            ]
        ];        
    }//load_tags
        
    private function create_folder($sPath)
    {
        //$sPath = $this->sPathTempDS.$sName;
        if(is_dir($sPath)) rmdir($sPath);
        return mkdir($sPath);
    }
        
    private function get_tables()
    {
        //$arReturn = [];
        $arReturn = $this->oBehav->get_tables();
        return $arReturn;
    }

    private function get_fields_info($sTable)
    {
        $arReturn = $this->oBehav->get_fields_info($sTable);
        return $arReturn;
    }
        
    public function generate_exp()
    {
        $arTables = $this->get_tables();
        foreach($arTables as $sTable)
        {
            $sPathDirTable = $this->sPathTempDS.$sTable;
            $this->create_folder($sPathDirTable);
            //$arFields = $this->get_fields_info($sTable);
            //bug($arFields);die;
            foreach($this->arFilesTpl as $sTpl)
            {
                $sPathTpl = $this->sPathTplsDS.$sTpl;
                $sContent = file_get_contents($sPathTpl);
                
                $arTags = array_merge($this->arTags["all"],$this->arTags[$sTpl]);
                pr($arTags);
                
                $sPathFinal = $sPathDirTable.DS.$sTpl."_".$sTable;
                file_put_contents($sPathFinal,$sContent);
            }//arFilesTpl
        }//arTables
    }
}//AgencyService
