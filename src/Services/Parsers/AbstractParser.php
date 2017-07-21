<?php

namespace EC\Poetry\Services\Parsers;

use EC\Poetry\Services\Crawler;

/**
 * Class AbstractParser
 *
 * @package EC\Poetry\Services\Parsers
 */
abstract class AbstractParser implements ParserInterface
{
    /**
     * @var \EC\Poetry\Services\Crawler
     */
    protected $crawler;

    /**
     * AbstractParser constructor.
     *
     * @param \EC\Poetry\Services\Crawler $crawler
     */
    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }
}
