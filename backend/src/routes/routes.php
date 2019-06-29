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
    ["url"=>"/b2c","controller"=>"App\Controllers\Dbs\B2CController","method"=>"index"],
    ["url"=>"/b2c/","controller"=>"App\Controllers\Dbs\B2CController","method"=>"index"],    
    ["url"=>"/rtb","controller"=>"App\Controllers\Dbs\RtbController","method"=>"index"],
    ["url"=>"/rtb/","controller"=>"App\Controllers\Dbs\RtbController","method"=>"index"],
    ["url"=>"/metrics","controller"=>"App\Controllers\Tc\MetricsController","method"=>"index"],
    ["url"=>"/metrics/","controller"=>"App\Controllers\Tc\MetricsController","method"=>"index"],    
    ["url"=>"/logs","controller"=>"App\Controllers\LogsController","method"=>"index"],
    
    ["url"=>"/apify/contexts","controller"=>"App\Controllers\Apify\ContextsController","method"=>"index"],
    ["url"=>"/apify/contexts/{id}","controller"=>"App\Controllers\Apify\ContextsController","method"=>"index"],
    
    ["url"=>"/apify/dbs/{id_context}","controller"=>"App\Controllers\Apify\DbsController","method"=>"index"],//schemas
    
    ["url"=>"/apify/tables/{id_context}/{dbname}","controller"=>"App\Controllers\Apify\TablesController","method"=>"index"],
    ["url"=>"/apify/tables/{id_context}","controller"=>"App\Controllers\Apify\TablesController","method"=>"index"],
    
    ["url"=>"/apify/fields/{id_context}/{dbname}/{tablename}/{fieldname}","controller"=>"App\Controllers\Apify\FieldsController","method"=>"index"],
    ["url"=>"/apify/fields/{id_context}/{dbname}/{tablename}","controller"=>"App\Controllers\Apify\FieldsController","method"=>"index"],
    
    ["url"=>"/apify/read/raw","controller"=>"App\Controllers\Apify\ReaderController","method"=>"raw"],
    ["url"=>"/apify/read","controller"=>"App\Controllers\Apify\ReaderController","method"=>"index"],

    ["url"=>"/apify/write/raw","controller"=>"App\Controllers\Apify\WriterController","method"=>"raw"],
    ["url"=>"/apify/write","controller"=>"App\Controllers\Apify\WriterController","method"=>"index"],

//resto de rutas    
    ["url"=>"/404","controller"=>"App\Controllers\NotFoundController","method"=>"error_404"]
];
