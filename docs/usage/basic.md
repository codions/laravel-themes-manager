# Basic usage
There is multiple ways to work with **Themes Manager**. You can either set a new theme manually, using Web Middleware or Route Middleware.

Use the following method to set a theme manually at any time (in your controller for example):
```php
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Prisma\ThemesManager\Facades\ThemesManager;

class MyController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        // Specify theme name with vendor
        // in case multiple themes with same name are provided by multiple vendor
        ThemesManager::set('prismalms/my-theme');
    }
}
```
