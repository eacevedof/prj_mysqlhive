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

use TheFramework\Helpers\HelperJson;
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
     * /apify/read?context=c&dbname=d
     */
    public function index()
    {
        //bugp();
        //print_r("ReaderController.index()");
        $idContext = $this->get_get("context");
        $sDb = $this->get_get("dbname");
        $arParts = $this->get_post("queryparts");
        

        $oServ = new ReaderService($idContext,$sDb);
        $oJson = new HelperJson();
//print_r($oServ->is_error());die;
        if($oServ->is_error())
            $oJson->set_code(HelperJson::INTERNAL_SERVER_ERROR)->
                    set_error($oServ->get_errors())->
                    show();

        $arJson = $oServ->get_read($arParts);
        $oJson->set_payload($arJson)->show();

    }//index

    /**
     * /apify/read/raw?context=c&dbname=d
     */
    public function raw()
    {
        //bugpg();
        print_r("ReaderController.raw()");
        $idContext = $this->get_get("context");
        $sDb = $this->get_get("dbname");

        $sSQL = $this->get_post("query");
        $oServ = new ReaderService($idContext,$sDb);

        $oJson = new HelperJson();
        if($oServ->is_error())
            return $oJson->set_code(HelperJson::INTERNAL_SERVER_ERROR)->set_errors($oServ->get_errors())->show();

        $arJson = $oServ->get_read_raw($sSQL);
        $oJson->set_payload($arJson)->show();
    }//raw
   

}//ReaderController
