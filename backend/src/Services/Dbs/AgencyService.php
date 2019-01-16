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
    
    public function __construct() {
        parent::__construct();
        $this->oBehav = new AgencyBehaviour();
    }
       
    private function get_tables()
    {
        
    }

    private function get_fields()
    {
        
    }
    
    public function generate_exp()
    {
        
    }
}//AgencyService
