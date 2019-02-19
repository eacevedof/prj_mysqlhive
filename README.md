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


            

```