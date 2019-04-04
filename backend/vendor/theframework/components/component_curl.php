<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheApplication\Components\ComponentCurl 
 * @file ComponentCurl.php 1.0.0
 * @date 04-04-2019 10:10 SPAIN
 * @observations
 */
namespace TheFramework\Components;

class ComponentCurl 
{
    const DS = DIRECTORY_SEPARATOR;
    
    private $sRootUrl;
    private $arOptions;
    private $arGetFields;
    private $arPostFields;
    private $arResult;
    
    public function __construct($sRootUrl="") 
    {
        if($sRootUrl) 
            $this->sRootUrl = $sRootUrl;
        $this->arOptions = [];
        $this->arPostFields = [];
        $this->arGetFields = [];
        $this->arResult = [];
    }
    
    private function _is_in_options($sK){return isset($this->arOptions[$sK]);}
    
    private function _get_opturl()
    {
        $sUrl = "";
        if($this->sRootUrl) $sUrl = $this->sRootUrl;
        if($this->_is_in_options(CURLOPT_URL)) 
            $sUrl = $this->arOptions[CURLOPT_URL];
        
        
        $sUrl .= "?";
        $arGet = [];
        foreach($arGet as $k=>$v)
            $arGet[]="$k=$v";
        $sUrl .= implode("&",$arGet);
        return $sUrl;
    }


    public function get_result()
    {
        $oCurl = curl_init();
        $sUrl = $this->_get_opturl();
        if($sUrl) curl_setopt($oCurl, CURLOPT_URL, $sUrl);
        
        foreach($this->arOptions as $sK =>$mxV)
        {
            if(in_array($mxV,[CURLOPT_POST,CURLOPT_POSTFIELDS]))
                continue;
            curl_setopt($oCurl, $sK, $mxV);
        }

        if($this->arPostFields)
        {
            curl_setopt($oCurl, CURLOPT_POST, 1);
            curl_setopt($oCurl, CURLOPT_POSTFIELDS, $this->arPostFields);
        }

        $this->arResult["curl_exec"] = curl_exec($oCurl);
        $this->arResult["curl_getinfo"][CURLINFO_HTTP_CODE] = curl_getinfo($oCurl,CURLINFO_HTTP_CODE);
        
        print_r($this->arResult);
        return $this->arResult;
    }


    public function set_rooturl($sUrl){$this->sRootUrl = $sUrl;}

    public function set_postfield($sKey=NULL,$sValue=NULL){if(!$sKey) $this->arPostFields=[]; if($sKey) $this->arPostFields[$sKey]=$sValue;}
    public function add_postfield($sKey,$sValue){$this->arPostFields[$sKey]=$sValue;}
    
    public function set_getfield($sKey=NULL,$sValue=NULL){if(!$sKey) $this->arGetFields=[]; if($sKey) $this->arGetFields[$sKey]=$sValue;}
    public function add_getfield($sKey,$sValue){$this->arGetFields[$sKey]=$sValue;}    
            
    public function set_options($sKey=NULL,$sValue=NULL){if(!$sKey) $this->arOptions=[]; if($sKey) $this->arOptions[$sKey]=$sValue;}
    public function add_option($sKey,$sValue){$this->arOptions[$sKey]=$sValue;}
  
    
}//ComponentCurl