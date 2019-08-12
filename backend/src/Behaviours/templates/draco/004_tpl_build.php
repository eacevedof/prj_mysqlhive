<?php
define("SINGLE_INSTANCE_WITH_PARAMS", "SINGLE_INSTANCE_WITH_PARAMS");
include_once("lib/single_instance.php");
include_once(__DIR__."/../../replicadormgr.php");

class replicate_table extends replicadormgr{

    public function __construct() {

        $this->db_context_source = '%contextname%';
        $this->db_source         = '%databasename%';
        $this->table_source      = "%tablename%";
        $this->table_dest        = "%tablenameprefix%";

        parent::__construct();
    }

    public function start() {
        $this->debug("start()");
        
        $options=array(
			"sqoop"					=>	array(
				"fields"			=>	"%allfields%",
				"split_by"			=>	"%fieldnamepk%",
			),
			"hive"					=>	array(
				"schema_table_dest"	=>	array(
					"fields"	=>	array(
						//check update_date=>true
						%fieldsinfo%
					),
					"database"	=>	"dw",
				),
			)
		);

        $this->build_incremental_table($this->table_dest,$this->db_source,$this->table_source,$this->table_dest,$options);
    }
}

$o = new  replicate_table();
$o->start();
