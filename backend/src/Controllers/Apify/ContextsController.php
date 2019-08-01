<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Controllers\Apify\ContextsController 
 * @file ContextsController.php 1.0.0
 * @date 27-06-2019 18:17 SPAIN
 * @observations
 */
namespace App\Controllers\Apify;

use TheFramework\Helpers\HelperJson;
use App\Controllers\AppController;
use App\Services\Apify\ContextService;

class ContextsController extends AppController
{
    
    public function __construct()
    {
        //captura trazas de la petición en los logs
        parent::__construct();
    }
    
    /**
     * ruta:
     *  <dominio>/apify/contexts
     *  <dominio>/apify/contexts/{id}
     */
    public function index()
    {
        $oServ = new ContextService();
        $arJson = $oServ->get_noconfig();

        if($this->is_get("id"))
            $arJson = $oServ->get_noconfig_by_id($this->get_get("id"));
        
        $oJson = new HelperJson();
        if($oServ->is_error()) 
            $oJson->set_code(HelperJson::CODE_INTERNAL_SERVER_ERROR)->
                    set_error($oServ->get_errors())->
                    set_message("database error")->
                    show(1);

        $oJson->set_payload($arJson)->show();

    }//index
    
}//ContextsController
