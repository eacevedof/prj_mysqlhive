-- -----------------------------------------------------------------------------------------
--  dw.%tablenameprefix%
-- -----------------------------------------------------------------------------------------
-- SELECT * FROM dw.%tablenameprefix% ORDER BY %fieldnamepk% DESC LIMIT 1;

DROP TABLE dw.%tablenameprefix%;

CREATE TABLE dw.%tablenameprefix%(
%fieldsinfoddl%
)
CLUSTERED BY(%fieldnamepk%) INTO 5 BUCKETS
STORED AS ORC
TBLPROPERTIES("orc.compress"="SNAPPY",'transactional'='true');

INSERT INTO TABLE dw.%tablenameprefix%  VALUES (%fieldsvalue%);

