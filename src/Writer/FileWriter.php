<?php
namespace Nora\Logging\Writer;

use Nora\Logging\Writer as Base;
use Nora\Logging\Log;

/**
 * ロギング: 書き込み
 */
class FileWriter extends Base
{
    public function write(Log $log)
    {
        echo $log;
    }
}
