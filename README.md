# installation
```
composer install
bower install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```
or
```
sh deploy.sh
```
# running internal php server
```
php bin/console server:run localhost:8000
```
then navigate to http://localhost:8000/ with your browser
