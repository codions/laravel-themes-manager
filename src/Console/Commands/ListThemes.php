<?php

namespace Codions\ThemesManager\Console\Commands;

use Codions\ThemesManager\Facades\ThemesManager;
use Illuminate\Console\Command;

class ListThemes extends Command
{
    /**
     * The console command name.
     */
    protected $name = 'theme:list';

    /**
     * The console command description.
     */
    protected $description = 'List all registered themes';

    /**
     * The table headers for the command.
     */
    protected $headers = ['Name', 'Vendor', 'Version', 'Description', 'Extends', 'Default', 'Active'];

    /**
     * List of existing themes.
     */
    protected array $themes = [];

    /**
     * Prompt for module's alias name.
     */
    public function handle()
    {
        $themes = ThemesManager::all();

        foreach ($themes as $theme) {
            $this->themes[] = [
                'name' => $theme->getName(),
                'vendor' => $theme->getVendor(),
                'version' => $theme->getVersion(),
                'description' => $theme->getDescription(),
                'extends' => $theme->getParent() ? $theme->getParent()->getName() : '',
                'default' => $theme->getName() === config('themes-manager.fallback_theme') ? 'X' : '',
            ];
        }

        if (0 == count($this->themes)) {
            $this->error("Your application doesn't have any theme.");
        } else {
            $this->table($this->headers, $this->themes);
        }
    }
}
