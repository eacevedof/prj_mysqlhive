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
        print_r("AgregacionService.add_operation");
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
    
    public function modif_operation()
    {
        print_r("AgregacionService.add_operation");
        $this->oModel->set_table("tbl_operation");
        $this->oModel->set_pk("id");
        
        $sSQL = "SELECT id FROM tbl_operation";
        $arIds = $this->oModel->query($sSQL,0);
        $arIds = array_column($arIds,"id");
        //print_r($arIds);die;
        
        $arData["id"] = $this->oRnd->get_item($arIds);
        $arData["op_m1"] = $this->oRnd->get_int(1,$this->oRnd->get_int(0,1000));
        $arData["op_m2"] = $this->oRnd->get_int(1,$this->oRnd->get_int(0,1000));
        $arData["op_m3"] = $this->oRnd->get_int(1,$this->oRnd->get_int(0,1000));
        $arData["op_m4"] = $this->oRnd->get_int(1,$this->oRnd->get_int(0,1000)); 
        
        $this->oModel->update($arData,0);
    }
    
    public function modif_operations($iNum=1)
    {
        for($i=0;$i<$iNum;$i++)
        {
            print_r("AgregacionService.modif_operations $i \n");
            $this->modif_operation();
        }
    }
    
    
    public function first_load()
    {
        $this->truncate_operations();
        $this->add_operations(50);
    }
    
    public function check_modified($iMins=NULL)
    {
        if(!$iMins) $iMins=10;
        $sSQL = "
        SELECT id,op_cdate,op_mdate
        FROM tbl_operation 
        WHERE 1
        AND 
        (
            op_cdate > (NOW() - INTERVAL $iMins MINUTE)
            OR op_mdate > (NOW() - INTERVAL $iMins MINUTE)
        )
        ";
        $arRows = $this->oModel->query($sSQL);
        return $arRows;
    }
    
    public function update()
    {
        $arIds = $this->get_keys("tbl_operation");
    }
    
    public function run()
    {
        print_r("AgregacionService.run");
    }
        
}//AgregacionService

