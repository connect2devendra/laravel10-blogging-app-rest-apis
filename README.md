<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Follow below steps to clone this project & Run in Window Machine (Laragon/XAMPP/WAMP)

### Prerequisite for smooth installation

1. Composer 2.0
2. PHP version should be >=8.1
3. MySQL >=8.0
4. Laravel >=10.0

### Commands to run in your window terminal (CMD/Powershell)

```PHP
$ git clone https://github.com/connect2devendra/laravel10-blogging-app-rest-apis.git
$ cd laravel10-blogging-app-rest-apis
$ composer update
$ cp .env.example .env
$ php artisan key:generate

create database and configure your DB connection details in .env file

$ php artisan migrate
$ php artisan db:seed
$ php artisan l5-swagger:generate
$ php artisan config:clear
$ php artisan cache:clear
$ php artisan config:cache
$ php artisan serve

Open in browser http://localhost:8000

To check all routes

$ php artisan route:list

```

## Few Important Commands Used During Project Development To Make Our Job Easy.

```PHP
To Run all Test Cases
$ php artisan test

To Run particular test case or individual test class
$ php artisan test --filter=test_non_authenticated_user_cannot_get_user_details
$ php artisan test --filter=UserControllerTest

To Rollback DB Migration 1 steps back
$ php artisan migrate:rollback --step=1

Make Model with Controller & Resources
$ php artisan make:model Article -mcr

Create Controller in specific folder
$ php artisan make:controller Api/ArticleController

Create Controller with Resources methods
$ php artisan make:controller Api/CategoryController -r

Create new table using migration
$ php artisan make:migration create_article_table

Alter table using migration file
Note:- composer require doctrine/dbal  (This pakage required to do any alteration in DB using migration)
$ php artisan make:migration add_status_to_article_table --table=articles

```

## Screenshot for Demo

![Route List & Folder Structures]("List of routes and basic folder structures")

![Swagger APIS]("List of few apis added for sample")

![PHP UNIT TEST]("Added few unit test cases for sample (Test Driven Development - TDD)")

