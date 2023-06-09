<?php

namespace Codions\ThemesManager;

use Codions\ThemesManager\Events\ThemeDisabled;
use Codions\ThemesManager\Events\ThemeDisabling;
use Codions\ThemesManager\Events\ThemeEnabled;
use Codions\ThemesManager\Events\ThemeEnabling;
use Codions\ThemesManager\Facades\ThemesManager;
use Codions\ThemesManager\Traits\Autoloader;
use Codions\ThemesManager\Traits\HasConfigs;
use Codions\ThemesManager\Traits\HasHelpers;
use Codions\ThemesManager\Traits\HasProviders;
use Codions\ThemesManager\Traits\HasTranslations;
use Codions\ThemesManager\Traits\HasViews;
use Exception;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class Theme
{
    use Autoloader;
    use HasProviders;
    use HasTranslations;
    use HasViews;
    use HasHelpers;
    use HasConfigs;

    /**
     * The theme name.
     */
    protected string $name;

    /**
     * The theme vendor.
     */
    protected string $vendor;

    /**
     * The theme version.
     */
    protected string $version = '0.1';

    /**
     * The theme description.
     */
    protected string $description = '';

    /**
     * The theme path.
     */
    protected string $path;

    /**
     * The Parent theme.
     */
    protected string | Theme | null $parent = null;

    /**
     * The theme statud (enabled or not).
     */
    protected bool $enabled = false;

    /**
     * Theme extra data.
     */
    protected array $extra = [];

    /**
     * * Theme configs.
     */
    protected array $config = [];

    /**
     * The constructor.
     */
    public function __construct(string $name, string $path)
    {
        $this->setName($name);
        $this->setPath($path);

        View::prependNamespace('theme.' . Str::snake($this->name), $this->getPath('resources/views'));

        // // Add theme.THEME_NAME namespace to be able to force views from specific theme
        // View::replaceNamespace('theme', $this->getPath('resources/views'));
    }

    /**
     * Create a new Theme.
     */
    public static function make(...$arguments): self
    {
        return new static(...$arguments);
    }

    /**
     * Get path.
     */
    public function getPath(string $path = null): string
    {
        return $this->path . $path;
    }

    /**
     * Get assets path.
     */
    public function getAssetsPath(string $path = null): string
    {
        return Config::get('themes-manager.symlink_path', 'themes') . '/' . mb_strtolower($this->vendor) . '/' . mb_strtolower($this->name) . ($path ? '/' . $path : '');
    }

    /**
     * Set extra data.
     */
    public function setExtra(array $extra): self
    {
        $this->extra = $extra;

        return $this;
    }

    /**
     * Set theme version.
     */
    public function setVersion(string $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Set theme description.
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set theme name.
     */
    public function setName(string $name): self
    {
        // normalize theme name
        $name = str_replace(['-theme', 'theme-'], '', $name);

        $this->name = basename($name);
        $this->setVendor($name);

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set Theme path.
     */
    public function setPath(string $path): self
    {
        $this->path = Str::finish($path, '/');

        return $this;
    }

    /**
     * Set theme vendor.
     */
    public function setVendor(string $vendor = null): self
    {
        if (Str::contains($vendor, '/')) {
            $this->vendor = dirname($vendor);
        } else {
            $this->vendor = $vendor;
        }

        return $this;
    }

    public function getVendor(): string
    {
        return $this->vendor;
    }

    public function getNamespace(string $path = null): string
    {
        $vendor = Str::studly($this->vendor);
        $name = Str::studly($this->name);

        return "Themes\\$vendor\\$name\\" . $path;
    }

    public function getInstance(string $path, ...$params)
    {
        if (! $this->enabled()) {
            $this->requireClass($path);
        }

        $class = $this->getNamespace($path);

        if (! class_exists($class)) {
            throw new Exception("Class not found: {$class}");
        }

        return new $class(...$params);
    }

    /**
     * Check if has parent Theme.
     */
    public function hasParent(): bool
    {
        return ! is_null($this->parent);
    }

    /**
     * Set parent Theme.
     */
    public function setParent(string | Theme | null $theme): self
    {
        $this->parent = empty($theme) ? null : $theme;

        return $this;
    }

    /**
     * Get parent Theme.
     */
    public function getParent(): self | null
    {
        if (is_string($this->parent)) {
            $this->parent = ThemesManager::findByName($this->parent);
        }

        return $this->parent;
    }

    /**
     * Determine whether the current theme activated.
     */
    public function enabled(): bool
    {
        return $this->enabled;
    }

    /**
     *  Determine whether the current theme not disabled.
     */
    public function disabled(): bool
    {
        return ! $this->enabled();
    }

    /**
     * Disable the current theme.
     */
    public function disable(bool $withEvent = true): self
    {
        // Check if current is active and currently enabled
        if ($this->enabled()) {
            if ($withEvent) {
                event(new ThemeDisabling($this->name));
            }

            $this->enabled = false;

            if ($withEvent) {
                event(new ThemeDisabled($this->name));
            }
        }

        return $this;
    }

    /**
     * Enable the current theme.
     */
    public function enable(bool $withEvent = true): self
    {
        // Check if current is active and currently disabled
        if ($this->disabled()) {
            if ($withEvent) {
                event(new ThemeEnabling($this->name));
            }

            $this->enabled = true;
            $this->registerAutoloader();
            $this->loadProviders();
            $this->loadViews();
            $this->loadTranlastions();
            $this->loadHelpers();
            $this->registerLivewireComponents();

            if ($withEvent) {
                event(new ThemeEnabled($this->name));
            }
        }

        return $this;
    }

    /**
     * Get theme asset url.
     */
    public function url(string $url, bool $absolute = true): string
    {
        $url = trim($url, '/');

        // return external URLs unmodified
        if (URL::isValidUrl($url)) {
            return $url;
        }

        // Is theme folder located on the web (ie AWS)? Dont lookup parent themes...
        if (URL::isValidUrl($this->getAssetsPath())) {
            return $this->getAssetsPath($url);
        }

        // Check for valid {xxx} keys and replace them with the Theme's configuration value (in composer.json)
        if (preg_match_all('/(\{.*?\})/', $url, $matches)) {
            $url = str_replace($matches, $this->extra, $url);
        }

        // Check into Vite manifest file
        $manifesPath = $this->getAssetsPath('manifest.json');
        if (file_exists($manifesPath)) {
            $manifest = file_get_contents($manifesPath);
            $manifest = json_decode($manifest, true);

            if (array_key_exists($url, $manifest)) {
                // Lookup asset in current's theme assets path
                $fullUrl = $this->getAssetsPath($manifest[$url]['file']);

                return $absolute ? asset($fullUrl) : $fullUrl;
            }
        }

        // Lookup asset in current's theme assets path
        $fullUrl = $this->getAssetsPath($url);

        if (file_exists(public_path($fullUrl))) {
            return $absolute ? asset($fullUrl) : $fullUrl;
        }

        // If not found then lookup in parent's theme assets path
        if ($parentTheme = $this->getParent()) {
            return $parentTheme->url($url, $absolute);
        }

        // No parent theme? Lookup in the public folder.
        if (file_exists(public_path($url))) {
            return $absolute ? asset('') . $url : $url;
        }

        Log::warning("Asset [{$url}] not found for Theme [{$this->name}]");

        return ltrim(str_replace('\\', '/', $url));
    }

    /**
     * Create public assets directory path.
     */
    protected function assertPublicAssetsPath()
    {
        $themeAssetsPath = $this->getPath('public');

        if (file_exists($themeAssetsPath)) {
            $publicThemeAssetsPath = public_path($this->getAssetsPath());
            $publicThemeVendorPath = dirname($publicThemeAssetsPath);

            // Create target public theme vendor directory if required
            if (! file_exists($publicThemeVendorPath)) {
                app(Filesystem::class)->makeDirectory($publicThemeVendorPath, 0755, true);
            }

            // Create target symlink public theme assets directory if required
            if (! file_exists($publicThemeAssetsPath) && file_exists($themeAssetsPath)) {
                if (Config::get('themes-manager.symlink_relative', false)) {
                    app(Filesystem::class)->relativeLink($themeAssetsPath, rtrim($publicThemeAssetsPath, '/'));
                } else {
                    app(Filesystem::class)->link($themeAssetsPath, rtrim($publicThemeAssetsPath, '/'));
                }
            }
        }
    }
}
