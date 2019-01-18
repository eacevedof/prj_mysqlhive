SELECT DISTINCT table_name,LOWER(column_name) AS field_name
,LOWER(DATA_TYPE) AS field_type
,IF(pkfields.field_name IS NULL,0,1) is_pk
,character_maximum_length AS field_length
,numeric_precision ntot
,numeric_scale ndec
,extra 
FROM information_schema.columns 
LEFT JOIN 
(
    SELECT key_column_usage.column_name field_name
    FROM information_schema.key_column_usage
    WHERE 1
    AND table_schema = '%databasename%'
    AND constraint_name = 'PRIMARY'
    AND table_name = '%tablename%'
) AS pkfields
ON information_schema.columns.column_name = pkfields.field_name
WHERE table_name='%tablename%'
AND table_schema='%databasename%'
ORDER BY ordinal_position ASC

SELECT * 
FROM draco.`bi_replication_tables` 
WHERE 1
AND rep_table LIKE '%%tablename%%'  -- tabla en operacional
OR rep_name LIKE '%%tablename%%'  -- tabla en hive
ORDER BY rep_id DESC


SELECT * FROM staging_tables.%tablename%_incremental_temp LIMIT 1;
SELECT * FROM sta_1.%tablename% LIMIT 1;
SELECT * FROM sta_2.%tablename% LIMIT 1;
SELECT * FROM dw.%tablename% LIMIT 1;
