<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About

- Laravel 10x
- PHP 8.2
- Sonarqube
- Swagger

## Set Up

- composer install
- docker-compose up
- php artisan key:generate
- php artisan jwt:secret
- php artisan migrate

## API

- http://localhost:9000/api/
- [POST] http://localhost:9001/api/register
- [POST] http://localhost:9001/api/login
- [POST] http://localhost:9001/api/logout
- [POST] http://localhost:9001/api/refresh
- [GET] http://localhost:9001/api/document
- [POST] http://localhost:9001/api/documents
- [GET] http://localhost:9001/api/document/id
- [PUT] http://localhost:9001/api/document/id
- [DELETE] http://localhost:9001/api/document/id
- [GET] http://localhost:9001/api/document/id/pdf

## Sonarqube

 - http://localhost:9001
  - admin : admin

## Swagger

- http://localhost:8080