<?php

declare(strict_types=1);

namespace Nora\Logging;

class LoggerFactory
{
    private $class;

    public function __construct(string $class = 'Nora\Logging\Logger')
    {
        $this->class = $class;
    }

    public function __invoke($spec) : Logger
    {
        $Logger = (new \ReflectionClass($this->class))->newInstance();

        foreach ($spec['writers'] as $writer) {
            $Writer = (new WriterFactory)([
                'class' => $writer['class']
            ]);
            // フォーマットをセット
            $Writer->setFormatter((new FormatterFactory)($writer['formatter']));
            $Writer->setFilter((new FilterFactory)($writer['filter']));

            $Logger->addWriter($Writer);
        }
        return $Logger;
    }
}
