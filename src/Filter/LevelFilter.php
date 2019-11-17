<?php
namespace Nora\Logging\Filter;

use Nora\Logging\Filter as Base;
use Nora\Logging\Log;
use Nora\Logging\LogLevel;

/**
 * Log Format
 */
class LevelFilter extends Base
{
    public function __construct($level)
    {
        if (is_string($level)) {
            $level = LogLevel::evaluate($level);
        }
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
