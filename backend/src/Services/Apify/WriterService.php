<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Services\Apify\Mysql
 * @file WriterService.php 1.0.0
 * @date 27-06-2019 17:55 SPAIN
 * @observations
 */
namespace App\Services\Apify;

use TheFramework\Components\Db\Context\ComponentContext;
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
        
        $this->oContext = new ComponentContext($idContext);
        $oDb = DbFactory::get_dbobject_by_idctx($idContext);
        $this->oBehav = new SchemaBehaviour($oDb);
        $this->arActions = ["insert","update","delete","drop","alter"];
    }
        
    private function get_insert_sql($arParams)
    {
        $oCrud = new ComponentCrud();
        if(!isset($arParams["table"])) $this->add_error("get_insert_sql no table");
        if(!isset($arParams["fields"])) $this->add_error("get_insert_sql no fields");
        if($this->isError) return;

        $oCrud->set_table($arParams["table"]);
        $oCrud->set_getfields($arParams["fields"]);
        $oCrud->set_joins($arParams["joins"]);
        $oCrud->set_and($arParams["where"]);
        $oCrud->set_groupby($arParams["groupby"]);

        $arTmp = [];
        if(isset($arParams["orderby"]))
        {
            foreach($arParams["orderby"] as $sField)
            {
                $arField = explode(" ",trim($sField));
                $arTmp[$arField[0]] = isset($arField[1])?$arField[1]:"ASC";
            }
        }
        $oCrud->set_orderby($arTmp);
        $oCrud->get_selectfrom();
        return $oCrud->get_sql();
    }

    private function parse_update($arParams)
    {
        
    }    



    private function get_parsed_tosql($arParams)
    {
        if(!isset($arParams["action"])) return $this->add_error("get_parsed_tosql no param action");
        if(in_array($arParams["action"],$this->arActions)) return $this->add_error("action: {$arParams["action"]} not found!");
                
        $sAction = $arParams["action"];

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

    public function write($arParams)
    {
        $sSQL = $this->get_parsed_tosql($arParams);
        return $this->write_raw($sSQL);        
    }
    
    public function write_raw($sSQL)
    {
        if(!$this->is_error)
            return $this->oBehav->write_raw($sSQL);
        return -1;
    }
    
}//WriterService
