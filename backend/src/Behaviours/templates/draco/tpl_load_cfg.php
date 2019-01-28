<?php
define("SINGLE_INSTANCE_WITH_PARAMS", "SINGLE_INSTANCE_WITH_PARAMS");
include_once("lib/single_instance.php");
include_once(__DIR__."/../../replicadormgr.php");

class replicate_table extends replicadormgr{

    public function __construct() {

        parent::__construct();
    }

    public function start() {
        $this->debug("start()");

        $options=array(
            "db"			=>	"%databasename%",
            "context"		=>	"%contextname%",
            "table"			=>	"%tablename%",
            "check_column"	=>	"%fieldnamedate%",
            "field_pk"		=>	"%fieldnamepk%",
            "file"          =>  __FILE__,
            "table_type"    =>  "%tabletype%",
        );

        $this->set_replication_config("%tablenameprefix%",$options);
    }

}

$o = new  replicate_table();
$o->start();