<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Controllers\Apify\ReaderController 
 * @file ReaderController.php 1.0.0
 * @date 27-06-2019 18:17 SPAIN
 * @observations
 */
namespace App\Controllers\Apify;

use App\Controllers\AppController;
use App\Services\Apify\ReaderService;

class ReaderController extends AppController
{
    
    public function __construct()
    {
        //captura trazas de la petición en los logs
        parent::__construct();
    }
    
    
    /**
     * /apify/read/
     */
    public function index()
    {
        //bugpg();
        print_r("ReaderController.index()");
        $idContext = $this->get_get("id_context");
        $sDb = $this->get_get("database");

        $sSQL = $this->get_post("query");
        $oServ = new ReaderService($idContext,$sDb);
        $arJson = $oServ->get_read($sSQL);
        $this->response_json($arJson);

    }//index

    public function raw()
    {
        //bugpg();
        print_r("ReaderController.raw()");
        $idContext = $this->get_get("id_context");
        $sDb = $this->get_get("database");

        $sSQL = $this->get_post("query");
        $oServ = new ReaderService($idContext,$sDb);
        $arJson = $oServ->get_read_raw($sSQL);
        $this->response_json($arJson);

    }//raw
   

}//ReaderController
