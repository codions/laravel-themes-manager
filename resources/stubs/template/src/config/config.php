<?php

/*
|--------------------------------------------------------------------------
| Theme configs
|--------------------------------------------------------------------------
|
| This file is where you can configure all of your theme settings.
| Current theme data is loaded via service provider and is available globally.
|
*/

return [
    /*
    * Theme Service Providers
    */
    'providers' => [
        \Themes\DummyNamespace\Providers\ThemeServiceProvider::class,
    ],
];
