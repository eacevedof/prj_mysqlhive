# Apify

## Endpoints
```js
/apify/contexts
/apify/contexts/{id}
/apify/dbs/{id_context}
/apify/tables/{id_context}/{dbname}
/apify/tables/{id_context} -- todas las tablas de un contexto??
/apify/fields/{id_context}/{dbname}/{tablename}/{fieldname}
/apify/fields/{id_context}/{dbname}/{tablename}

//custom query
/apify/read/raw
/apify/read
/apify/write/raw
/apify/write
```

## Ejemplos
- /apify/contexts
    - [http://localhost:3000/apify/contexts](http://localhost:3000/apify/contexts)
- /apify/contexts/{id}
    - [http://localhost:3000/apify/contexts/devlocal](http://localhost:3000/apify/contexts/devlocal)
- /apify/dbs/{id_context}    
    - [http://localhost:3000/apify/dbs/devlocal](http://localhost:3000/apify/dbs/devlocal)
- /apify/tables/{id_context}/{dbname}
    - [http://localhost:3000/apify/tables/devlocal/db_killme](http://localhost:3000/apify/tables/devlocal/db_killme)
- /apify/tables/{id_context}
    - falta: todas las tablas de un contexto
- /apify/fields/{id_context}/{dbname}/{tablename}
    - [http://localhost:3000/apify/fields/devlocal/db_killme/tbl_operation](http://localhost:3000/apify/fields/devlocal/db_killme/tbl_operation)
- /apify/fields/{id_context}/{dbname}/{tablename}/{fieldname}    
    - [http://localhost:3000/apify/fields/devlocal/db_killme/tbl_operation/op_d1](http://localhost:3000/apify/fields/devlocal/db_killme/tbl_operation/op_d1)

## Contextos
```json
[
    {"id":"devlocal", "alias":"Dev local", "description":"Dev local", "config":{"type":"mysql","server":"127.0.0.1","database":"db_killme","user":"root","password":""}},
    {"id":"agencyreader", "alias":"agency-reader", "description":"Agency Reader", "config":{"type":"mysql","server":"dbb2c01-replica-bi.rdsxxx.io","database":"agency","user":"xxx","password":"slavereader"}},
    {"id":"dev", "alias":"dev-agregacion", "description":"Development", "config":{"type":"mysql","server":"dev01.serverxxx.io","database":"db_agregacion","user":"root","password":"yyy"}},
    {"id":"draco", "alias":"draco-reader", "description":"Draco Reader", "config":{"type":"mysql","server":"dbcommon-bi.rdsxxx.io","database":"draco","user":"stratebi","password":"zzz"}},
    {"id":"devreal", "alias":"real dev", "description":"Telecoming Dev", "config":{"type":"mysql","server":"dev01.server.c.n","database":"db_test","user":"root","password":"snvfrgh897"}}
]
```