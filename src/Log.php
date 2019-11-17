<?php
namespace Nora\Logging;

use DateTime;
use DateTimeZone;

/**
 * ロガー
 */
class Log
{
    /**
     * @var int ログレベル　
     */
    private $level;

    /**
     * @var string ログ
     */
    private $message;

    /**
     * @var array ログメタデータ
     */
    private $context = [];

    /**
     * @param int $level ログレベル
     * @param string $message ログメッセージ
     * @param array $context ログメタ
     */
    public function __construct(int $level, $message, array $context = [])
    {
        // ログ用メタデータを作成
        // $date = new DateTime('now');
        // $localtime = $date->format('Y-m-d H:i:s.u');
        // $date->setTimezone(new DateTimeZone('GMT'));
        // $gmt = $date->format('Y-m-d\TH:i:s.u\Z');

        // $meta = [
        //     'gmt' => $gmt,
        //     'localtime' => $localtime
        // ];
        //
        // return new Log($level, $category, $message, $meta);
        $this->level = $level;
        $this->message = $message;
        $this->context = $context;

        $this->date = new DateTime('now');
    }

    /**
     * レベル取得
     */
    public function getLevel() : int
    {
        return $this->level;
    }

    /**
     * コンテクスト
     */
    public function getContext() : array
    {
        return $this->context;
    }

    /**
     * GMT取得
     */
    public function getGmt() 
    {
        $this->date->setTimezone(new DateTimeZone('GMT'));
        return $this->date->format('Y-m-d\TH:i:s.u\Z');
    }

    /**
     * ローカルタイム取得
     */
    public function getLocaltime() 
    {
        return $this->date->format('Y-m-d H:i:s.u');
    }

    /**
     * メッセージ取得
     */
    public function getMessage() 
    {
        return $this->message;
    }

    /**
     * 配列化
     */
    public function toArray() : array
    {
        $message = $this->getMessage();

        $base = [
            'level' => strtoupper(LogLevel::$levelText[$this->getLevel()]),
            'gmt' => $this->getGmt(),
            'localtime' => $this->getLocaltime(),
            'context' => $this->getContext(),
        ];

        if (is_string($message)) {
            $base['message'] = $message;
        } else {
            foreach ($message as $k => $v) {
                $base[$k] = $v;
            }
        }

        return $base;
    }
}
