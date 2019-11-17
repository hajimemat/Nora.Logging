<?php

declare(strict_types=1);

namespace Nora\Logging;

class FilterFactory
{
    public function __invoke(array $filter) : Filter
    {
        $rc = new \ReflectionClass($filter['class']);
        return $rc->newInstanceArgs($filter['args'] ?? []);
    }
}
