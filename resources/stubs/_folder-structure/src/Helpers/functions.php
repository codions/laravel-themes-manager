<?php

/*
|--------------------------------------------------------------------------
| Theme functions
|--------------------------------------------------------------------------
|
| This file is where you can define all your theme helper functions.
| Current theme functions are loaded via service provider and are available globally.
|
*/

if (! function_exists('theme_load')) {

    /**
     * This function is called on theme loading. Put in all the rules that
     * you want to be executedas a settings override or any other action.
     */
    function theme_load()
    {
        // Unleash your imagination here
    }
}

if (! function_exists('theme_inspire')) {

    /**
     * Just an example of helper function
     */
    function theme_inspire()
    {
        return 'Display an inspiring quote';
    }
}
