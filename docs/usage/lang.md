# Lang

**Themes Manager** allows you to use theme specific transaltions.
You have to place your theme langauge file into the `lang` directory of your theme.

```bash
    themes
        ├── vendorName
        │   ├── themeName
        │   │   ├── lang
        │   │       └── en
        │   │           └── ...
        │   │   ├── public
        │   │   └── resources
        │   └── ...
        └── ...
```

All language files will then be registered under the Hint `theme`.
This way you can call a lang specific string using this hint. For example if you have a string `hello` translated into the file `strings` in your theme then call `@lang('theme::strings.hello')` in your view (or use other Laravel provided function to work with translations) to get the translation.
