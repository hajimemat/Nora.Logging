<?php
namespace Nora\Logging\Formatter;

use Nora\Logging\Formatter as Base;
use Nora\Logging\Log;

/**
 * Log Format
 */
class FlatFormatter extends Base
{
    public function format(Log $log)
    {
        return $this->flatten($log->toArray());
    }

    private function flatten(array $data, $key = null)
    {
        foreach ($data as $k => $v) {
            if (is_array($v)) {
                $text[] = $this->flatten($v, $k.".");
            } else {
                $v = preg_replace("/[\r\n]/", "\\n", $v);
                $text[] = sprintf("{$key}{$k}={$v}");
            }
        }
        return implode("\t", $text);
    }
}
