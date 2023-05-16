# Assets
A theme can have its own assets (images, stylesheets, javascript, ...). Theme's specific assets should be stored within <code>themes/themeVendor/themeName/public</code> folder of the theme.

When a theme is activated, this directory is linked (using symbolic link) into <code>public/themes</code> folder of the Laravel application so assets will be available publicly.

By default asset url is generated with a version tag `?v=VERSION_TAG` where `VERSION_TAG` is the hash of asset's file.

Ask the **Themes Manager** to generate an asset URL:
```php
{!! Theme::asset('css/app.min.css') !!}

// or using helper
{!! theme_asset('css/app.min.css') !!}
```

This call will return the url of requested asset:
```
http://localhost/themes/hexadog/default/css/app.min.css
```

## Theme Style
Ask the **Themes Manager** to generate the stylesheet HTML tag:
```php
{!! Theme::style('css/app.min.css') !!}

// or using helper
{!! theme_style('css/app.min.css') !!}
```

This call will generate the following code:
```html
<link href="http://localhost/themes/hexadog/default/css/app.min.css">
```

## Theme Script
Ask the **Themes Manager** to generate the script HTML tag:
```php
{!! Theme::script('js/app.min.js') !!}

// or using helper
{!! theme_script('js/app.min.js') !!}
```

This call will generate the following code:
```html
<script src="http://localhost/themes/hexadog/default/js/app.min.js"></script>
```

## Theme Image
Ask the **Themes Manager** to generate the image HTML tag:
```php
{!! Theme::image('img/logo.png', 'My Theme logo') !!}

// or using helper
{!! theme_image('img/logo.png', 'My Theme logo') !!}
```
This call will generate the following code:
```html
<img src="http://localhost/themes/hexadog/default/img/logo.png" alt="My Theme logo" />
```

:::tip Customize public theme assets path
You can customize themes public assets path with `symlink_path` configuration value (See [Public assets path](/configuration/assets)).
:::