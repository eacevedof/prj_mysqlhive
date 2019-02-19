-- -----------------------------------------------------------------------------------------
-- staging_tables.%tablenameprefix%_incremental_temp
-- -----------------------------------------------------------------------------------------
-- SELECT * FROM staging_tables.%tablenameprefix%_incremental_temp ORDER BY %fieldnamepk% DESC LIMIT 1;

DROP TABLE IF EXISTS staging_tables.%tablenameprefix%_incremental_temp;

CREATE  TABLE IF NOT EXISTS staging_tables.%tablenameprefix%_incremental_temp (
%fieldsinfoddl%
)
ROW FORMAT DELIMITED
FIELDS TERMINATED BY '\001'
STORED AS TEXTFILE
TBLPROPERTIES ('orc.compress'='SNAPPY');



