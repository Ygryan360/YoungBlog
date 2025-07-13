#!/bin/bash
php artisan migrate
exec php-fpm
