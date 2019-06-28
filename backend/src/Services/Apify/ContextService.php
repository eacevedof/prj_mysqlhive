<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Services\Apify\Mysql
 * @file ContextService.php 1.0.0
 * @date 27-06-2019 17:55 SPAIN
 * @observations
 */
namespace App\Services\Apify;

use App\Services\AppService;
use TheFramework\Components\Db\Context\ComponentContext;

class ContextService extends AppService
{
    private $oContext;
    private $idContext;
    
    public function __construct($sPathcontext="",$idContext="") 
    {
        $this->oContext = new ComponentContext($sPathcontext,$idContext);
    }
    
    public function get_context_by_id($id){return $this->oContext->get_by("id", $id);}
    public function get_noconfig(){return $this->oContext->get_noconfig();}
    public function get_noconfig_by_id($id){return $this->oContext->get_noconfig_by("id",$id);}    
    
}//ContextService
