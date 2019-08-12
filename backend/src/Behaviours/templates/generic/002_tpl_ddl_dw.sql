-- Este contenido hay que añadirlo en:
-- \trunk\reporting\bi\crons\cron_replicado_tablas_mysql_to_hive\ddl\hortonworks\dw\dw.ddl.sql

-- consulta de comprobación si ya existe una tabla con este nombre
set tez.queue.name=%queue%;
SELECT * FROM dw.%tablenameprefix% ORDER BY %fieldnamepk% DESC LIMIT 1;

-- -----------------------------------------------------------------------------------------
--  dw.%tablenameprefix%
-- -----------------------------------------------------------------------------------------
set tez.queue.name=%queue%;
-- consulta comprobación ya existe
-- SELECT * FROM dw.%tablenameprefix% ORDER BY %fieldnamepk% DESC LIMIT 1;

DROP TABLE dw.%tablenameprefix%;

CREATE TABLE dw.%tablenameprefix%(
%fieldsinfoddl%
)
CLUSTERED BY(%fieldnamepk%) INTO 5 BUCKETS
STORED AS ORC
TBLPROPERTIES("orc.compress"="SNAPPY",'transactional'='true','auto.purge'='true');

-- ======================================================================================
-- ======================================================================================

-- las vistas solo se crean para tablas transaccionales (di_<tabla>) para las ft no hacen falta
INSERT INTO TABLE dw.%tablenameprefix%  VALUES (%fieldsvalue%);


DROP VIEW dw.%tablenameprefix%_view

CREATE VIEW dw.%tablenameprefix%_view AS
SELECT * FROM dw.%tablenameprefix%;
 
ALTER TABLE dw.%tablenameprefix% add columns (%fieldsinfoddl%);

UPDATE dw.%tablenameprefix% SET %fieldsinfoddl% WHERE %fieldnamepk%=-1