<?php

namespace Prisma\ThemesManager\Console\Commands;

use Prisma\ThemesManager\Console\Commands\Traits\BlockMessage;
use Prisma\ThemesManager\Console\Commands\Traits\SectionMessage;
use Illuminate\Console\Command;

abstract class AbstractCommand extends Command
{
    use BlockMessage;
    use SectionMessage;

    /**
     * @var mixed
     */
    protected $theme;

    protected function validateName()
    {
        $name = $this->argument('name');

        $this->theme = \Theme::get($name);
        if (! $this->theme) {
            $this->error("Theme with name {$name} does not exists!");

            exit;
        }
    }
}
