<?php

declare(strict_types=1);

namespace Nora\Logging;

class LogFactory
{
    private $class;

    public function __construct(string $class = 'Nora\Logging\Logger')
    {
        $this->class = $class;
    }

    public function __invoke($level, $message, array $context = []) : Log
    {
        if (is_string($level)) {
            $level = LogLevel::evaluate($level);
        }

        return new Log($level, $message, $context);
    }
}
