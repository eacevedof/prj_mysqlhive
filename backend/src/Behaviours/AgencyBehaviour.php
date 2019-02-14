<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Behaviours\AgencyBehaviour 
 * @file AgencyBehaviour.php v1.0.0
 * @date 29-11-2018 19:00 SPAIN
 * @observations
 */
namespace App\Behaviours;

use App\Models\AppModel;
use App\Services\Dbs\CoreQueriesService;

class AgencyBehaviour extends AppModel
{
    private $oQServ;
    
    public function __construct() 
    {
        parent::__construct();
        $this->oQServ = new CoreQueriesService();
    }
    
    public function query($sSQL,$iCol=NULL,$iRow=NULL)
    {
        return $this->oDb->query($sSQL,$iCol,$iRow);
    }
    
    public function get_tables()
    {
        $sDb = $this->get_config("db","database");
        $sSQL = $this->oQServ->get_tables($sDb);
        //bug($sSQL);
        $arRows = $this->query($sSQL,0);
        //bug($arRows);
        return $arRows;
    }
    
    public function get_table($sTable)
    {
        $sDb = $this->get_config("db","database");
        $sSQL = $this->oQServ->get_tables($sDb,$sTable);
        //bug($sSQL);
        $arRows = $this->query($sSQL,0);
        //bug($arRows);
        return $arRows;        
    }
   
    public function get_fields_info($sTable)
    {
        $sDb = $this->get_config("db","database");
        $sSQL = $this->oQServ->get_fields($sDb,$sTable);
        $arRows = $this->query($sSQL);
        //bug($arRows);die;
        return $arRows;
    }

}//AgencyBehaviour
