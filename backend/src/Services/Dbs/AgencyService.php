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
                "fieldsinfoddl"=>""
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
                ,"servername" => $this->get_config("db","server")
                //,"tablename"=>""
            ],
            "tpl_ssh_cfgbuild.ssh" => [
                //"tablename"=>""               
            ],
            "tpl_staging_tables.ddl.sql" => [
                //"tablename"=>""
                "fieldsinfoddl"=>""              
            ]
        ];        
    }//load_tags
        
    private function create_folder($sPath)
    {
        //$sPath = $this->sPathTempDS.$sName;
        if(is_dir($sPath))
        {
            $arFiles = scandir($sPath);
            unset($arFiles[0]);unset($arFiles[1]);
            foreach($arFiles as $sFile)
            {
                $sPathFile = $sPath.DS.$sFile;
                unlink($sPathFile);
            }
            rmdir($sPath);
        }
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
        
    private function add_values(&$arTags,$arFields)
    {
        //pr(array_column($arFields,"field_name"));
        $arTags["allfields"] = implode(",",array_column($arFields,"field_name"));
        
        $arFieldLine = [];
        $arLineInsert = [];
        foreach($arFields as $arField)
        {
            $arLineDdl = []; $arLinePhp = [];
            $arLineDdl[] = "{$arField["field_name"]} ";
            $arLinePhp[] = "\"{$arField["field_name"]}\" => array(\"type\" ";

            if(in_array($arField["field_type"],["varchar","text","char","tynyblob","blob","mediumblob","longblob","set","enum","tynytext","mediumtext","longtext"]))
            {
                $arLineInsert[] = "'Desconocido'";
                $arLineDdl[] = "string";
                $arLinePhp[] = " => \"string\" ";
            }
            
            if(in_array($arField["field_type"],["int","samllint","tinyint","mediumint","bigint","bit"]))
            {                    
                $arLineInsert[] = "-1";
                $arLineDdl[] = "int"; 
                $arLinePhp[] = " => \"int\" ";            
            }            
            
            if(in_array($arField["field_type"],["date","datetime","time","timestamp","year"]))
            {
                $arLineInsert[] = "'2099-01-01 00:00:00'";
                $arLineDdl[] = "timestamp";
                $arLinePhp[] = " => \"timestamp\" ";
            }
            
            if(in_array($arField["field_type"],["decimal","float","double"]))
            {
                $arLineInsert[] = "0";
                $arLineDdl[] = "decimal({$arField["ntot"]},{$arField["ndec"]})";
                $arLinePhp[] = " => \"decimal({$arField["ntot"]},{$arField["ndec"]})\" ";
            }
            
            if($arField["extra"]=="auto_increment") $arLinePhp[] = ", \"pk\" => true ";
            if(strstr($arField["field_name"],"_ts") && strstr($arField["field_name"],"modified_")) 
            {
                $arTags["fieldnamedate"] = $arField["field_name"];
                $arLinePhp[] = ", \"update_date\" => true ";
            }
            
            $arLinePhp[] = ")";
            
            $arFieldLine["php"][] = implode("",$arLinePhp);
            $arFieldLine["ddl"][] = implode("",$arLineDdl);
        }//arFields
        
        
        $arTags["tabletype"] = "dimension_table";
        $arTags["fieldsvalue"] = implode(",",$arLineInsert);
        $arTags["fieldsinfo"] = implode(",\n",$arFieldLine["php"]);
        $arTags["fieldsinfoddl"] = implode(",\n",$arFieldLine["ddl"]);
        
        foreach($arFields as $arField)
        {
            if($arField["extra"]=="auto_increment") 
                $arTags["fieldnamepk"] = $arField["field_name"];            
        }
        
    }//add_values
    
    public function generate_exp()
    {
        $arTables = $this->get_tables();
        foreach($arTables as $sTable)
        {
            $sPathDirTable = $this->sPathTempDS.$sTable;
            $this->create_folder($sPathDirTable);
            $arFields = $this->get_fields_info($sTable);
            //bug($arFields);die;
            foreach($this->arFilesTpl as $sTpl)
            {
                $sPathTpl = $this->sPathTplsDS.$sTpl;
                $sContent = file_get_contents($sPathTpl);
                
                $arTags = array_merge($this->arTags["all"],$this->arTags[$sTpl]);
                $arTags["tablename"] = $sTable;
                
                //pr($arTags);die;
                $this->add_values($arTags,$arFields);
                
                foreach($arTags as $sTag => $sValue)
                    $sContent = str_replace("%$sTag%",$sValue,$sContent);
                
                $sPathFinal = $sPathDirTable.DS.$sTable."_".$sTpl;
                
                if(strstr($sTpl,"load_cfg.php"))
                    $sPathFinal = $sPathDirTable.DS."emr_load_cfg_{$sTable}.php";
                
                if(strstr($sTpl,"_build.php"))
                    $sPathFinal = $sPathDirTable.DS."emr_build_{$sTable}.php";
   
                //if(is_file($sPathFinal)) unlink($sPathFinal);
                file_put_contents($sPathFinal,$sContent);
            }//arFilesTpl
        }//arTables
    }
}//AgencyService
