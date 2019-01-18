<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Controllers\Dbs\DracoController 
 * @file DracoController.php 1.0.0
 * @date 15-01-2019 15:01 SPAIN
 * @observations
 */
namespace App\Controllers\Dbs;

use App\Controllers\AppController;
use App\Services\Dbs\DracoService;

class DracoController extends AppController
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
        $oServ = new DracoService();
        $arTables = $oServ->generate_exp();
        pr($arTables,"Tablas tratadas");
    }//index
    
}//DracoController
