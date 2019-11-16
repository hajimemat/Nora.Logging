<?php
namespace Nora\Logging\Filter;

use Nora\Logging\Filter as Base;
use Nora\Logging\Log;

/**
 * Log Format
 */
class LevelFilter extends Base
{
    public function __construct($level)
    {
        $this->level = $level;
    }

    public function filter(Log $log) : bool
    {
        if ($log->getLevel() & $this->level) {
            return true;
        }
        return false;
    }
}
