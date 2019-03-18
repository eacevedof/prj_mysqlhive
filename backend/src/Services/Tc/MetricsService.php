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
    private $arMetrics;
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
        
        $this->arMetrics = [
            ["field"=>"total_altas_split", "type"=>"int"]
        ];
        
        $this->arTables = [
            "ft_b2c_portales_stats","ft_b2c_portales_stats_mes"
        ];
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
    
    private function read_files()
    {
        $arFiles = $this->get_files_etl();
        $sPathFrom = $this->sFolderFrom.DIRECTORY_SEPARATOR;
        
        foreach($arFiles AS $sFile)
        {
            $sPathFile = $sPathFrom.$sFile;
            
        }
    }
    
    public function run()
    {
        //create dest folder
        //get_files
        //read files
            //read file
            //add metrics after fiedlafter in arLines
            //save arLines in new file
        //create alter table
        //
    }
        
}//MetricsService
