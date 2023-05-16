# Middleware
You can automatize theme activation using provided middlewares.

## Web Middleware
Create a new Middleware in <code>app/Http/Middleware</code> and configure your Laravel application to use it. This middleware must extends <code>Prisma\ThemesManager\Http\Middleware\ThemeLoader</code> middleware.

Here is an example of middleware which set a theme based on the request url. It activated `admin` theme if current request url matches the `http(s)://mydomain/admin` pattern and use the fallback theme otherwise.
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Prisma\ThemesManager\Http\Middleware\ThemeLoader as HexadogThemeLoader;

class ThemeLoader extends HexadogThemeLoader
{
    public function handle($request, Closure $next, $theme = null)
    {
        // Check if request url starts with admin prefix
        if ($request-segment(1) === 'admin') {
            // Set a specific theme for matching urls
            $theme = 'hexadog/admin';
        }

        // Call parent Middleware handle method
        return parent::handle($request, $next, $theme);
    }
}
```

Edit <code>App\Http\Kernel.php</code> file to add your new middleware into the list of middlewares used by your application.
```php
<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // ...
    	\App\Http\Middleware\ThemeLoader::class,
    ];

    // ...
}
```

## Route Middleware
Edit App\Http\Kernel.php file to add the route middleware into the list of middlewares used by your application.
```php
// Within App\Http\Kernel Class...

protected $routeMiddleware = [
    // ...
    'theme' => \Prisma\ThemesManager\Http\Middleware\ThemeLoader::class,
];
```

Once the middleware has been defined in the HTTP kernel, you can use the middleware method to assign a theme to a route (or a group of routes):
```php
// Use theme named "one" for set of routes
Route::middleware('theme:one')->group(function() {
    // Your routes definition here
});

// Use Theme names "two" for another set of routes
Route::middleware('theme:two')->group(function() {
    // Your routes definition here
});
```
