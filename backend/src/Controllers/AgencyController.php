<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Controllers\AgencyController 
 * @file AgencyController.php 1.0.0
 * @date 15-01-2019 15:01 SPAIN
 * @observations
 */
namespace App\Controllers;

use App\Controllers\AppController;
use App\Services\EmployeeService;

class AgencyController extends AppController
{
    
    public function __construct()
    {
        //captura trazas de la petición en los logs
        parent::__construct();
    }
    
    /**
     * ruta:    <dominio>/agency
     *          <dominio>/employees?page={n}
     * listado de empleados
     */
    public function index()
    {

    }//index


}//AgencyController
