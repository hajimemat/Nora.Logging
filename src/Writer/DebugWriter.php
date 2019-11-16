<?php
namespace Nora\Logging\Writer;

use Nora\Logging\Writer as Base;
use Nora\Logging\Log;

/**
 * ロギング: 書き込み
 */
class DebugWriter extends Base
{
    protected function doWrite($log)
    {
        echo $log;
    }
}
