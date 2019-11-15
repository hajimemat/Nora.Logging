<?php
namespace Nora\Logging;


/**
 * ロギング: 書き込み
 */
abstract class Writer
{
    public static function create(array $writers = [])
    {
        return new Writer\FileWriter();
    }

    abstract public function write(Log $log);
}
