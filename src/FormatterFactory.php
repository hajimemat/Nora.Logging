<?php

declare(strict_types=1);

namespace Nora\Logging;

class FormatterFactory
{
    public function __invoke(array $formatter) : Formatter
    {
        $class = $formatter['class'];
        return new $class($formatter);
    }
}
