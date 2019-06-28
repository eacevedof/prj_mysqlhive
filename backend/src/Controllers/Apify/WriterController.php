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

use App\Controllers\AppController;
use App\Services\Apify\FieldsService;

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
        $sDb = $this->get_get("database");

    }//index

}//WriterController
