<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Controllers\Apify\FieldsController 
 * @file FieldsController.php 1.0.0
 * @date 27-06-2019 18:17 SPAIN
 * @observations
 */
namespace App\Controllers\Apify;

use TheFramework\Helpers\HelperJson;
use App\Controllers\AppController;
use App\Services\Apify\FieldsService;

class FieldsController extends AppController
{
    
    public function __construct()
    {
        //captura trazas de la petición en los logs
        parent::__construct();
    }
    
    /**
     * /apify/fields/{id_context}/{database}/{tablename}/{fieldname}
     * /apify/fields/{id_context}/{database}/{tablename}
     * Muestra los schemas
     */
    public function index()
    {
        $idContext = $this->get_get("id_context");
        $sDb = $this->get_get("dbname");
        $sTableName = $this->get_get("tablename");
        $sFieldName = $this->get_get("fieldname");

        $oServ = new FieldsService($idContext,$sDb,$sTableName,$sFieldName);
        if($sFieldName)
            $arJson = $oServ->get_field($sTableName,$sFieldName);
        else
            $arJson = $oServ->get_all($sTableName);

        $oJson = new HelperJson();
        if($oServ->is_error()) 
            $oJson->set_code(HelperJson::INTERNAL_SERVER_ERROR)->
                    set_error($oServ->get_errors())->
                    set_message("database error")->
                    show(1);

        $oJson->set_payload($arJson)->show();
    }//index

}//FieldsController
