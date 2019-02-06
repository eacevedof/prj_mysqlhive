<?php
//index.php 3.0.0
define("DS",DIRECTORY_SEPARATOR);
$sPath = realpath($_SERVER["DOCUMENT_ROOT"].DS."../src");
define("PATH_SRC",$sPath);
define("PATH_SRC_CONFIG",PATH_SRC.DS."config");
$sPath = realpath($_SERVER["DOCUMENT_ROOT"].DS."../public");
define("PATH_PUBLIC",$sPath);
$sPath = realpath($_SERVER["DOCUMENT_ROOT"].DS."../vendor");
define("PATH_VENDOR",$sPath);
$sPath = realpath(PATH_SRC.DS."logs");
define("PATH_LOGS",$sPath);

//echo(PATH_SRC);die;

$arConfig = realpath(__DIR__."/../src/config/config.php");
include($arConfig);

//DOCUMENT_ROOT:es la carpeta public
//echo $_SERVER["DOCUMENT_ROOT"];die;
//si se está en producción se desactivan los mensajes en el navegador
if(ENV=="p")
{
    $sToday = date("Ymd");
    ini_set("display_errors",0);
    ini_set("log_errors",1);
    //Define where do you want the log to go, syslog or a file of your liking with
    ini_set("error_log","{$_SERVER["DOCUMENT_ROOT"]}/../src/logs/sys_$sToday.log"); // or ini_set("error_log", "/path/to/syslog/file")
}

//autoload de composer
include_once '../vendor/autoload.php';
//arranque de mis utilidades
include_once '../vendor/theframework/bootstrap.php';

function arguments($argv) {
    $_ARG = array();
    foreach ($argv as $arg_i) 
    {
        if (ereg('--([^=]+)=(.*)',$arg_i,$arKeyVal)) {
            $_ARG[$arKeyVal[1]] = $arKeyVal[2];
        } 
        elseif(ereg('-([a-zA-Z0-9])',$arg_i,$arKeyVal)) {
            $_ARG[$arKeyVal[1]] = 'true';
        }
    }
    return $_ARG;
}

$isCLI = (php_sapi_name() == "cli");
if($isCLI)
{
    print_r($argv);
}
else
    echo "";