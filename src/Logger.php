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

    /**
     * トレースログを発行する
     */
    public function trace($message)
    {
        var_Dump($message);
        throw new \Exception($message);
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
