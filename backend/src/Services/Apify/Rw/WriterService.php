<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Services\Apify\Mysql
 * @file WriterService.php 1.0.0
 * @date 30-06-2019 12:42 SPAIN
 * @observations
 */
namespace App\Services\Apify\Rw;

use TheFramework\Components\Db\Context\ComponentContext;
use TheFramework\Components\Db\ComponentCrud;
use App\Services\AppService;
use App\Behaviours\SchemaBehaviour;
use App\Factories\DbFactory;

class WriterService extends AppService
{
    private $idContext;
    private $sDb;
    private $arParams;
    private $sFieldName;
    
    private $oContext;
    private $oBehav;
    
    private $arActions;

    public function __construct($idContext="",$sDb="") 
    {
        $this->idContext = $idContext;
        $this->sDb = $sDb;
        
        $this->oContext = new ComponentContext(AppService::PATH_CONTEXTSS_JSON,$idContext);
        $oDb = DbFactory::get_dbobject_by_ctx($this->oContext,$sDb);
        $this->oBehav = new SchemaBehaviour($oDb);
        $this->arActions = ["insert","update","delete","drop","alter"];
    }
        
    private function get_parsed_tosql($arParams,$sAction)
    {
        if(!isset($sAction)) return $this->add_error("get_parsed_tosql no param action");
        if(!in_array($sAction,$this->arActions)) return $this->add_error("action: {$sAction} not found!");

        switch ($sAction) {
            case "insert":
                $sSQL = $this->get_insert_sql($arParams);
            break;
            case "update":
                $sSQL = $this->get_update_sql($arParams);
            break;   
            case "delete":
                $sSQL = $this->get_delete_sql($arParams);
            break;
            default:
                return $this->add_error("get_parsed_tosql","action: $sAction not implemented!");
        }
        return $sSQL;
    }

    private function get_insert_sql($arParams)
    {
        $oCrud = new ComponentCrud();
        if(!isset($arParams["table"])) return $this->add_error("get_insert_sql no table");
        if(!isset($arParams["fields"])) return $this->add_error("get_insert_sql no fields");

        $oCrud->set_table($arParams["table"]);
        foreach($arParams["fields"] as $sFieldName=>$sFieldValue)
        {
            //print_r($arField);die;
            //$sFieldName = array_keys($arField)[0];
            //$sFieldValue = $arField[$sFieldName];
            $oCrud->add_insert_fv($sFieldName,$sFieldValue);
        }
        $oCrud->autoinsert();
        
        return $oCrud->get_sql();
    }

    private function get_delete_sql($arParams)
    {
        $oCrud = new ComponentCrud();
        if(!isset($arParams["table"])) return $this->add_error("get_delete_sql no table");

        $oCrud->set_table($arParams["table"]);
        if(isset($arParams["where"]))
            foreach($arParams["where"] as $sWhere)
            {
                $oCrud->add_and($sWhere);
            }        
        $oCrud->autodelete();
        $sSQL = $oCrud->get_sql();
        
        return $sSQL;      
    }//get_delete_sql

    private function get_update_sql($arParams)
    {
        $oCrud = new ComponentCrud();
        if(!isset($arParams["table"])) return $this->add_error("get_update_sql no table");
        if(!isset($arParams["fields"])) return $this->add_error("get_update_sql no fields");
        //if(!isset($arParams["pks"])) return $this->add_error("get_update_sql no pks");

        $oCrud->set_table($arParams["table"]);
        foreach($arParams["fields"] as $sFieldName=>$sFieldValue)
        {
            $oCrud->add_update_fv($sFieldName,$sFieldValue);
        }
        
        if(isset($arParams["pks"]))
            foreach($arParams["pks"] as $sFieldName=>$sFieldValue)
            {
                $oCrud->add_pk_fv($sFieldName,$sFieldValue);
            }        

        if(isset($arParams["where"]))
            foreach($arParams["where"] as $sWhere)
            {
                $oCrud->add_and($sWhere);
            }        

        $oCrud->autoupdate();
        $sSQL = $oCrud->get_sql();
        //pr($sSQL);die;
        return $sSQL;
    }//get_update_sql    

    public function write_raw($sSQL)
    {
        if(!$this->isError)
        {
            $r = $this->oBehav->write_raw($sSQL);
            if($this->oBehav->is_error())
                $this->add_error($this->oBehav->get_errors());
            return $r;
        }
        return -1;
    }
    
    public function write($arParams,$sAction)
    {
        $sSQL = $this->get_parsed_tosql($arParams,$sAction);
        return $this->write_raw($sSQL);        
    }

}//WriterService
