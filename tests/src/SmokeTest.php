<?php

namespace EC\Poetry\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Class SmokeTest
 *
 * @package EC\Poetry\Tests
 */
class SmokeTest extends TestCase
{
    /**
     * Test callback.
     */
    public function testTrue()
    {
        expect(true)->to->be->true();
    }
}
