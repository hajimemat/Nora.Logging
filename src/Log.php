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
     * @var string ログカテゴリ
     */
    private $category;

    /**
     * @var array ログメタデータ
     */
    private $meta = [];

    /**
     * ログデータを作る
     */
    public function create(int $level, $message, string $category = "default") : self
    {
        // ログ用メタデータを作成
        $date = new DateTime('now');
        $localtime = $date->format('Y-m-d H:i:s.u');
        $date->setTimezone(new DateTimeZone('GMT'));
        $gmt = $date->format('Y-m-d\TH:i:s.u\Z');

        $meta = [
            'gmt' => $gmt,
            'localtime' => $localtime
        ];

        return new Log($level, $category, $message, $meta);
    }

    /**
     * @param int $level ログレベル
     * @param string $category ログカテゴリ
     * @param mixed $message ログメッセージ
     * @param array $meta ログメタ
     */
    public function __construct(int $level, string $category, $message, array $meta = [])
    {
        $this->level    = $level;
        $this->category = $category;
        $this->message  = $message;
        $this->meta     = $meta;
    }

    /**
     * レベル取得
     */
    public function getLevel() : int
    {
        return $this->level;
    }

    /**
     * カテゴリ取得
     */
    public function getCategory() : string
    {
        return $this->category;
    }

    /**
     * GMT取得
     */
    public function getGmt() 
    {
        return $this->meta['gmt'] ?? null;
    }

    /**
     * ローカルタイム取得
     */
    public function getLocaltime() 
    {
        return $this->meta['localtime'] ?? null;
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
            'category' => $this->getCategory(),
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
