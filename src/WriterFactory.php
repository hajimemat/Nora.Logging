<?php

declare(strict_types=1);

namespace Nora\Logging;

class WriterFactory
{
    public function __invoke(array $writer) : Writer
    {
        $rc = new \ReflectionClass($writer['class']);
        return $rc->newInstanceArgs($writer['args'] ?? []);
    }
}
