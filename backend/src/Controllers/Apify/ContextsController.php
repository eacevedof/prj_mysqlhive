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
     * ruta:    <dominio>/agency
     */
    public function index()
    {
        pr(__METHOD__);
        $oServ = new ContextService("");
        pr($oServ->get_noconfig());

    }//index
    
}//ContextsController
