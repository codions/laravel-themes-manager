# Laravel Themes Manager

<p align="center">
    <a href="https://packagist.org/packages/codions/laravel-themes-manager">
        <img src="https://poser.pugx.org/codions/laravel-themes-manager/v" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/codions/laravel-themes-manager">
        <img src="https://poser.pugx.org/codions/laravel-themes-manager/downloads" alt="Total Downloads">
    </a>
    <a href="https://packagist.org/packages/codions/laravel-themes-manager">
        <img src="https://poser.pugx.org/codions/laravel-themes-manager/license" alt="License">
    </a>
</p>

## Introduction
Laravel Themes Manager is a Laravel package which was created to let you developing multi-themes Laravel application.

## Installation
This package requires PHP 7.4 and Laravel 7.0 or higher.

To get started, install Themes Manager using Composer:
```shell
composer require codions/laravel-themes-manager
```

The package will automatically register its service provider.

To publish the config file to config/themes-manager.php run:
```shell
php artisan vendor:publish --provider="Codions\ThemesManager\Providers\PackageServiceProvider"
```

## Documentation
You can find the full documentation [here](docs)

## Related projects
- [Laravel Themes Installer](https://github.com/codions/laravel-themes-installer): Composer plugin to install `laravel-theme` packages outside vendor directory .

## Credits
- This project is a modified version of [hexadog/laravel-themes-manager](https://github.com/hexadog/laravel-themes-manager), created as a fork with additional changes.

## License
Laravel Themes Manager is open-sourced software licensed under the [MIT license](LICENSE).
