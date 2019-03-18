<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Controllers\Dbs\MetricsController 
 * @file MetricsController.php 1.0.0
 * @date 15-01-2019 15:01 SPAIN
 * @observations
 */
namespace App\Controllers;

use App\Controllers\AppController;
use App\Services\Tc\MetricService;

class MetricsController extends AppController
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

    }//index
    
    public function movebuildcfg()
    {
        pr(__METHOD__);
        $oServ = new MetricService();
        pr("Archivos movidos ");
    }
    
}//MetricsController
