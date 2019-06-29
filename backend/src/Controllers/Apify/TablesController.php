<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Controllers\Apify\TablesController 
 * @file TablesController.php 1.0.0
 * @date 27-06-2019 18:17 SPAIN
 * @observations
 */
namespace App\Controllers\Apify;

use TheFramework\Helpers\HelperJson;
use App\Controllers\AppController;
use App\Services\Apify\TablesService;

class TablesController extends AppController
{
    
    public function __construct()
    {
        //captura trazas de la petición en los logs
        parent::__construct();
    }
    
    /**
     * ruta:    <dominio>/apify/tables/{id_context}/{database}
     *          <dominio>/apify/tables/{id_context}
     * Muestra los schemas
     */
    public function index()
    {
        $idContext = $this->get_get("id_context");
        $sDb = $this->get_get("dbname");

        $oServ = new TablesService($idContext,$sDb);
        $arJson = $oServ->get_all();

        $oJson = new HelperJson();
        if($oServ->is_error()) 
            $oJson->set_code(HelperJson::INTERNAL_SERVER_ERROR)->
                    set_error($oServ->get_errors())->
                    set_message("database error")->
                    show(1);

        $oJson->set_payload($arJson)->show();
    }//index

}//TablesController
