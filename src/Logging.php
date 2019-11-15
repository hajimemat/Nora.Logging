<?php
namespace Nora\Logging;


/**
 * ロギング
 */
abstract class Logging
{
    public static function createLogger(array $writers = [])
    {
        $logger = new Logger();

        foreach ($writers as $writer) {
            $logger->addWriter(Writer::create($writer));
        }
        return $logger;
    }
}
