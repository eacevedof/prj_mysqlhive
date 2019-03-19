-- -----------------------------------------------------------------------------------------
--  dw.%tablenameprefix%
-- -----------------------------------------------------------------------------------------
set tez.queue.name=%%queue%%;
-- SELECT * FROM dw.%tablenameprefix% ORDER BY %fieldnamepk% DESC LIMIT 1;

DROP TABLE dw.%tablenameprefix%;

CREATE TABLE dw.%tablenameprefix%(
%fieldsinfoddl%
)
CLUSTERED BY(%fieldnamepk%) INTO 5 BUCKETS
STORED AS ORC
TBLPROPERTIES("orc.compress"="SNAPPY",'transactional'='true');

-- las vistas solo se crean para tablas transaccionales (di_<tabla>) para las ft no hacen falta
INSERT INTO TABLE dw.%tablenameprefix%  VALUES (%fieldsvalue%);

CREATE VIEW dw.%tablenameprefix%_view AS
SELECT * FROM dw.%tablenameprefix%;
 
