# prj_mysqlhive
## Actualizado: 16/01/2019
Generador de scripts de importación

```js
cd /c/proyecto/prj_mysqlhive/backend

php /c/programas/composer/composer.phar update

php -S localhost:3000 -t backend/public
```

```js
php run.php --class=a.b.c --method=some --params=a--a
php run.php --class=App.Controllers.NotFoundController
php run.php --class=App.Services.RamdomizerService
php run.php --class=App.Services.RamdomizerService --method=get_date_ymd --cSep="//"
php run.php --class=App.Services.Dbs.AgregacionService --method=run
php run.php --class=App.Services.Dbs.SchemaService --method=get_tables
```

```js
php run.php --class=App.Services.Dbs.SchemaService --method=get_tables_info --sTables=insertion_orders,bigdata_banners,bigdata_placements,super_black_list,line_items,insertion_orders_placement_type,insertion_orders_placement_tactic,pmp_deals,pmp_deals_placements
```

```js
php run.php --class=App.Services.Dbs.AgregacionService --method=first_load 
php run.php --class=App.Services.Dbs.AgregacionService --method=add_operation
php run.php --class=App.Services.Dbs.AgregacionService --method=modf_operation
php run.php --class=App.Services.Dbs.AgregacionService --method=check_modified --iMin=10

```


#### Borrar historial
```js
git filter-branch --force --index-filter \
'git rm --cached --ignore-unmatch ./backend/src/config/config.php' \
--prune-empty --tag-name-filter cat -- --all

git push origin --force --all

## el fichero no debería estar editado
git rm --cached ./backend/src/config/config.php
```

## Integrador
```sql
comprueba ultimos registros cambiados
busca los registros en el historico
    si existe
        comprueba fechas
            si cambios
                comprobar si alguna metrica ha cambiado, si ha cambiado se actualiza la métrica y la fecha
                si no ha cambiado ninguna metrica se actualizan las fechas
            no cambios en fechas, nada

    si no existe
        se insertan nuevas métricas


-- tabla de pruebas
CREATE TABLE `tbl_operation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `op_d1` varchar(50) DEFAULT NULL,
  `op_d2` varchar(50) DEFAULT NULL,
  `op_d3` varchar(50) DEFAULT NULL,
  `op_d4` varchar(50) DEFAULT NULL,
  `op_d5` varchar(50) DEFAULT NULL,
  `op_atr1` varchar(50) DEFAULT NULL,
  `op_atr2` varchar(50) DEFAULT NULL,
  `op_atr3` varchar(50) DEFAULT NULL,
  `op_m1` int(11) DEFAULT NULL,
  `op_m2` int(11) DEFAULT NULL,
  `op_m3` int(11) DEFAULT NULL,
  `op_m4` int(11) DEFAULT NULL,
  `op_cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `op_mdate` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8          

SELECT  op_d1,op_d2,op_d4,op_d5
,SUM(op_m1) sm1,
SUM(op_m2) sm2,
SUM(op_m3) sm3,
SUM(op_m4) sm4
FROM tbl_operation 
GROUP BY op_d1,op_d2,op_d4,op_d5
ORDER BY op_d1,op_d2,op_d4,op_d5


-- 3659
SELECT SUM(op_m1) m1
FROM tbl_operation
WHERE op_d1 = 'd1A'
GROUP BY op_d1
ORDER BY op_d1,op_d2,op_d4,op_d5


-- 1414 + 1176 + 1069
SELECT op_d1,op_d2,SUM(op_m1) m1
,MAX(op_d1) mxd1
,MAX(op_d2) mxd2
FROM tbl_operation
WHERE op_d1 = 'd1A'
GROUP BY op_d1,op_d2
ORDER BY op_d1,op_d2,op_d4,op_d5


SELECT op_d1,op_d2,SUM(op_m1) m1
,MAX(op_d1) mxd1
,MAX(op_d2) mxd2
FROM tbl_operation
WHERE 1=1
GROUP BY op_d1,op_d2
ORDER BY op_d1,op_d2,op_d4,op_d5
```