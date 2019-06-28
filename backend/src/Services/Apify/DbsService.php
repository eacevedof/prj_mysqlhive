<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Services\Apify\Mysql
 * @file DbsService.php 1.0.0
 * @date 27-06-2019 17:55 SPAIN
 * @observations
 */
namespace App\Services\Apify;

use TheFramework\Components\Db\Context\ComponentContext;
use App\Services\AppService;
use App\Behaviours\SchemaBehaviour;
use App\Factories\DbFactory;

class DbsService extends AppService
{
    private $oContext;
    private $oBehav;
    
    public function __construct($sPathcontext="",$idContext="") 
    {
        $this->oContext = new ComponentContext($sPathcontext);

        $oDb = DbFactory::get_dbobject($idContext);
        $this->oBehav = new SchemaBehaviour($oDb);
    }
    
    
    
    
    
}//DbsService
