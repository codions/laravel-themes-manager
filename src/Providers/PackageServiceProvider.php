<?php

namespace Codions\ThemesManager\Providers;

use Codions\ThemesManager\Components\Image;
use Codions\ThemesManager\Components\PageTitle;
use Codions\ThemesManager\Components\Script;
use Codions\ThemesManager\Components\Style;
use Codions\ThemesManager\Console\Commands;
use Codions\ThemesManager\Console\Generators;
use Codions\ThemesManager\Facades\ThemesManager as ThemesManagerFacade;
use Codions\ThemesManager\Http\Middleware;
use Codions\ThemesManager\ThemesManager;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class PackageServiceProvider extends ServiceProvider
{
    /**
     * Name for this package to publish assets.
     */
    protected const PACKAGE_NAME = 'themes-manager';

    /**
     * Publishers list.
     */
    protected $publishers = [];

    /**
     * Bootstrap the application events.
     */
    public function boot(Router $router)
    {
        $this->loadViewsFrom($this->getPath('resources/views'), 'themes-manager');
        $this->loadViewComponentsAs('theme', [
            Image::class,
            PageTitle::class,
            Script::class,
            Style::class,
        ]);

        $this->strapPublishers();
        $this->strapCommands();

        $router->aliasMiddleware('theme', Middleware\ThemeLoader::class);
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->registerConfigs();

        $this->app->singleton('themes-manager', function () {
            return new ThemesManager();
        });

        AliasLoader::getInstance()->alias('ThemesManager', ThemesManagerFacade::class);
        AliasLoader::getInstance()->alias('Theme', ThemesManagerFacade::class);

        $this->app->register(BladeServiceProvider::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [ThemesManager::class];
    }

    /**
     * Get Package absolute path.
     *
     * @param string $path
     */
    protected function getPath($path = '')
    {
        // We get the child class
        $rc = new \ReflectionClass(get_class($this));

        return dirname($rc->getFileName()) . '/../../' . $path;
    }

    /**
     * Get Module normalized namespace.
     *
     * @param mixed $prefix
     */
    protected function getNormalizedNamespace($prefix = '')
    {
        return Str::start(Str::lower(self::PACKAGE_NAME), $prefix);
    }

    /**
     * Bootstrap our Configs.
     */
    protected function registerConfigs()
    {
        $configPath = $this->getPath('config');

        $this->mergeConfigFrom(
            "{$configPath}/config.php",
            $this->getNormalizedNamespace()
        );
    }

    protected function strapCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\ClearCache::class,
                Commands\ListThemes::class,
                Generators\MakeTheme::class,
            ]);
        }
    }

    /**
     * Bootstrap our Publishers.
     */
    protected function strapPublishers()
    {
        $configPath = $this->getPath('config');

        $this->publishes([
            "{$configPath}/config.php" => config_path($this->getNormalizedNamespace() . '.php'),
        ], 'config');

        $this->publishes([
            $this->getPath('resources/views') => resource_path('views/vendor/themes-manager'),
        ], 'views');
    }
}
