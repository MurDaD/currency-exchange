# currency-exchange
for sinoptic.ua

Requirements can be found here: http://li1430-197.members.linode.com/currency-exchange/Test-PHP_Sinoptik.pdf

Demo
---
http://li1430-197.members.linode.com/currency-exchange/index.php

Cron is executing every 1 minute since 08/15/2016 morning

Requirements
---

      php 5.3+
      mysqli
      composer
      mysql replications (server side and PHP extension)
      WebSockets (PHP extension)

Installation
---
`composer install` - to install dependencies

`vendor/bin/phinx init` - to init DB migrations plugin

`vendor/bin/phinx migrate` - to create database

add `/cron/currencies.php` to your cron

Run
---

Server: `php server.php` from project dir to run WebSocket server

Then go to project root dir and test!
