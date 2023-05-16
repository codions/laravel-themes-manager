# Components
Clean up you theme layouts with our integrated Blade Components.

## Page Title
```html
<x-theme-page-title title="Home" /> <!-- <title>Home - AppName</title> -->

<!-- Without App name -->
<x-theme-page-title title="Home" withAppName=false > <!-- <title>Home</title> -->

<!-- Custom separator -->
<x-theme-page-title title="Home" separator="|" /> <!-- <title>Home | AppName</title> -->

<!-- Invert order -->
<x-theme-page-title title="Home" invert=true > <!-- <title>AppName - Home</title> -->
```

## Theme Asset
```html
<x-theme-asset source="css/app.css"/> <!-- http://laravel.test/themes/hexadog/default/css/app.css -->
```

## Theme Image
```html
<x-theme-image source="img/logo.png"/> <!-- <img src="http://laravel.test/themes/hexadog/default/img/logo.png" /> -->

<!-- Add any HTML attribute -->
<x-theme-image source="img/logo.png" class="image" alt="Logo" /> <!-- <img src="themes/hexadog/default/img/logo.png" class="image" alt="logo" /> -->
```

## Theme Script
```html
<x-theme-script source="css/app.css"/> <!-- http://laravel.test/themes/hexadog/default/css/app.css -->
```

## Theme Style
```html
<x-theme-style source="css/app.css"/> <!-- <link src="http://laravel.test/themes/hexadog/default/css/app.css" rel="stylehseet"> -->

<!-- Media -->
<x-theme-style source="css/app.css" media="print"/> <!-- <link src="themes/hexadog/default/css/app.css" rel="stylehseet" media="print"> -->
```