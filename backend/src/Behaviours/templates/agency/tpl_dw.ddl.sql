-- -----------------------------------------------------------------------------------------
--  dw.%tablename%
-- -----------------------------------------------------------------------------------------
DROP table dw.%tablename%;

CREATE TABLE dw.%tablename%(
%fieldsinfo%
)
CLUSTERED BY(%fieldnamepk%) INTO 5 BUCKETS
STORED AS ORC
TBLPROPERTIES("orc.compress"="SNAPPY",'transactional'='true');

INSERT INTO TABLE dw.%tablename%  VALUES (%fieldsvalue%);

