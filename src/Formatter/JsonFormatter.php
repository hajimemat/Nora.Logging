<?php
namespace Nora\Logging\Formatter;

use Nora\Logging\Formatter as Base;
use Nora\Logging\Log;

/**
 * Log Format
 */
class JsonFormatter extends Base
{
    public function format(Log $log)
    {
        return json_encode($log->toArray(), JSON_UNESCAPED_UNICODE);
    }
}
