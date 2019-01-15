<?php
//<project>\backend\src\config\config.php
if(!defined("ENV")) define("ENV","d");

$arConfig = [
    //d: development
    "d" => [
        "db"=>[
            "server"=>"yyy",
            "database"=>"agency",
            "user"=>"slavereader",
            "password"=>"slavereader" 
        ]
    ],
    //p: production
    "p" => [
        "db"=>[
            "server"=>"xxx",
            "database"=>"agency",
            "user"=>"slavereader",
            "password"=>"slavereader" 
        ]        
    ]
];

return $arConfig[ENV];