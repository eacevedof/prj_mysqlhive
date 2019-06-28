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
        $sDb = $this->get_get("database");
        $sTableName = $this->get_get("tablename");
        $sFieldName = $this->get_get("fieldname");

        $oService = new FieldsService($idContext,$sDb,$sTableName,$sFieldName);
        if($sFieldName)
            $arData = $oService->get_field_info($sTableName,$sFieldName);
        else
            $arData = $oService->get_all($sTableName);
        $this->response_json($arData);
    }//index

}//FieldsController
