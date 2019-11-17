<?php
namespace Nora\Logging;

abstract class Formatter
{
    abstract public function format(Log $log);
}
