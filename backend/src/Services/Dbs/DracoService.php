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
Las nuevas dimensiones para este report son:
di_clientes se alimenta de la tabla draco_clientes
di_plataformas se alimenta de la tabla draco_grupos_enlaces

También hay que usar estas tablas de soporte:
draco_tarifas_operador_info
draco_tarifas_operador_info
draco_numeracion_ordenes

Todas las tablas de origen están en la bbdd operacional draco.
        */
        $arDiTables = ["draco_clientes","draco_grupos_enlaces","draco_tarifas_operador_info"
            ,"draco_numeracion_ordenes"];
        
        $arTables = $this->get_tables();
        foreach($arTables as $i=>$sTable)
            if(!in_array($sTable,$arDiTables))
                unset($arTables[$i]);
        
        $this->process_tables($arTables);
        
        return $arTables;
    }//generate_exp
    
}//DracoService
