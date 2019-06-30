<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Services\AppService 
 * @file AppService.php 1.0.0
 * @date 29-11-2018 19:00 SPAIN
 * @observations
 * @tags: #apify
 */
namespace App\Services;

use App\Traits\AppConfigTrait;
use App\Traits\AppErrorTrait;
use App\Traits\AppLogTrait;

class AppService 
{
    use AppConfigTrait;
    use AppErrorTrait;
    use AppLogTrait;
    
    public function __construct(){;}
 
    public function trim(&$arPost)
    {
        foreach($arPost as $sKey=>$sValue)
            $arPost[$sKey] = trim($sValue);
    }
}//AppService
