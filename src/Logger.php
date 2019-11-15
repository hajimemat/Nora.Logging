<?php
namespace Nora\Logging;


/**
 * ロガー
 */
class Logger
{
    private $writers = [];

    public function __construct()
    {
    }

    public function addWriter(Writer $writer)
    {
        $this->writers[] = $writer;
    }
}
