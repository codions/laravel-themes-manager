<?php

namespace Codions\ThemesManager\Exceptions;

class ThemeLoaderException extends \RuntimeException
{
    /**
     * @return \Codions\ThemesManager\Exceptions\ThemeLoaderException
     */
    public static function duplicate(string $name): self
    {
        return new static(sprintf(
            'A theme named "%s" already exists.',
            $name
        ));
    }
}
