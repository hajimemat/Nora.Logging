<?php
namespace Nora\Logging;

use Psr;

/**
 * ロガー
 */
class Logger implements Psr\Log\LoggerInterface
{
    use Psr\Log\LoggerTrait;

    /**
     * @var Writer[]
     */
    private $writers = [];

    /**
     * @var array
     */
    private $context = [];

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     *
     * @return void
     *
     * @throws \Psr\Log\InvalidArgumentException
     */
    public function log($level, $message, array $context = array())
    {
        $log = (new LogFactory)(
            $level,
            $message,
            $context += $this->context
        );

        foreach ($this->writers as $writer) {
            $writer->write($log);
        }
    }

    /**
     * Writerを追加
     */
    public function addWriter(Writer $writer)
    {
        $this->writers[] = $writer;
    }

    /**
     * コンテクストを作成する
     */
    public function context(array $context)
    {
        $logger = new static();
        $logger->writers = $this->writers;
        $logger->context = $this->context + $context;
        return $logger;
    }
}
