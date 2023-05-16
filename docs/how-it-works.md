# How it works

**Themes Manager** will prepend theme views paths to the existing Laravel View Finder locations. This way you can easily override any default view (even any third package published views).

Suppose you request to display `welcome.blade.php` view
```php
return view('welcome');
```

1. View will be searched into the current active theme `resources/views` folder
2. If the view is not found in active theme then search into parents themes recursively
3. If the view is still not found then search laravel default view folder `resources/views`

:::tip Error and Package views
**Themes Manager** allows you to override error and package views (published in resources/views/vendor by Laravel). See [Usage > Views](usage/views) section to find how.
:::

## Theme structure
    themes
        ├── vendorName
        │   ├── themeName
        │   │   ├── lang
        │   │   │   ├── en
        │   │   ├── public
        │   │   │   ├── css
        │   │   │   ├── js
        │   │   │   ├── img
        │   │   └── resources
        │   │   │   ├── views
        │   │   │   │   ├── layouts
        │   │   │   │   │   └── app.blade.php
        │   │   │   │   │   └── guest.blade.php
        │   │   └── composer.json
        │   └── ...
        └── ...

:::tip Use artisan to create a new Theme
Best way to create a new Theme is to use `theme:make` artisan command. See [here how to use it](usage/artisan).
:::

Note that `composer.json` file is **required** and must contains following data (here is an example for a theme named __maestro__):
```json
{
    "name": "hexadog/maestro",
    "description": "Hexadog default theme",
    "type": "laravel-theme",
    "version": "1.0",
    "minimum-stability": "stable",
    "authors": [
        {
            "name": "Gaetan",
            "email": "gaetan@hexadog.com"
        }
    ],
    "extra": {
        "theme": {
            "parent": "",
            "active": true
        }
    }
}
```