-- -----------------------------------------------------------------------------------------
--  dw.%tablename%
-- -----------------------------------------------------------------------------------------
-- SELECT * FROM dw.%tablename% ORDER BY %fieldnamepk% DESC LIMIT 1;

DROP table dw.%tablename%;

CREATE TABLE dw.%tablename%(
%fieldsinfoddl%
)
CLUSTERED BY(%fieldnamepk%) INTO 5 BUCKETS
STORED AS ORC
TBLPROPERTIES("orc.compress"="SNAPPY",'transactional'='true');

INSERT INTO TABLE dw.%tablename%  VALUES (%fieldsvalue%);

