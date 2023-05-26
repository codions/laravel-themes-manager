<?php

namespace Codions\ThemesManager\Traits;

trait Autoloader
{
    public function registerAutoloader()
    {
        spl_autoload_register(function ($class) {
            $class = str_replace($this->getNamespace(), '', $class);

            $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
            $file = $this->getPath("src/{$class}.php");

            if (file_exists($file)) {
                require_once $file;
            }
        });
    }
}
