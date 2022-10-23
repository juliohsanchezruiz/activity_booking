# README #

>Aplicacion reservación de actividad

>Creat Base de datos

    CREATE DATABASE `activity_booking`CHARACTER SET utf8mb4; 

> Ejecutar

    composer install

> Configura .env
    
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=activity_booking
    DB_USERNAME=root
    DB_PASSWORD=

> Ejecutar

    php artisan migrate

> Ejecutar seeder para llevar las tabla de actividades y funcione 
> el unit test

    php artisan db:seed --class=ActivitySeeder
    php artisan db:seed --class=ActivitiesActivitySeeder

> Pruebas unitarias

    php artisan test  tests/Feature/ActivityTest.php
    php artisan test  tests/Feature/ActivityReservationTest.php

> Ejecutar para los estilos y los pluging

    npm install
    npm run dev

