<?php
namespace Nora\Logging\Formatter;

use Nora\Logging\Formatter as Base;
use Nora\Logging\Log;
use Nora\Logging\LogLevel;

/**
 * Log Format
 */
class NoraFormatter extends Base
{
    public function __construct()
    {
    }

    public function format(Log $log)
    {
        return sprintf(
            "[%s] %-.4s %s %s",
            $log->getLocaltime(),
            strtoupper(
                LogLevel::$levelText[$log->getLevel()]
            ),
            $log->getMessage(),
            json_encode (
                $log->getContext(),
                JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES
            )
        );
    }
}
