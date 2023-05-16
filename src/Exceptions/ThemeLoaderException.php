<?php

namespace Prisma\ThemesManager\Exceptions;

class ThemeLoaderException extends \RuntimeException
{
    /**
     * @return \Prisma\ThemesManager\Exceptions\ThemeLoaderException
     */
    public static function duplicate(string $name): self
    {
        return new static(sprintf(
            'A theme named "%s" already exists.',
            $name
        ));
    }
}
