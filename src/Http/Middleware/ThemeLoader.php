<?php

namespace Codions\ThemesManager\Http\Middleware;

use Illuminate\Http\Request;
use Codions\ThemesManager\Facades\ThemesManager;

class ThemeLoader
{
    /**
     * Handle an incoming request.
     *
     * @param string $theme
     * @param string $layout
     *
     * @return mixed
     */
    public function handle(Request $request, \Closure $next, $theme = null)
    {
        // Do not load theme if API request or App is running in console
        if ($request->expectsJson() || app()->runningInConsole()) {
            return $next($request);
        }

        if (!empty($theme)) {
            ThemesManager::set($theme);
        } else {
            if ($theme = config('themes-manager.fallback_theme')) {
                ThemesManager::set($theme);
            }
        }

        return $next($request);
    }
}
