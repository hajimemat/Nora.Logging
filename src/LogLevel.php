<?php
namespace Nora\Logging;

/**
 * ログレベル
 */
abstract class LogLevel
{
    const LEVEL_TRACE     = 0b1;
    const LEVEL_DEBUG     = 0b10;
    const LEVEL_INFO      = 0b100;
    const LEVEL_NOTICE    = 0b1000;
    const LEVEL_WARNING   = 0b10000;
    const LEVEL_ERROR     = 0b100000;
    const LEVEL_CRITICAL  = 0b1000000;
    const LEVEL_ALERT     = 0b10000000;
    const LEVEL_EMERGENCY = 0b100000000;
    const LEVEL_STRICT    = 0b1000000000;
    const LEVEL_ALL       = 0b11111111111111111;

    public static $levelText = array(
        self::LEVEL_TRACE     => "trace",
        self::LEVEL_DEBUG     => "debug",
        self::LEVEL_INFO      => "info",
        self::LEVEL_NOTICE    => "notice",
        self::LEVEL_WARNING   => "warning",
        self::LEVEL_ERROR     => "error",
        self::LEVEL_CRITICAL  => "critical",
        self::LEVEL_ALERT     => "alert",
        self::LEVEL_EMERGENCY => "emergency",
        self::LEVEL_STRICT    => "strict"
    );

    public static function convertPHPErrorNo(int $eno)
    {
        switch ($eno) {
            case E_USER_DEPRECATED:
            case E_DEPRECATED:
                return self::LEVEL_STRICT;
            case E_NOTICE:
            case E_STRICT:
                return self::LEVEL_NOTICE;
            break;
            case E_WARNING:
            case E_USER_WARNING:
                return self::LEVEL_WARNING;
            break;
            case E_ERROR:
            case E_USER_ERROR:
            case E_PARSE:
            default:
                return self::LEVEL_ERROR;
            break;
        }
    }

    public static function evaluate($cond) : int
    {
        if (is_string($cond)) {
            $parts = preg_split('/\s*([&^|])\s*/', $cond, -1, PREG_SPLIT_DELIM_CAPTURE);
            $level = 0;
            $cond = null;
            foreach ($parts as $k => $v) {
                if (($k % 2) !== 0) { // 偶数
                    $cond = $v;
                    continue;
                }

                $new = constant("self::LEVEL_".strtoupper($v));
                switch ($cond) {
                    case '^':
                        $level ^= $new;
                        break;
                    case '|':
                        $level |= $new;
                        break;
                    default:
                        $level = $new;
                        break;
                }
            }

            return $level;
        }
        return $cond;
    }
}
