<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Controllers\Apify\WriterController 
 * @file WriterController.php 1.0.0
 * @date 27-06-2019 18:17 SPAIN
 * @observations
 */
namespace App\Controllers\Apify;

use TheFramework\Helpers\HelperJson;
use App\Controllers\AppController;
use App\Services\Apify\WriterService;

class WriterController extends AppController
{
    
    public function __construct()
    {
        //captura trazas de la petición en los logs
        parent::__construct();
    }
    
    /**
     * /apify/write/
     */
    public function index()
    {
        $idContext = $this->get_get("id_context");
        $sDb = $this->get_get("dbname");
        
        $oServ = new WriterService($idContext,$sDb);

        $oJson = new HelperJson();
        if($oServ->is_error()) 
            $oJson->set_code(HelperJson::INTERNAL_SERVER_ERROR)->
                    set_error($oServ->get_errors())->
                    set_message("database error")->
                    show(1);

        $oJson->set_payload($arJson)->show();
    }//index

    /**
     * /apify/write/raw?context=c&dbname=d
     */
    public function raw()
    {
        $idContext = $this->get_get("id_context");
        $sDb = $this->get_get("dbname");
        
        $oServ = new WriterService($idContext,$sDb);

        $oJson = new HelperJson();
        if($oServ->is_error()) 
            $oJson->set_code(HelperJson::INTERNAL_SERVER_ERROR)->
                    set_error($oServ->get_errors())->
                    set_message("database error")->
                    show(1);

        $oJson->set_payload($arJson)->show();
    }//raw    
    
}//WriterController
