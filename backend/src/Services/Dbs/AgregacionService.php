<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Services\Dbs\AgregacionService 
 * @file AgregacionService.php 1.0.0
 * @date 28-01-2019 19:00 SPAIN
 * @observations
 */
namespace App\Services\Dbs;

use App\Services\AppService;

class AgregacionService extends AppService
{
    public function __construct() 
    {
        parent::__construct();
    }
    
    
    public function run()
    {
        print_r("AgregacionService.run");
    }
        
}//AgregacionService
