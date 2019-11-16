<?php
namespace Nora\Logging;

/**
 * ロガー
 */
class Logger
{
    use LoggerTrait;

    private $writers = [];

    public static function create($spec) : Logger
    {
        $Logger = new self();

        foreach ($spec['writers'] as $writer) {
            $Writer = Writer::create([
                'class' => $writer['class']
            ]);
            // フォーマットをセット
            $Writer->setFormatter(Formatter::create($writer['formatter']));
            $Writer->setFilter(Filter::create($writer['filter']));

            $Logger->addWriter($Writer);
        }
        return $Logger;
    }

    public function __construct()
    {
    }

    public function addWriter(Writer $writer)
    {
        $this->writers[] = $writer;
    }

    protected function log(Log $log)
    {
        $cnt = 0;
        foreach ($this->writers as $writer)
        {
            $cnt += $writer->write($log) ? 1: 0;
        }
        return $cnt;
    }

    public function createLog($level, $message)
    {
        return Log::create($level, $message);
    }

    /**
     * PHPのエラーをログに変換する
     */
    public function phpErrorReport($eno, $emsg, $efile, $eline)
    {
        $this->log(call_user_func_array([$this, "createLog"], [
            LogLevel::convertPHPErrorNo($eno),
            [
                "message" => $emsg,
                "error_reporting" => error_reporting(),
                "php_error_no" => $eno,
                "php_error_file" => $efile,
                "php_error_line" => $eline
            ]
        ]));
    }

    /**
     * PHPのエクセプションをログに変換する
     */
    public function phpException(\Throwable $exception)
    {
        $level = Log::LEVEL_ERROR;
        if ($exception instanceof LoggableExceptionInterface) {
            $level = $exception->getPriority();
        }

        $log = call_user_func_array([$this, "createLog"], [
            $level,
            [
                "message" => (string) $exception->getMessage(),
                "file" => (string) $exception->getFile(),
                "line" => (string) $exception->getLine(),
                "exception" => (string) get_class($exception),
                "trace" =>  explode("\n", $exception->getTraceAsString())
            ]
        ]);
        $log->category = get_class($exception);
        $this->log($log);
    }
}
