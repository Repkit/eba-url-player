Url Player
===================

Microservice used for access url management that requires action , method and data with an access time interval. 

Installation
------------

Database setup
--------------------
+ execute url-player/data/database.sql
+ config your database connection in url-player/config/url-player.global.php


Dynapack integration
--------------------

+ composer require trip-microservices/url-player or update dynapack's composer.json file
+ activare modul si adaugare in api/config/acl/controller.php


Standalone
----------

+ git clone git@gitlab.dcs:trip-microservices/url-player.git
+ cd url-player
+ composer install
+ composer update


Usage
-----

Config
-----

* **POST** .../player-config - adds a url request job.
    *  post parameters: [action,method,data,minutes,hours,days,dow,months,comment]
* **PATCH** .../player-config[/:config_id] 
* **DELETE** .../player-config[/:config_id]
* **FETCH** .../player-config[/:config_id]
 