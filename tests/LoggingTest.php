<?php
namespace Nora\Logging;

/**
 * ロギングのテスト
 */
use PHPUnit\Framework\TestCase;

use Psr\Log\LoggerInterface;

class LoggingTest extends TestCase
{
    public function testLogFormat()
    {
        $log = (new LogFactory)('debug', "テスト", ['from' => 'test']);

        $this->assertEquals(LogLevel::LEVEL_DEBUG, $log->getLevel());
        $this->assertEquals(['from' => 'test'], $log->getContext());

        $Formatter = (new FormatterFactory)([
            'class' => Formatter\NoraFormatter::class
        ]);

        $this->assertRegExp("/テスト/", $Formatter->format($log));

        $Formatter = (new FormatterFactory)([
            'class' => Formatter\JsonFormatter::class
        ]);

        $this->assertRegExp("/テスト/", $Formatter->format($log));

        $Formatter = (new FormatterFactory)([
            'class' => Formatter\FlatFormatter::class
        ]);

        $this->assertRegExp("/テスト/", $Formatter->format($log));
    }

    public function testLogFilter()
    {
        $log = (new LogFactory)('debug', "テスト", ['from' => 'test']);

        $Filter = (new FilterFactory)([
            'class' => Filter\LevelFilter::class,
            'args' => [
                LogLevel::LEVEL_TRACE
            ]
        ]);

        $this->assertFalse($Filter->filter($log));

        $Filter = (new FilterFactory)([
            'class' => Filter\LevelFilter::class,
            'args' => [
                LogLevel::LEVEL_WARNING
            ]
        ]);

        $this->assertFalse($Filter->filter($log));

        $Filter = (new FilterFactory)([
            'class' => Filter\LevelFilter::class,
            'args' => [
                LogLevel::LEVEL_DEBUG
            ]
        ]);

        $this->assertTrue($Filter->filter($log));
    }

    public function testLogWriter()
    {

        $Writer = (new WriterFactory)([
            'class' => Writer\DebugWriter::class,
        ]);

        // フォーマットをセット
        $Writer->setFormatter((new FormatterFactory)([
            'class' => Formatter\NoraFormatter::class
        ]));

        // フィルターをセット
        $Writer->setFilter((new FilterFactory)([
            'class' => Filter\LevelFilter::class,
            'args' => [
                LogLevel::LEVEL_DEBUG
            ]
        ]));


        $log = (new LogFactory)('debug', "テスト");
        $this->assertTrue($Writer->write($log));

        $log = (new LogFactory)('trace', "トレース");
        $this->assertFalse($Writer->write($log));
    }

    public function testLogLogger()
    {
        $logger = (new LoggerFactory)([
            'writers' => [
                [
                    'class' => Writer\DebugWriter::class,
                    'formatter' => [
                        'class' => Formatter\NoraFormatter::class
                    ],
                    'filter' => [
                        'class' => Filter\LevelFilter::class,
                        'args' => [
                            LogLevel::LEVEL_DEBUG
                        ]
                    ]
                ]
            ]
        ]);

        $logger->debug('デバッグメッセージ');
        $logger->warning('デバッグメッセージ');

        $this->assertInstanceOf(LoggerInterface::class, $logger);
    }
}
