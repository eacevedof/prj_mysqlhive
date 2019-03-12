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
    
    private function pr($sString){print_r($sString."\n");}    
    
    private function truncate_operations()
    {
        
        $sSQL = "TRUNCATE TABLE operation";
        $this->oModel->execute($sSQL);
    }
    
    public function add_operation()
    {
        $this->pr("AgregacionService.add_operation");
        $this->oModel->set_table("operation");
        
        $arData["d1"] = "d1".$this->oRnd->get_item(["A","B","C"]);
        $arData["d2"] = "d2".$this->oRnd->get_item(["A","B","C"]);
        $arData["d3"] = "d3".$this->oRnd->get_item(["A","B","C"]);
        $arData["d4"] = "d4".$this->oRnd->get_item(["A","B","C"]);
        $arData["d5"] = "d5".$this->oRnd->get_item(["A","B","C"]);
        
        $arData["atr1"] = "a1-".$this->oRnd->get_substring_len(10);
        $arData["atr2"] = "a2-".$this->oRnd->get_substring_len(15);
        $arData["atr3"] = "a3-".$this->oRnd->get_substring_len(20);
        $arData["atr4"] = "a4-".$this->oRnd->get_substring_len(20);
        $arData["atr5"] = "a5-".$this->oRnd->get_substring_len(20);

        $arData["m1"] = $this->oRnd->get_int(1,$this->oRnd->get_int(0,10));
        $arData["m2"] = $this->oRnd->get_int(1,$this->oRnd->get_int(0,20));
        $arData["m3"] = $this->oRnd->get_int(1,$this->oRnd->get_int(0,30));
        $arData["m4"] = $this->oRnd->get_int(1,$this->oRnd->get_int(50,60));
        $arData["m5"] = $this->oRnd->get_int(1,$this->oRnd->get_int(70,100));
        
        $this->oModel->insert($arData,0);
    }
    
    public function add_operations($iNum=1)
    {
        $this->pr("AgregacionService.add_operations($iNum)");
        for($i=0;$i<$iNum;$i++)
        {
            $this->add_operation();
        }
    }
    
    public function modif_operation()
    {
        $this->pr("AgregacionService.modif_operation");
        $this->oModel->set_table("operation");
        $this->oModel->set_pk("id");
        
        $sSQL = "SELECT id FROM operation";
        $arIds = $this->oModel->query($sSQL,0);
        $arIds = array_column($arIds,"id");
        //$this->pr($arIds);die;
        
        $arData["id"] = $this->oRnd->get_item($arIds);
        
        $arData["atr1"] = "a1-".$this->oRnd->get_substring_len(10);
        $arData["atr2"] = "a2-".$this->oRnd->get_substring_len(15);
        $arData["atr3"] = "a3-".$this->oRnd->get_substring_len(20);
        $arData["m1"] = $this->oRnd->get_int(1,$this->oRnd->get_int(0,1000));
        $arData["m2"] = $this->oRnd->get_int(1,$this->oRnd->get_int(0,1000));
        $arData["m3"] = $this->oRnd->get_int(1,$this->oRnd->get_int(0,1000));
        $arData["m4"] = $this->oRnd->get_int(1,$this->oRnd->get_int(0,1000)); 
        
        $this->oModel->update($arData,0);
    }
    
    public function modif_operations($iNum=1)
    {
        for($i=0;$i<$iNum;$i++)
        {
            $this->pr("AgregacionService.modif_operations $i");
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
        SELECT id,cdate,mdate
        FROM operation 
        WHERE 1
        AND 
        (
            cdate > (NOW() - INTERVAL $iMins MINUTE)
            OR mdate > (NOW() - INTERVAL $iMins MINUTE)
        )
        ";
        $arRows = $this->oModel->query($sSQL);
        return $arRows;
    }
    
    public function update()
    {
        $arIds = $this->get_keys("operation");
    }
    
    public function run()
    {
        $iMins = 60;
        $this->pr("AgregacionService.run");
        $this->pr("
        -comprobar nuevos de hace $iMins mins
        -   si hay nuevos
                - se obtienen todas las combinaciones de dimensiones que forman las claves
                - 
                
        ");

    }
    
    public function get_combinatoria($n,$k)
    {
        //r = (n!/k!)*(1/(n-k)!)
        $nf = gmp_fact($n);
        $kf = gmp_fact($k);
        $nmk = $n-$k;
        $nmkf = gmp_fact($nmk);
        $nfdvkf = ($nf/$kf);
        $invnkf = ((float)1/(float)$nmkf);
        $nkf = (float)$nfdvkf * (float)$invnkf;
        
        //echo "nf:$nf, kf:$kf, nmk:$nmk, nmkf:$nmkf, nkf:$nkf, nfdvkf:$nfdvkf, invnkf:$invnkf \n";
        return $nkf;
    }

    public function get_posibilites()
    {
        $arElemnts = ["a","b","c","d"];
        $iElem = count($arElemnts);
        
        $arR = [];
        for($i=0; $i<$iElem; $i++)
        {
            $arR[$i+1][] = "";
            foreach($arElemnts as $e)
            {
                
            }
        }
       
    }
    
}//AgregacionService

