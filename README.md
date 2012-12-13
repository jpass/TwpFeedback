TwpFeedback
===========

Symfony2 based project to get Ideas and Issues from your community

More info soon!

Project configuration
---------------------

1) create app/config/parameters.yml

2) create app/cache, app/logs and spool directories with http-server write permissions

3) download composer from http://getcomposer.org/ and run
    
    php composer.phar install

4) create database
    
    php ./app/console doctrine:database:create

5) update database schema
    
    php ./app/console doctrine:schema:update --force

6) (optional) load fixtures to users test/test and admin/test
    
    php ./app/console doctrine:fixtures:load --fixtures="src/Twp/Entity"
