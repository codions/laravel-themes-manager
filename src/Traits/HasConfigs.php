<?php

namespace Codions\ThemesManager\Traits;

use Illuminate\Support\Arr;

trait HasConfigs
{
    /**
     * @param  null|string  $key
     * @param  null|mixed  $default
     * @return array|mixed
     */
    public function config($key = null, $default = null)
    {
        $path = $this->getPath('src/config/config.php');

        if (file_exists($path)) {
            $this->config = include $path;
        }

        if (is_null($key)) {
            return $this->config;
        }

        return Arr::get($this->config, $key, $default);
    }
}
