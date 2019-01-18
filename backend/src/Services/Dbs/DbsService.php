<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Services\Dbs\DbsService 
 * @file DbsService.php 1.0.0
 * @date 15-01-2018 19:00 SPAIN
 * @observations
 */
namespace App\Services\Dbs;

use App\Services\AppService;
use App\Behaviours\AgencyBehaviour;

class DbsService extends AppService
{
    protected $oBehav;
    protected $sPathTplsDS;
    protected $sPathTempDS;//ruta publica donde se guardarán los resultados
    protected $arFilesTpl;
    protected $arTags;
    
    public function __construct()
    {
        parent::__construct();
        $this->load();
        $this->load_tags();
    }
    
    protected function load()
    {
        $this->oBehav = new AgencyBehaviour();
        
        $sDb = $this->get_config("db","database");
        $sPath = PATH_SRC.DS."Behaviours".DS."templates".DS."$sDb";
        $this->sPathTplsDS = $sPath.DS;
        $this->sPathTempDS = PATH_PUBLIC.DS."temp".DS;
        $this->arFilesTpl = scandir($sPath);
        unset($this->arFilesTpl[0]);unset($this->arFilesTpl[1]);
    }
    
    protected function load_tags()
    {
        $sDb = $this->get_config("db","database");
        $sContext = $this->get_config("db","context");
        
        $this->arTags = [ 
            "all"=>[
                "databasename"      =>  $sDb
                ,"contextname"      =>  $sContext
                ,"DATABASENAME"     =>  strtoupper($sDb)
                ,"servername"       =>  $this->get_config("db","server")                
                ,"tablename"        =>  ""
                ,"allfields"        =>  ""
                ,"fieldnamepk"      =>  ""
                ,"fieldsinfo"       =>  ""
                ,"fieldsinfoddl"    =>  ""
                ,"fieldsvalue"      =>  ""
                ,"fieldnamedate"    =>  ""
                ,"tabletype"        =>  ""
                ,"fieldsinfoddl"    =>  ""
            ]
        ];        
    }//load_tags
        
    protected function create_folder($sPath)
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
        
    protected function get_tables()
    {
        //$arReturn = [];
        $arReturn = $this->oBehav->get_tables();
        return $arReturn;
    }

    protected function get_fields_info($sTable)
    {
        $arReturn = $this->oBehav->get_fields_info($sTable);
        return $arReturn;
    }
        
    protected function add_values(&$arTags,$arFields)
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
            
            if(in_array($arField["field_type"],["int","smallint","tinyint","mediumint","bigint","bit"]))
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
    
    public function process_tables($arTables)
    {
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
                
                $arTags = $this->arTags["all"];
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
        
    }//process_tables
    
    public function unset_tables(&$arTables,$arUnset=[])
    {
        foreach($arTables as $i=>$sTable)
            if(!in_array($sTable,$arUnset))
                unset($arTables[$i]);
            
    }//unset_tables
    
}//DbsService
