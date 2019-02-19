<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Controllers\Dbs\RtbController 
 * @file RtbController.php 1.0.0
 * @date 19-02-2019 11:57 SPAIN
 * @observations
 */
namespace App\Controllers\Dbs;

use App\Controllers\AppController;
use App\Services\Dbs\RtbService;

class RtbController extends AppController
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
        $oServ = new RtbService();
        $arTables = $oServ->generate_exp();
        pr($arTables,"Tablas tratadas");
    }//index
    
}//RtbController
