<?php
namespace Nora\Logging\Writer;

use Nora\Logging\Writer as Base;
use Nora\Logging\Log;

/**
 * ロギング: 書き込み
 */
class FileWriter extends Base
{
    private $file;

    public function __construct(string $file)
    {
        $this->file = $file;

        if (!is_dir(dirname($this->file))) {
            mkdir(dirname($this->file), 0777);
            chmod(dirname($this->file), 0777);
        }
        if (!file_exists($this->file)) {
            touch($this->file);
            chmod($this->file, 0666);
        }
        if (!is_writable($this->file)) {
            throw new \Exception('Cant Write Log File '.$this->file);
        }
    }

    public function doWrite($log)
    {
        $fp = fopen($this->file, 'a');
        flock($fp, LOCK_EX);
        fwrite($fp, trim($log) . PHP_EOL);
        flock($fp, LOCK_UN);
        fclose($fp);
    }
}
