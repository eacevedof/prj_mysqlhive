# prj_mysqlhive
Generador de scripts de importación

```js
cd /c/proyecto/prj_mysqlhive/backend

php /c/programas/composer/composer.phar update

php -S localhost:3000 -t backend/public
```

#### Borrar historial
```js
git filter-branch --force --index-filter \
'git rm --cached --ignore-unmatch ./backend/src/config/config.php' \
--prune-empty --tag-name-filter cat -- --all

git push origin --force --all
```