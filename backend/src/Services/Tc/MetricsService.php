<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Services\Dbs\MetricsService 
 * @file MetricsService.php 2.0.0
 * @date 28-01-2019 19:00 SPAIN
 * @observations
 */
namespace App\Services\Tc;

use App\Services\Dbs\DbsService;

class MetricsService extends DbsService
{
    private $sFolderFrom;
    private $sFolderTo;
    private $sFieldAfter;
    private $arMetric;
    private $arMetricsTpl;
   
    public function __construct() 
    {
        parent::__construct();
        $this->load_config();
        //@TO-DO:
        //generar campos para ddl create table
        //generar los alter table
    }
    
    private function load_config()
    {
        

        //$sFolder = basename($this->sFolderFrom.DIRECTORY_SEPARATOR);
        //print_r($sFolder);die;        
        $this->sFolderTo = realpath("C:\\proyecto\\prj_mysqlhive\\backend\\public\\temp\\");
        $this->sFolderTo = realpath("C:\\proyecto\\prj_tc_documentacion\\b2c\\nueva_metrica_total_clicks\\");
        $this->sFieldAfter = "total_impresiones_valid_isp";
        
        $this->arMetricsTpl = [
            "null total_suscritos_bajas_ivr",
            "total_suscritos_bajas_ivr int",
            "total_suscritos_bajas_ivr,"
        ];
        
        $this->arMetric = ["field"=>"total_clicks", "type"=>"int", "tpl"=>"total_suscritos_bajas_ivr","fileprefix"=>"ft_portales_stats_"];
    }
        
    private function get_files_etl()
    {
//print_r($this->sFolderFrom);die("xxx");        
        $arFiles = scandir($this->sFolderFrom);
        if($arFiles)
        {
            unset($arFiles[0]);
            unset($arFiles[1]);
        }
        return $arFiles;
    }//get_files
    
    private function get_template_fields($arLines)
    {
        $arFound = [];
        foreach($arLines as $i=>$sLine)
            foreach($this->arMetricsTpl as $sTpl)
                if(strstr($sLine, $sTpl))
                    $arFound[] = $i;
        return $arFound;
    }
    
    private function add_repl_lines(&$arLines)
    {
        $arTmp = [];
        foreach($arLines as $sLine)
        {
            $arTmp[] = $sLine;
            $arTmp[] = "||||||||||";//marca de linea libre
        }
        $arLines = $arTmp;
    }
    
    private function remove_repl_lines(&$arLines)
    {
        $arTmp = [];
        foreach($arLines as $sLine)
            if($sLine!="||||||||||")
                $arTmp[] = $sLine;
        $arLines = $arTmp;
    }
    
    private function change_lines(&$arLines)
    {
        $arTmp = $arLines;
        $arFound = $this->get_template_fields($arLines);

        $sTplField = $this->arMetric["tpl"];
        foreach($arFound as $iPosfound)
        {
            //se salta de dos en dos por la linea ||||||||||
            $sTplLineprev = trim($arLines[$iPosfound-2]);
            $sTplLinecurr = trim($arLines[$iPosfound]);
            
            //remplazo la linea actual añadiendole una coma si hiciera falta
            if(substr($sTplLineprev, -1, 1) == "," && substr($sTplLinecurr, -1, 1) != ",")
                $arTmp[$iPosfound] = rtrim($arLines[$iPosfound]).",";
            
            $sTplLine = $arLines[$iPosfound];
            $sTplLine = str_replace($sTplField, $this->arMetric["field"], $sTplLine);
            $arTmp[$iPosfound+1] = $sTplLine;
        }
        $arLines = $arTmp;
    }
    
    private function unlink_folder()
    {
        $arExclude = ["README.md","alters.sql"];
        $sPathToDS = $this->sFolderTo.DIRECTORY_SEPARATOR;
        $arFiles = scandir($sPathToDS);
        unset($arFiles[0]);unset($arFiles[1]);
        foreach($arFiles as $sFile)
            if(in_array($sFile, $arExclude))
                continue;
            unlink($sPathToDS.$sFile);
    }
    
    private function read_files()
    {
        $arFiles = $this->get_files_etl();

        //elimino los ficheros que no cumplen el patron
        foreach($arFiles as $i => $file)
            if(!strstr($file, $this->arMetric["fileprefix"]))
                unset($arFiles[$i]);
        
        $sPathFromDS = $this->sFolderFrom.DIRECTORY_SEPARATOR;
        $sPathToDS = $this->sFolderTo.DIRECTORY_SEPARATOR;
        
        //borro todo del directorio temporal
        $this->unlink_folder();
        foreach($arFiles AS $sFile)
        {
            //bug($sFile);
            $sPathFileFrom = $sPathFromDS.$sFile;
            $sPathFileTo = $sPathToDS.$sFile;
            
            $sContent = file_get_contents($sPathFileFrom);
            $arLines = explode("\n",$sContent);
            $this->add_repl_lines($arLines);
            $this->change_lines($arLines);
            $this->remove_repl_lines($arLines);
            $sContent = implode("\n",$arLines);
            file_put_contents($sPathFileTo,$sContent);
        }
    }    
    
    public function run()
    {
        $this->read_files();
        $sPathToDS = $this->sFolderTo.DIRECTORY_SEPARATOR;
        $ar = scandir($sPathToDS);
        unset($ar[0]);unset($ar[1]);
        $ar["count"] = count($ar);
        return $ar;
    }
        
}//MetricsService
