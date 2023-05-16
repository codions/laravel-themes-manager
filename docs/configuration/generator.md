# Theme generator

If you don't want the Theme generator asking for some 'static values' you can customize generator variables through the following configuration values:
- `themes-manager.composer.vendor`: vendor name used to prefix theme package
- `themes-manager.composer.author.name`: author name
- `themes-manager.composer.author.email`: author email

This values are used by the Theme generator to fill up the `composer.json` file.

_If value is set to `null` Theme generator will ask for it during the generation process._