# Installation

[[toc]]

## Installation

### Requirements
Laravel Themes Manager requires PHP 7.3 and Laravel 7 or 8.

### Installing Themes Manager
You can install Themes Manager through composer
```bash
composer require codions/laravel-themes-manager
```

The package will automatically register its service provider.

## Publishing resources (optional)

After installing **Themes Manager**, there are a few things we need to do to prepare our application.

### Publishing the configuration
First, we need to publish the configuration that comes with **Themes Manager**. You can do so by running the following artisan command:

```bash
php artisan vendor:publish --provider="Codions\ThemesManager\Providers\PackageServiceProvider" --tag=config
```

This will create a `themes-manager.php` file in your application's `config` directory.

### Publishing the views

```bash
php artisan vendor:publish --provider="Codions\ThemesManager\Providers\PackageServiceProvider" --tag=views
```

This will create a `vendor/themes-manager` directory in your application's `resources/views` directory with all views used by Themes manager.

That's all the setup necessary. Next, let's look at how we can get working with <strong>Themes Manager</strong>.
