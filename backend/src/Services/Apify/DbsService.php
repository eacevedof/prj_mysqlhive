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
    private $idContext;
    private $sDb;
    
    private $oContext;
    private $oBehav;
    
    public function __construct($idContext="",$sDb="") 
    {
        $this->idContext = $idContext;
        $this->sDb = $sDb;
        
        $this->oContext = new ComponentContext($idContext);
        $oDb = DbFactory::get_dbobject_by_idctx($idContext);
        $this->oBehav = new SchemaBehaviour($oDb);
    }
    
    public function get_all()
    {
        return $this->oBehav->get_schemas();
    }
    
}//DbsService
