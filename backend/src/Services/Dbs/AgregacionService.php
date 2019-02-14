<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Services\Dbs\AgregacionService 
 * @file AgregacionService.php 1.0.0
 * @date 28-01-2019 19:00 SPAIN
 * @observations
 */
namespace App\Services\Dbs;

use App\Services\AppService;
use App\Models\AppModel;
use  App\Services\RamdomizerService;

class AgregacionService extends AppService
{
    private $oModel;
    private $oRnd;
    
    public function __construct() 
    {
        parent::__construct();
        $this->oModel = new AppModel();
        $this->oRnd = new RamdomizerService();
    }
    
    private function truncate_operations()
    {
        $sSQL = "TRUNCATE TABLE tbl_operation";
        $this->oModel->execute($sSQL);
    }
    
    private function add_operation($arData)
    {
        $this->oModel->set_table("tbl_operation");
        $this->oModel->insert($arData);
    }
    
    private function first_load()
    {
        $this->truncate_operations();
        for($i=0;$i<50;$i++)
        {
            $arDat["op_d1"] = "d1".$this->oRnd->get_item(["A","B","C"]);
            $arDat["op_d2"] = "d2".$this->oRnd->get_item(["A","B","C"]);
            $arDat["op_d3"] = "d3".$this->oRnd->get_item(["A","B","C"]);
            $arDat["op_d4"] = "d4".$this->oRnd->get_item(["A","B","C"]);
            $arDat["op_d5"] = "d5".$this->oRnd->get_item(["A","B","C"]);
            
            $arDat["op_m1"] = "d5".$this->oRnd->get_int(1,$this->oRnd->get_int(0,1000));
            $arDat["op_m2"] = "d5".$this->oRnd->get_int(1,$this->oRnd->get_int(0,1000));
            $arDat["op_m3"] = "d5".$this->oRnd->get_int(1,$this->oRnd->get_int(0,1000));
            $arDat["op_m4"] = "d5".$this->oRnd->get_int(1,$this->oRnd->get_int(0,1000));
            $arDat["op_m5"] = "d5".$this->oRnd->get_int(1,$this->oRnd->get_int(0,1000));
            
            $this->oModel->insert($arDat,0);
        }
    }
    
    
    public function run()
    {
        
        print_r("AgregacionService.run");
        $this->first_load();
    }
        
}//AgregacionService

