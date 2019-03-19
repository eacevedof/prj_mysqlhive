<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Controllers\Dbs\B2CController 
 * @file B2CController.php 1.0.0
 * @date 15-01-2019 15:01 SPAIN
 * @observations
 */
namespace App\Controllers\Dbs;

use App\Controllers\AppController;
use App\Services\Dbs\B2CService;

class B2CController extends AppController
{
    
    public function __construct()
    {
        //captura trazas de la petición en los logs
        parent::__construct();
    }
    
    /**
     * ruta:    <dominio>/draco
     */
    public function index()
    {
        pr(__METHOD__);
        $oServ = new B2CService();
        $arTables = $oServ->generate_exp();
        pr($arTables,"Tablas tratadas");
    }//index
    
}//B2CController
