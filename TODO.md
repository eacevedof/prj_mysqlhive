- No aplica update_date => true para el campo fecha pivote: "awa_ts_modified"   => array("type"  => "timestamp",  "update_date"			=>	true),
    - muestra comentario
- no me sustituye @@@fieldnamepk@@@
- debe admitir bigint y tinyint,smallint
- configurar decimales a 28,8
- se queda con el porcentaje en la plantilla generada: set tez.queue.name=%kylin_reconstrucciones%;
- incluir ruta de producción en el .sh  OK
- incluir parámetro ft para ficheros
- campos _dg (hora)
- etl para dimensiones en ft: case when (cc_website_id  IN ('null','NULL','')
- 'auto.purge'='true'  OK
- drop view OK
- adaptar a nueva configuración de apify /config/contexts.json
- Comprobar este behaviour en DbsService.php
    ```php
    protected function load()
    {
        $this->oBehav = new AgencyBehaviour();
    ```