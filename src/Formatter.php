<?php
namespace Nora\Logging;

abstract class Formatter
{
    abstract public function format(Log $log);

    public static function create(array $formatter = [])
    {
        $class = $formatter['class'];
        return new $class($formatter);
    }
}
