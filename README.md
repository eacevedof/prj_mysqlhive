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