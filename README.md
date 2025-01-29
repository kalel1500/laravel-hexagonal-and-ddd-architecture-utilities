<p align="center"><img src="./art/title3.png" alt="Laravel Hexagonal and DDD"></p>

<p align="center">
    <!-- <a href="https://github.com/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/actions/workflows/tests.yml"><img src="https://github.com/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities/actions/workflows/tests.yml/badge.svg" alt="Build Status"></a> -->
    <a href="https://packagist.org/packages/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities" target="_blank"><img src="https://img.shields.io/packagist/dt/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities" target="_blank"><img src="https://img.shields.io/packagist/v/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities" target="_blank"><img src="https://img.shields.io/packagist/l/kalel1500/laravel-hexagonal-and-ddd-architecture-utilities" alt="License"></a>
</p>


## Introduction

Utilidades para desarrollar en arquitectura hexagonal y DDD en laravel.


## Instalación

```bash
composer require kalel1500/laravel-hexagonal-and-ddd-architecture-utilities
```


## Publish files

To publish all the files in the package you can use the following command:

```bash
php artisan vendor:publish --provider="Thehouseofel\Hexagonal\Infrastructure\HexagonalServiceProvider"
```

Or else you have the following to publish the files independently

```bash
php artisan vendor:publish --tag="hexagonal-migrations"
php artisan vendor:publish --tag="hexagonal-views"
php artisan vendor:publish --tag="hexagonal-view-layout"
php artisan vendor:publish --tag="hexagonal-config"
php artisan vendor:publish --tag="hexagonal-lang"
```


## License

Laravel Hexagonal and DDD is open-sourced software licensed under the [GNU General Public License v3.0](LICENSE).