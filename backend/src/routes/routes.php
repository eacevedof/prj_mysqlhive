<?php
//<project>\backend\src\routes\routes.php
//mapeo de rutas y controladores

return [   
    ["url"=>"/","controller"=>"App\Controllers\NotFoundController","method"=>"index"],
    ["url"=>"/agency","controller"=>"App\Controllers\Dbs\AgencyController","method"=>"index"],
    ["url"=>"/agency/","controller"=>"App\Controllers\Dbs\AgencyController","method"=>"index"],
    ["url"=>"/agency/movebuildcfg","controller"=>"App\Controllers\Dbs\AgencyController","method"=>"movebuildcfg"],
    ["url"=>"/draco","controller"=>"App\Controllers\Dbs\DracoController","method"=>"index"],
    ["url"=>"/draco/","controller"=>"App\Controllers\Dbs\DracoController","method"=>"index"],
    ["url"=>"/rtb","controller"=>"App\Controllers\Dbs\RtbController","method"=>"index"],
    ["url"=>"/rtb/","controller"=>"App\Controllers\Dbs\RtbController","method"=>"index"],
    ["url"=>"/metrics","controller"=>"App\Controllers\Tc\MetricsController","method"=>"index"],
    ["url"=>"/metrics/","controller"=>"App\Controllers\Tc\MetricsController","method"=>"index"],    
    ["url"=>"/logs","controller"=>"App\Controllers\LogsController","method"=>"index"],

//resto de rutas    
    ["url"=>"/404","controller"=>"App\Controllers\NotFoundController","method"=>"error_404"]
];
