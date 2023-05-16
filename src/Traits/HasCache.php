<?php

namespace Codions\ThemesManager\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Codions\ThemesManager\ThemeFinder;

trait HasCache
{
    /**
     * Clear the themes cache if it is enabled.
     */
    public function clearCache(): bool
    {
        if (true === Config::get('themes-manager.cache.enabled', false)) {
            return Cache::forget(Config::get('themes-manager.cache.key', 'themes-manager'));
        }

        return true;
    }

    /**
     * Get cached themes.
     */
    protected function getCache(): Collection
    {
        return Cache::remember(Config::get('themes-manager.cache.key', 'themes-manager'), Config::get('themes-manager.cache.lifetime', 86400), function () {
            return ThemeFinder::find();
        });
    }
}
