-- Este contenido hay que añadirlo en:
-- \trunk\reporting\bi\crons\cron_replicado_tablas_mysql_to_hive\ddl\hortonworks\staging_tables\staging_tables.ddl.sql

-- consulta de comprobación si ya existe una tabla con este nombre
set tez.queue.name=%queue%;
SELECT * FROM staging_tables.%tablenameprefix%_incremental_temp ORDER BY %fieldnamepk% DESC LIMIT 1;

-- -----------------------------------------------------------------------------------------
-- staging_tables.%tablenameprefix%_incremental_temp
-- -----------------------------------------------------------------------------------------
set tez.queue.name=%queue%;

DROP TABLE IF EXISTS staging_tables.%tablenameprefix%_incremental_temp;

CREATE  TABLE IF NOT EXISTS staging_tables.%tablenameprefix%_incremental_temp (
%fieldsinfoddl%
)
ROW FORMAT DELIMITED
FIELDS TERMINATED BY '\001'
STORED AS TEXTFILE
TBLPROPERTIES ('orc.compress'='SNAPPY','auto.purge'='true');

-- =============================================================================================
-- =============================================================================================
-- =============================================================================================
ALTER TABLE staging_tables.%tablenameprefix%_incremental_temp add columns (%fieldsinfoddl%);