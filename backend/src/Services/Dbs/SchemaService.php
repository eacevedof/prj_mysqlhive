<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Services\Dbs\SchemaService 
 * @file SchemaService.php 1.0.0
 * @date 28-01-2019 19:00 SPAIN
 * @observations
 */
namespace App\Services\Dbs;

use App\Behaviours\SchemaBehaviour;

class SchemaService 
{
    private $oBehav;
    
    public function __construct() 
    {
        $this->oBehav = new SchemaBehaviour();
    }
    
    protected function get_tables()
    {
        //$arReturn = [];
        $arReturn = $this->oBehav->get_tables();
        return $arReturn;
    }

    protected function get_fields_info($sTable)
    {
        $arReturn = $this->oBehav->get_fields_info($sTable);
        return $arReturn;
    }
        
}//SchemaService
