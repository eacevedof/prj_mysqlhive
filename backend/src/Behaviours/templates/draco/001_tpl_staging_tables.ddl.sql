-- -----------------------------------------------------------------------------------------
-- staging_tables.%tablenameprefix%_incremental_temp
-- -----------------------------------------------------------------------------------------
set tez.queue.name=%%queue%%;
-- SELECT * FROM staging_tables.%tablenameprefix%_incremental_temp ORDER BY %fieldnamepk% DESC LIMIT 1;

DROP TABLE IF EXISTS staging_tables.%tablenameprefix%_incremental_temp;

CREATE  TABLE IF NOT EXISTS staging_tables.%tablenameprefix%_incremental_temp (
%fieldsinfoddl%
)
ROW FORMAT DELIMITED
FIELDS TERMINATED BY '\001'
STORED AS TEXTFILE
TBLPROPERTIES ('orc.compress'='SNAPPY');



ALTER TABLE staging_tables.%tablenameprefix%_incremental_temp add columns (%fieldsinfoddl%);