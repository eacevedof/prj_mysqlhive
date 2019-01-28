<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Services\Dbs\AgencyService 
 * @file AgencyService.php 1.0.0
 * @date 28-01-2019 19:00 SPAIN
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
        $arDiTables = [
            "di_campaigns"
            ,"di_campaigns_lines"
            //,"di_campaigns_lines_fees"    //25/01/2019 - va en di_client_fees
            ,"di_campaigns_payments"
            //,"di_campaign_fees"           //25/01/2019 - va en di_client_fess
            ,"di_clients"
            ,"di_client_fees"
            ,"di_fees"
            //,"di_markets"                 //hay que incluir en di_campaings 
            ,"di_payments"
            ,"di_providers"
            //,"di_segments"                //no hace falta, se trae en otro proceso
        ];
        
        $arTables = $this->get_tables();
        $this->unset_tables($arTables,$arDiTables);
        $this->process_tables($arTables);        
        return $arTables;
    }//generate_exp
    
    public function move_php()
    {
        $arFolders = scandir($this->sPathTempDS);
        unset($arFolders[0]);unset($arFolders[1]);
        foreach($arFolders as $sFolder)
        {
            
        }
    }
        
}//AgencyService
