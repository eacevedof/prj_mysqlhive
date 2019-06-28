<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Behaviours\SchemaBehaviour 
 * @file SchemaBehaviour.php v1.0.0
 * @date 29-11-2018 19:00 SPAIN
 * @observations
 */
namespace App\Behaviours;

use App\Models\AppModel;
use App\Services\Dbs\CoreQueriesService;

class SchemaBehaviour extends AppModel
{
    private $oQServ;
    
    public function __construct($oDb=NULL) 
    {
        parent::__construct($oDb);
        $this->oQServ = new CoreQueriesService();
    }
    
    public function query($sSQL,$iCol=NULL,$iRow=NULL)
    {
        return $this->oDb->query($sSQL,$iCol,$iRow);
    }
    
    public function get_schemas()
    {
        $sSQL = "SHOW DATABASES";
        return $this->query($sSQL);
    }
    
    public function get_tables($sDb="")
    {
        if(!$sDb)
            $sDb = $this->get_config("db","database");
        $sSQL = $this->oQServ->get_tables($sDb);
        //bug($sSQL);
        $arRows = $this->query($sSQL,0);
        //bug($arRows);
        return $arRows;
    }
    
    public function get_table($sTable,$sDb="")
    {
        if(!$sDb)
            $sDb = $this->get_config("db","database");
        $sSQL = $this->oQServ->get_tables($sDb,$sTable);
        //bug($sSQL);
        $arRows = $this->query($sSQL,0);
        //bug($arRows);
        return $arRows;        
    }
   
    public function get_fields_info($sTable,$sDb="")
    {
        if(!$sDb)
            $sDb = $this->get_config("db","database");
        $sSQL = $this->oQServ->get_fields($sDb,$sTable);
        $arRows = $this->query($sSQL);
        //bug($arRows);die;
        return $arRows;
    }

}//SchemaBehaviour
