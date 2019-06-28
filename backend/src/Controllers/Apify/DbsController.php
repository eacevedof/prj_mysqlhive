<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Controllers\Apify\DbsController 
 * @file DbsController.php 1.0.0
 * @date 27-06-2019 18:17 SPAIN
 * @observations
 */
namespace App\Controllers\Apify;

use App\Controllers\AppController;
use App\Services\Apify\DbsService;

class DbsController extends AppController
{
    
    public function __construct()
    {
        //captura trazas de la petición en los logs
        parent::__construct();
    }
    
    /**
     * ruta:    <dominio>/apify/contexts/{id}
     * Muestra los schemas
     */
    public function index()
    {
        $idContext = $this->get_get("id_context");
        $oDbs = new DbsService($idContext);
        $arData = $oDbs->get_schemas();
        $this->response_json($arData);
    }//index
    
    /**
     * ruta:    <dominio>/apify/dbs/{id_context}
     */    
    public function get_tables()
    {
        $idContext = $this->get_get("id_context");
        $sDb = $this->get_get("database");
        $sTablename = $this->get_get("tablename");
        $this->response_json($arData);
    }//index
        
    
    
}//DbsController
