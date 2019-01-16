-- -----------------------------------------------------------------------------------------
-- staging_tables.%tablename%_incremental_temp
-- -----------------------------------------------------------------------------------------
DROP TABLE IF EXISTS staging_tables.%tablename%_incremental_temp;

CREATE  TABLE IF NOT EXISTS staging_tables.%tablename%_incremental_temp (
%fieldsinfoddl%
)
ROW FORMAT DELIMITED
FIELDS TERMINATED BY '\001'
STORED AS TEXTFILE
TBLPROPERTIES ('orc.compress'='SNAPPY');



