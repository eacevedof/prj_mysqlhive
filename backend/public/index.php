<?php
//index.php 3.1.0
define("DS",DIRECTORY_SEPARATOR);
define("DOCROOT",$_SERVER["DOCUMENT_ROOT"]);
$sPath = realpath(DOCROOT.DS."../src");
define("PATH_SRC",$sPath);
define("PATH_SRC_CONFIG",PATH_SRC.DS."config");
$sPath = realpath(DOCROOT.DS."../public");
define("PATH_PUBLIC",$sPath);
$sPath = realpath(DOCROOT.DS."../vendor");
define("PATH_VENDOR",$sPath);
$sPath = realpath(PATH_SRC.DS."logs");
define("PATH_LOGS",$sPath);

//echo(PATH_SRC_CONFIG);
$arConfig = realpath(PATH_SRC_CONFIG.DS."config.php");
//echo $arConfig; die;
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

//Código de configuración de cabeceras que permiten consumir la API desde cualquier origen
//fuente: https://stackoverflow.com/questions/14467673/enable-cors-in-htaccess
// Allow from any origin
if(isset($_SERVER["HTTP_ORIGIN"])) 
{
    //should do a check here to match $_SERVER["HTTP_ORIGIN"] to a
    //whitelist of safe domains
    header("Access-Control-Allow-Origin: {$_SERVER["HTTP_ORIGIN"]}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if($_SERVER["REQUEST_METHOD"] == 'OPTIONS')
{
    if(isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"]))
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");         

    if(isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]))
        header("Access-Control-Allow-Headers: {$_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]}");
}

//autoload de composer
include_once '../vendor/autoload.php';
//arranque de mis utilidades
include_once '../vendor/theframework/bootstrap.php';
//rutas, mapeo de url => controlador.metodo()
$arRoutes = include_once '../src/routes/routes.php';

use TheFramework\Components\ComponentRouter;
$oR = new ComponentRouter($arRoutes);
$arRun = $oR->get_rundata();
//limpio las rutas
unset($arRoutes);

//con el controlador devuelto en $arRun lo instancio
$oController = new $arRun["controller"]();
//ejecuto el método asociado
$oController->{$arRun["method"]}();
