<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Behaviours\AgencyBehaviour 
 * @file AgencyBehaviour.php v1.0.0
 * @date 29-11-2018 19:00 SPAIN
 * @observations
 */
namespace App\Behaviours;

use App\Models\AppModel;
use App\Services\Dbs\CoreQueriesService;

class AgencyBehaviour extends AppModel
{
    private $oQServ;
    
    public function __construct() 
    {
        parent::__construct();
        $this->oQServ = new CoreQueriesService();
    }
    
    public function get_tables()
    {
        $arConfig = $this->get_config();
    }
   
    public function get_fields()
    {
        $arConfig = $this->get_config();
        
    }

}//AgencyBehaviour
