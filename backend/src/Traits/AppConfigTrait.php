<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Traits\AppConfigTrait 
 * @file AppConfigTrait.php 1.0.0
 * @date 01-11-2018 19:00 SPAIN
 * @observations
 */
namespace App\Traits;

trait AppConfigTrait 
{
    protected function get_config($sKey1="db",$sKey2=NULL)
    {
        //config db
        $arConfig = realpath(PATH_SRC_CONFIG.DS."config.php");
        $arConfig = include($arConfig);
        if(isset($arConfig[$sKey1][$sKey2])) return $arConfig[$sKey1][$sKey2];
        if(isset($arConfig[$sKey1])) return $arConfig[$sKey1];
        return $arConfig;
    }
}//AppConfigTrait
