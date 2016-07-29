its a test task for job interview.
here is description: https://docs.google.com/document/d/1GJgS6JDOZANgJn4M9IfCTZrZGYtwddmT7OvzIOZs2Uk/edit?usp=sharing
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
