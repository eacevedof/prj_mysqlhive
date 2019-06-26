<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Services\Dbs\B2CService 
 * @file B2CService.php 1.0.0
 * @date 19-02-2019 11:02 SPAIN
 * @observations
 */
namespace App\Services\Dbs;

use App\Services\Dbs\DbsService;

class B2CService extends DbsService
{
   
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function generate_exp()
    {
        $arDiTables = [
            "di_banner_ids",
            "di_placement_ids"
        ];
        
        $arTables = $this->get_tables();
        $this->unset_tables($arTables,$arDiTables);
        $this->process_tables($arTables);        
        return $arTables;
    }//generate_exp
        
}//B2CService
