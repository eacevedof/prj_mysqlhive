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

use App\Services\Dbs\DbsService;

class AgencyService extends DbsService
{
   
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function generate_exp()
    {
        $arDiTables = ["di_campaign_fees","di_campaigns_lines","di_campaigns_lines_fees"
            ,"di_campaings_payments","di_client_fees","di_fees","di_markets"
            ,"di_payments","di_providers","di_segments"];
        
        $arTables = $this->get_tables();
        $this->unset_tables($arTables,$arDiTables);
        $this->process_tables($arTables);        
        return $arTables;
    }//generate_exp
    
}//AgencyService
