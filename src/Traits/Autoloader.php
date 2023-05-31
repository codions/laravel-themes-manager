<?php

namespace Codions\ThemesManager\Traits;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Livewire;
use ReflectionClass;

trait Autoloader
{
    public function registerAutoloader()
    {
        spl_autoload_register(function ($class) {
            $this->requireClass($class);
        });
    }

    protected function requireClass($class)
    {
        $class = str_replace($this->getNamespace(), '', $class);

        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        $file = $this->getPath("src/{$class}.php");

        if (file_exists($file)) {
            require_once $file;
        }
    }

    protected function registerLivewireComponents()
    {
        $directory = $this->getPath('src/Http/Livewire');

        $namespace = $this->getNamespace('Http\Livewire');

        // If you ever decide to change, I suggest using something like "theme::".
        $aliasPrefix = '';

        $filesystem = new Filesystem();

        if (! $filesystem->isDirectory($directory)) {
            return false;
        }

        $files = collect($filesystem->allFiles($directory));

        $files->map(function ($file) use ($namespace) {
            return $namespace . '\\' . str_replace(['/', '.php'], ['\\', ''], $file->getRelativePathname());
        })
            ->filter(function ($class) {
                return is_subclass_of($class, Component::class) && ! (new ReflectionClass($class))->isAbstract();
            })
            ->each(function ($class) use ($namespace, $aliasPrefix) {
                $alias = $aliasPrefix . Str::of($class)
                    ->after($namespace . '\\')
                    ->replace(['/', '\\'], '.')
                    ->explode('.')
                    ->map([Str::class, 'kebab'])
                    ->implode('.');

                if (Str::endsWith($class, ['\Index', '\index'])) {
                    Livewire::component(Str::beforeLast($alias, '.index'), $class);
                }

                // dd($alias, $class);
                Livewire::component($alias, $class);
            });
    }
}
