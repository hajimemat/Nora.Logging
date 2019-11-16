<?php
namespace Nora\Logging;

/**
 * ロギングのテスト
 */
use PHPUnit\Framework\TestCase;

class LoggingTest extends TestCase
{
    public function testLogFormat()
    {
        $log = Log::create(LogLevel::LEVEL_DEBUG, "テスト", 'test');

        $this->assertEquals(LogLevel::LEVEL_DEBUG, $log->getLevel());
        $this->assertEquals("test", $log->getCategory());

        $Formatter = Formatter::create([
            'class' => Formatter\NoraFormatter::class
        ]);

        $this->assertRegExp("/テスト/", $Formatter->format($log));

        $Formatter = Formatter::create([
            'class' => Formatter\JsonFormatter::class
        ]);

        $this->assertRegExp("/テスト/", $Formatter->format($log));

        $Formatter = Formatter::create([
            'class' => Formatter\FlatFormatter::class
        ]);

        $this->assertRegExp("/テスト/", $Formatter->format($log));
    }

    public function testLogFilter()
    {
        $log = Log::create(LogLevel::LEVEL_DEBUG, "テスト", 'test');

        $Filter = Filter::create([
            'class' => Filter\LevelFilter::class,
            'args' => [
                LogLevel::LEVEL_TRACE
            ]
        ]);

        $this->assertFalse($Filter->filter($log));

        $Filter = Filter::create([
            'class' => Filter\LevelFilter::class,
            'args' => [
                LogLevel::LEVEL_WARNING
            ]
        ]);

        $this->assertFalse($Filter->filter($log));

        $Filter = Filter::create([
            'class' => Filter\LevelFilter::class,
            'args' => [
                LogLevel::LEVEL_DEBUG
            ]
        ]);

        $this->assertTrue($Filter->filter($log));
    }

    public function testLogWriter()
    {

        $Writer = Writer::create([
            'class' => Writer\DebugWriter::class,
        ]);

        // フォーマットをセット
        $Writer->setFormatter(Formatter::create([
            'class' => Formatter\NoraFormatter::class
        ]));

        // フィルターをセット
        $Writer->setFilter(Filter::create([
            'class' => Filter\LevelFilter::class,
            'args' => [
                LogLevel::LEVEL_DEBUG
            ]
        ]));


        $log = Log::create(LogLevel::LEVEL_DEBUG, "テスト", 'test');
        $this->assertTrue($Writer->write($log));

        $log = Log::create(LogLevel::LEVEL_TRACE, "トレース", 'test');
        $this->assertFalse($Writer->write($log));
    }

    public function testLogLogger()
    {
        $Logger = Logger::create([
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

        $cnt = $Logger->debug('デバッグメッセージ');
        $this->assertEquals(1, $cnt);
    }
}
