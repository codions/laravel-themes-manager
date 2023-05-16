# Artisan commands
**Themes Manager** provides some artisan commands in order to manage themes.

## Create Theme
You can easily create a new Theme by using the following command and follow the steps:
```shell
php artisan theme:make

 Theme Name:
 > 

 Vendor name:
 > 

 Author name:
 >  

 Description:
 > 

 Version:
 > 

 Is it a child theme? (yes/no) [no]:
 > y

 Parent theme name:
 > 
```

This command will create a new Theme directory with all necessary files within the `themes` folder.


    themes
        ├── vendorName
        │   ├── themeName
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

## List Themes
List all existing themes in your application with their details.
```shell
php artisan theme:list

+-----------+---------+---------+------------------------+-----------+---------+--------+
| Name      | Vendor  | Version | Description            |  Extends  | Default | Active |
+-----------+---------+---------+------------------------+-----------+---------+--------+
| theme-one | hexadog |   1.0   | Default frontend theme |           |    X    | Yes    |
| theme-two | hexadog |   1.0   | New frontend theme     | theme-one |         | Yes    |
+-----------+---------+---------+------------------------+-----------+---------+--------+
```

## Activate Theme
Only active themes can be used at runtime.
```shell
php artisan theme:activate hexadog/default
```

## Deactivate Theme
Deactivated theme to make it unavailable for usage.
```shell
php artisan theme:deactivate hexadog/default
```

## Clear cache
Manually clear cache
```bash
php artisan theme:cache
```

## Cache generation
Generate cache
```bash
php artisan theme:cache:clear
```