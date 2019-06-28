<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheApplication\Components\ComponentRouter 
 * @file ComponentRouter.php 1.0.0
 * @date 28-06-2019 08:19 SPAIN
 * @observations
 */
namespace TheFramework\Components;

class ComponentRouter 
{
    const DS = DIRECTORY_SEPARATOR;
    
    private $sRequestUri;
    private $sPathRoutes;
    private $arRoutes;
    private $arPieces;
        
    public function __construct($arRoutes=[],$sPathRoutes="") 
    {
        $this->sRequestUri = $_SERVER["REQUEST_URI"];
        $this->sPathRoutes = $sPathRoutes;
        $this->arRoutes = $arRoutes;
        $this->load_routes();
        $this->load_pieces();
        print_r($this->sRequestUri);
        print_r($this->arPieces);
    }
    
    private function load_routes()
    {
        if(!$this->arRoutes)
        {
            if($this->sPathRoutes)
            {
                $this->arRoutes = include($this->sPathRoutes);
            }
        }
    }

    private function load_pieces()
    {
        $arGet = $this->get_get_params($this->sRequestUri);
        $arUrlsep = $this->get_urlsep_params($this->sRequestUri);
        $this->arPieces["urlsep"] = $arUrlsep;
        $this->arPieces["get_params"] = $arGet;
    }
    
    private function explode_and($sAndstring)
    {
        $arRet = [];
        $arTmp = explode("&",$sAndstring);
        foreach($arTmp as $sEq)
        {
            $arParamVal = explode("=",$sEq);
            $arRet[$arParamVal[0]] = isset($arParamVal[1])?$arParamVal[1]:"";
        }
        return $arRet;
    }
    
    private function get_get_params($sUrl)
    {
        $arTmp = explode("?",$sUrl);
        if(!isset($arTmp[1])) return [];
        $arParams = $this->explode_and($arTmp[1]);
        return $arParams;
    }
    
    private function unset_empties(&$arPieces)
    {
        foreach($arPieces as $i=>$sValue)
            if(!$sValue)
                unset($arPieces[$i]);
    }
    
    private function get_urlsep_params($sUrl)
    {
        $arTmp = explode("?",$sUrl);
        if(isset($arTmp[1])) $sUrl = $arTmp[0];
        $arPieces = explode("/",$sUrl);
        //pr($arPieces);
        $this->unset_empties($arPieces);
        return $arPieces;
    }    
    
    
    
}//ComponentRouter