<?php
//<project>\trunk\reporting\bi\crons\cron_replicado_tablas_mysql_to_hive\replicadormgr.php
if (!defined("CONNECT_%DATABASENAME%")) define("CONNECT_%DATABASENAME%","jdbc:mysql://%servername%/%databasename%");

//<prject>\trunk\reporting\bi\crons\cron_replicado_tablas_mysql_to_hive\replicate_config_tables_mysql_to_hive.php
cron::launch_process("%databasename%/load_cfg_%tablenameprefix%" , "*/3 * * * *","--cluster=hortonprod");