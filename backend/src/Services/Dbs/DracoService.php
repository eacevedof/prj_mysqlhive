<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Services\Dbs\DracoService 
 * @file DracoService.php 1.0.0
 * @date 15-01-2018 19:00 SPAIN
 * @observations
 */
namespace App\Services\Dbs;

use App\Services\Dbs\DbsService;

class DracoService extends DbsService
{
   
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function generate_exp()
    {
/*
+-----------------------------+------------------------------------------------+--------------------------------+-------+-------------------+
|         operacional         |                    staging                     |             sta_1              | sta_2 |        dw         |
+-----------------------------+------------------------------------------------+--------------------------------+-------+-------------------+
| draco_clientes              | staging_tables.di_clientes                     |                                |       | dw.di_clientes    |
| draco_grupos_enlaces        | staging_tables.di_plataformas_incremental_temp |                                |       | dw.di_plataformas |
| draco_tarifas_operador_info | staging_tables.di_tarifas_incremental_temp     |                                |       | dw.di_tarifas     |
| draco_numeracion_ordenes    |                                                | sta_1.draco_numeracion_ordenes |       |                   |
+-----------------------------+------------------------------------------------+--------------------------------+-------+-------------------+
*/        
        $arDiTables = [
            //"",
            //"draco_clientes",
            //"draco_grupos_enlaces",
            "draco_tarifas_operador",            
            "draco_tarifas_operador_info",
            "draco_numeracion_ordenes",
        ];
        
        $arTables = $this->get_tables();
        foreach($arTables as $i=>$sTable)
            if(!in_array($sTable,$arDiTables))
                unset($arTables[$i]);
        
        $this->process_tables($arTables);
        
        return $arTables;
    }//generate_exp
    
}//DracoService
