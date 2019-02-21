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
/*
SELECT COUNT(*) FROM rtb.insertion_orders;                      -- 3526
SELECT COUNT(*) FROM rtb.bigdata_banners;                       -- 11328
SELECT COUNT(*) FROM rtb.bigdata_placements; (cts)              -- 2868817
SELECT COUNT(*) FROM rtb.super_black_list;   (cts)              -- 568
SELECT COUNT(*) FROM rtb.line_items; (*)                        -- 38425
SELECT COUNT(*) FROM rtb.insertion_orders_placement_type; (*)	-- 487032
SELECT COUNT(*) FROM rtb.insertion_orders_placement_tactic; (*)	-- 4913177
SELECT COUNT(*) FROM rtb.pmp_deals; (cts)                       -- 68
SELECT COUNT(*) FROM rtb.pmp_deals_placements;                  -- 3364

-- hechos
SELECT COUNT(*) FROM rtb.bigdata_bids_hora_201809;		-- 22279656
SELECT COUNT(*) FROM rtb.bigdata_bids_hora_201810;		-- 46419644
SELECT COUNT(*) FROM rtb.bigdata_bids_hora_201811;		-- 64153868
SELECT COUNT(*) FROM rtb.bigdata_bids_hora_201812;		-- 84725192
SELECT COUNT(*) FROM rtb.bigdata_bids_hora_201901;		-- 58529814
SELECT COUNT(*) FROM rtb.bigdata_bids_hora_201902;		-- 46519389
SELECT COUNT(*) FROM rtb.bigdata_bids_hora_201903;		-- 0
 */        
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
        
        $arDiTables = [
            "bigdata_operators",
            "bigdata_placements_categories"
        ];
        
        $arTables = $this->get_tables();
        $this->unset_tables($arTables,$arDiTables);
        $this->process_tables($arTables);        
        return $arTables;
    }//generate_exp
        
}//RtbService
