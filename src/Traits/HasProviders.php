<?php

namespace Codions\ThemesManager\Traits;

trait HasProviders
{
    public function loadProviders(): void
    {
        foreach ($this->config('providers', []) as $provider) {
            app()->register($provider);
        }
    }
}
