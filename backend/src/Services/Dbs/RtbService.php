<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Services\Dbs\RtbService 
 * @file RtbService.php 1.0.0
 * @date 19-02-2019 11:02 SPAIN
 * @observations
 */
namespace App\Services\Dbs;

use App\Services\Dbs\DbsService;

class RtbService extends DbsService
{
   
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function generate_exp()
    {
        $arDiTables = [
            "insertion_orders",
            "bigdata_banners",
            "bigdata_placements",
            "super_black_list",
            "line_items",
            "insertion_orders_placement_type",
            "insertion_orders_placement_tactic",
            "pmp_deals",
            "pmp_deals_placements",
            //"bigdata_bids_hora_YM"  //hechos
        ];
        
        $arTables = $this->get_tables();
        $this->unset_tables($arTables,$arDiTables);
        $this->process_tables($arTables);        
        return $arTables;
    }//generate_exp
        
}//RtbService
