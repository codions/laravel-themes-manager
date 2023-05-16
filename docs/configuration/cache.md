# Cache
Themes Manager works with Laravel Cache Manager to improve its performances when find all available themes. This way, if cache enabled, filesystem will not be browsed to discover available themes.

You can enable/disable cache with `themes-manager.cache.enabled` configuration value. The `themes-manager.cache.lifetime` configuration value allows you to customize cache retention lifetime.

_If you want to customize the cache key in which cache is stored, change `themes-manager.cache.key` configuration value._