SELECT * 
FROM draco.`bi_replication_tables` 
WHERE 1
AND rep_table LIKE '%%tablename%%'      -- tabla en operacional
OR rep_name LIKE '%%tablenameprefix%%'  -- tabla en hive
ORDER BY rep_id DESC

SELECT * FROM %databasename%.%tablename%;

set tez.queue.name=%queue%;
SELECT * FROM staging_tables.%tablenameprefix%_incremental_temp;

set tez.queue.name=%queue%;
SELECT * FROM dw.%tablenameprefix%;
