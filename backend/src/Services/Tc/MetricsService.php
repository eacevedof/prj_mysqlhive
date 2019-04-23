<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Services\Dbs\MetricsService 
 * @file MetricsService.php 1.0.0
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
    private $arTables;
    
   
    public function __construct() 
    {
        parent::__construct();
        $this->load_config();
    }
    
    private function load_config()
    {
        
        
        $sFolder = dirname($this->sFolderFrom);
        $this->sFolderTo = realpath("C:\proyecto\prj_mysqlhive\backend\public\temp\\".$sFolder);
        $this->sFieldAfter = "total_impresiones_valid_isp";
        
        $this->arMetricsTpl = [
            "null total_suscritos_bajas_ivr",
            "total_suscritos_bajas_ivr int"
        ];
        
        $this->arMetric = ["field"=>"total_altas_split", "type"=>"int", "tpl"=>"total_suscritos_bajas_ivr"];
    }
        
    private function get_files_etl()
    {
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
    }
    
    private function add_repl_lines(&$arLines)
    {
        $arTmp = [];
        foreach($arLines as $sLine)
        {
            $arTmp[] = $sLine;
            $arTmp[] = "|||";//marca de linea libre
        }
        $arLines = $arTmp;
    }
    
    private function remove_repl_lines(&$arLines)
    {
        $arTmp = [];
        foreach($arLines as $sLine)
            if($sLine!="|||")
                $arTmp[] = $sLine;
        $arLines = $arTmp;
    }
    
    private function change_lines(&$arLines)
    {
        $arTmp = $arLines;
        $arFound = $this->get_template_fields($arLines);
        $arNew = [];

        $sTplField = $this->arMetric["tpl"];
        foreach($arFound as $iPos)
        {
            $sTplLine = $arLines[$iPos];
            $sTplLine = str_replace($sTplField, $this->arMetric["field"], $sTplLine);
            $arTmp[$iPos+1] = $sTplLine;
        }
        $arLines = $arTmp;
    }
    
    private function read_files()
    {
        $arFiles = $this->get_files_etl();
        $sPathFromDS = $this->sFolderFrom.DIRECTORY_SEPARATOR;
        $sPathToDS = $this->sFolderTo.DIRECTORY_SEPARATOR;
        
        foreach($arFiles AS $sFile)
        {
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
    }
        
}//MetricsService
