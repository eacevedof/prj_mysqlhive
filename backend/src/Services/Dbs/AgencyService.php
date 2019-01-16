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
    private $sPathPublic;
    private $sPathTemplateDS;
    private $arFiles;
    private $arTags;
    
    public function __construct() 
    {
        parent::__construct();
        $this->load();
    }
    
    private function load()
    {
        $this->oBehav = new AgencyBehaviour();
        
        $sDb = $this->get_config("db","database");
        $sPath = PATH_SRC.DS."Behaviours".DS."templates".DS."$sDb";
        $this->sPathTemplateDS = $sPath;
        $this->arFiles = scandir($sPath);
        unset($this->arFiles[0]);unset($this->arFiles[1]);
        pr($this->arFiles);die;
        $this->arTags = ["tpl_build.php"=>[]];
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
            $arFields = $this->get_fields_info($sTable);
        }
    }
}//AgencyService
