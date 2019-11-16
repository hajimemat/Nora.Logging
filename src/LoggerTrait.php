<?php
namespace Nora\Logging;

trait LoggerTrait
{
    public function trace()
    {
        $args = func_get_args();
        array_unshift($args, LogLevel::LEVEL_TRACE);
        return $this->log(call_user_func_array([$this, "createLog"], $args));
    }

    public function debug()
    {
        $args = func_get_args();
        array_unshift($args, LogLevel::LEVEL_DEBUG);
        return $this->log(call_user_func_array([$this, "createLog"], $args));
    }

    public function info()
    {
        $args = func_get_args();
        array_unshift($args, LogLevel::LEVEL_INFO);
        return $this->log(call_user_func_array([$this, "createLog"], $args));
    }

    public function notice()
    {
        $args = func_get_args();
        array_unshift($args, LogLevel::LEVEL_NOTICE);
        return $this->log(call_user_func_array([$this, "createLog"], $args));
    }

    public function warning()
    {
        $args = func_get_args();
        array_unshift($args, LogLevel::LEVEL_WARNING);
        return $this->log(call_user_func_array([$this, "createLog"], $args));
    }

    public function error()
    {
        $args = func_get_args();
        array_unshift($args, LogLevel::LEVEL_ERROR);
        return $this->log(call_user_func_array([$this, "createLog"], $args));
    }

    public function critical()
    {
        $args = func_get_args();
        array_unshift($args, LogLevel::LEVEL_CRITICAl);
        return $this->log(call_user_func_array([$this, "createLog"], $args));
    }

    public function alert()
    {
        $args = func_get_args();
        array_unshift($args, LogLevel::LEVEL_ALERT);
        return $this->log(call_user_func_array([$this, "createLog"], $args));
    }

    public function emergency()
    {
        $args = func_get_args();
        array_unshift($args, LogLevel::LEVEL_EMERGENCY);
        return $this->log(call_user_func_array([$this, "createLog"], $args));
    }
}
