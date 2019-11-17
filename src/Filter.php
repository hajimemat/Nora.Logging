<?php
namespace Nora\Logging;

abstract class Filter
{
    abstract public function filter(Log $log): bool;
}
