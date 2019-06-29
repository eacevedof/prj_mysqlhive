<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Services\Apify\Mysql
 * @file ReaderService.php 1.0.0
 * @date 27-06-2019 17:55 SPAIN
 * @observations
 */
namespace App\Services\Apify;

use TheFramework\Components\Db\Context\ComponentContext;
use TheFramework\Components\Db\ComponentCrud;
use App\Services\AppService;
use App\Behaviours\SchemaBehaviour;
use App\Factories\DbFactory;


class ReaderService extends AppService
{
    private $idContext;
    private $sDb;
    
    private $oContext;
    private $oBehav;
    private $sSQL;
    
    public function __construct($idContext="",$sDb="") 
    {
        $this->idContext = $idContext;
        $this->sDb = $sDb;
        if(!$this->idContext)
            return $this->add_error("Error in context: $idContext");

        $this->oContext = new ComponentContext($idContext);
        $oDb = DbFactory::get_dbobject_by_idctx($idContext,$sDb);
        $this->oBehav = new SchemaBehaviour($oDb);
    }
    
    private function get_parsed_tosql($arParams)
    {
        $oCrud = new ComponentCrud();
        if(!isset($arParams["table"])) return $this->add_error("get_sql no table");
        if(!isset($arParams["fields"])) return $this->add_error("get_sql no fields");
        
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

    public function get_read_raw($sSQL)
    {
        $this->sSQL = $sSQL;
        return $this->oBehav->get_read_raw($sSQL);
    }
    
    public function get_read($arParams)
    {
        if(!$arParams)
            return $this->add_error("get_read No params");
        $sSQL = $this->get_parsed_tosql($arParams);
        //pr($sSQL);die;
        //pr($this->oBehav,"oBehav");
        $this->sSQL = $sSQL;
        return $this->oBehav->get_read_raw($sSQL);
    }
    
    public function get_sql(){return $this->sSQL;}

}//ReaderService
