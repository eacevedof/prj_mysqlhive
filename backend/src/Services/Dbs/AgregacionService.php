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
    
    public function add_operation()
    {
        print_r("AgregacionService.add_operation($iNum)");
        $this->oModel->set_table("tbl_operation");
        
        $arData["op_d1"] = "d1".$this->oRnd->get_item(["A","B","C"]);
        $arData["op_d2"] = "d2".$this->oRnd->get_item(["A","B","C"]);
        $arData["op_d3"] = "d3".$this->oRnd->get_item(["A","B","C"]);
        $arData["op_d4"] = "d4".$this->oRnd->get_item(["A","B","C"]);
        $arData["op_d5"] = "d5".$this->oRnd->get_item(["A","B","C"]);

        $arData["op_m1"] = $this->oRnd->get_int(1,$this->oRnd->get_int(0,1000));
        $arData["op_m2"] = $this->oRnd->get_int(1,$this->oRnd->get_int(0,1000));
        $arData["op_m3"] = $this->oRnd->get_int(1,$this->oRnd->get_int(0,1000));
        $arData["op_m4"] = $this->oRnd->get_int(1,$this->oRnd->get_int(0,1000));        
        $this->oModel->insert($arData,0);
    }
    
    public function add_operations($iNum=1)
    {
        print_r("AgregacionService.add_operations($iNum)");
        for($i=0;$i<$iNum;$i++)
        {
            $this->add_operation();
        }
    }
    
    public function first_load()
    {
        $this->truncate_operations();
        $this->add_operations(50);
    }
    
    public function run()
    {
        print_r("AgregacionService.run");
    }
        
}//AgregacionService

