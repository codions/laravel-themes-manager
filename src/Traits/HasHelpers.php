<?php

namespace Codions\ThemesManager\Traits;

trait HasHelpers
{
    public function loadHelpers()
    {
        $path = $this->getPath('src/Helpers');
        foreach (glob("{$path}/*.php") as $filename) {
            require_once $filename;
        }
    }
}
