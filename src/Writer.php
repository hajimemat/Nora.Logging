<?php
namespace Nora\Logging;


/**
 * ロギング: 書き込み
 */
abstract class Writer
{
    private $formatter;
    private $filter;

    public static function create(array $writers = [])
    {
        return (new \ReflectionClass($writers['class']))->newInstanceArgs($writers['args'] ?? []);
    }

    public function write(Log $log)
    {
        if ($this->filter($log)) {
            $this->doWrite($this->format($log));
            return true;
        }
        return false;
    }

    abstract protected function doWrite($log);

    public function setFormatter(Formatter $formatter)
    {
        $this->formatter = $formatter;
    }

    public function setFilter(Filter $filter)
    {
        $this->filter = $filter;
    }

    protected function format(Log $log)
    {
        return $this->formatter->format($log);
    }

    protected function filter(Log $log)
    {
        return $this->filter->filter($log);
    }
}
