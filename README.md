TwpFeedback
========================

Symfony2 based project to get Ideas and Issues from your community

More info soon!


Project configuration
---------------------

* create app/config/parameters.yml
* create app/cache, app/logs and spool directories with http-server write permissions
* download composer from http://getcomposer.org/ and run
    php composer.phar install
* create database
    php ./app/console doctrine:database:create
* update database schema
    php ./app/console doctrine:schema:update --force
* (optional) load fixtures to users test/test and admin/test
    php ./app/console doctrine:fixtures:load --fixtures="src/Twp/Entity"
