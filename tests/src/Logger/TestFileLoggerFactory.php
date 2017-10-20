<?php

namespace EC\Poetry\Tests\Logger;

use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Class TestFileLoggerFactory
 *
 * @package EC\Poetry\Tests\Logger
 */
class TestFileLoggerFactory
{
    /**
     * @param string $file
     *
     * @return \Monolog\Logger
     */
    public static function getInstance($file)
    {
        @unlink($file);
        $formatter = new JsonFormatter();
        $stream = new StreamHandler($file);
        $stream->setFormatter($formatter);

        return new Logger('Test File Logger', [$stream]);
    }
}
