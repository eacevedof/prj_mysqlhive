<?php
//<project>\backend\src\routes\routes.php
//mapeo de rutas y controladores

return [   
/*  
Listado de employees con el departamento, cargo y salario actuales. 
Ordenado por fecha de contratación y limitado a 50 
*/  
    ["url"=>"/","controller"=>"App\Controllers\NotFoundController","method"=>"index"],
    ["url"=>"/agency","controller"=>"App\Controllers\Dbs\AgencyController","method"=>"index"],
    ["url"=>"/agency/","controller"=>"App\Controllers\Dbs\AgencyController","method"=>"index"],
    ["url"=>"/draco","controller"=>"App\Controllers\Dbs\DracoController","method"=>"index"],
    ["url"=>"/draco/","controller"=>"App\Controllers\Dbs\DracoController","method"=>"index"],


//resto de rutas    
    ["url"=>"/404","controller"=>"App\Controllers\NotFoundController","method"=>"error_404"]
];
