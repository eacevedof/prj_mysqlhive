<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Services\Dbs\CoreQueriesService 
 * @file CoreQueriesService.php 1.0.0
 * @date 15-01-2018 19:00 SPAIN
 * @observations
 */
namespace App\Services\Dbs;

use App\Services\AppService;

class CoreQueriesService extends AppService
{
    
    public function get_fields($sDb,$sTable)
    {
        $sSQL = 
        "/*CoreQueriesService.get_fields*/
        SELECT DISTINCT LOWER(column_name) AS field_name
        ,LOWER(DATA_TYPE) AS field_type
        ,character_maximum_length AS field_length
        FROM information_schema.columns 
        WHERE table_name='$sTable'
        AND table_schema='$sDb'
        AND column_name NOT IN
        (
            'delete_date','delete_user'
            ,'is_erpsent','i','cru_csvnote'
            ,'insert_platform','processflag'            
        )
        ORDER BY ordinal_position ASC";
        return $sSQL;
    }//get_fields
    
    public function get_tables($sDb)
    {
        $sSQL = "
        /*CoreQueriesService.get_tables*/
        SELECT table_name 
        FROM information_schema.tables 
        WHERE table_schema='$sDb'";
        return $sSQL;        
    }//get_tables
    
    
    
}//CoreQueriesService
