<?php
namespace Nora\Logging;

abstract class Filter
{
    abstract public function filter(Log $log): bool;

    public static function create(array $filter = [])
    {
        $rc = new \ReflectionClass($filter['class']);
        return $rc->newInstanceArgs($filter['args'] ?? []);
    }
}
