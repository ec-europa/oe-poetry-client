<?php

namespace EC\Poetry\Tests\Logger;

use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

/**
 * Class TestLogger.
 *
 * @package EC\Poetry\Tests
 */
class TestLogger extends AbstractLogger
{
    /**
     * Test log storage.
     *
     * @var array
     */
    public $logs = [
        LogLevel::EMERGENCY => [],
        LogLevel::ALERT     => [],
        LogLevel::CRITICAL  => [],
        LogLevel::ERROR     => [],
        LogLevel::WARNING   => [],
        LogLevel::NOTICE    => [],
        LogLevel::INFO      => [],
        LogLevel::DEBUG     => [],
    ];

    /**
     * {@inheritdoc}
     */
    public function log($level, $message, array $context = [])
    {
        $this->logs[$level][$message] = $context;
    }

    /**
     * Get logs.
     *
     * @return array
     *   Property value.
     */
    public function getLogs()
    {
        return $this->logs;
    }
}
