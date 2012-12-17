TwpFeedback
===========

Symfony2 based project to get Ideas and Issues from your community

More info soon!

[![Build Status](https://travis-ci.org/jpass/TwpFeedback.png?branch=master)](https://travis-ci.org/jpass/TwpFeedback)

Development - Project configuration
---------------------

1) create app/config/parameters.yml

2) create app/cache, app/logs and spool directories with http-server write permissions

3) download composer from http://getcomposer.org/ and run
    
    php composer.phar install

4) create database
    
    php ./app/console doctrine:database:create

5) update database schema
    
    php ./app/console doctrine:schema:update --force

7) install bootstrap
    
    git submodule init
    git submodule update
    
8) generate css from sass

    compass compile

9) (optional) load fixtures to users test/test and admin/test
    
    php ./app/console doctrine:fixtures:load --fixtures="src/Twp/Entity"
