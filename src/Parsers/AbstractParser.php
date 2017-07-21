<?php

namespace EC\Poetry\Parsers;

use EC\Poetry\Services\Crawler;

/**
 * Class AbstractParser
 *
 * @package EC\Poetry\Parsers
 */
abstract class AbstractParser implements ParserInterface
{
    /**
     * @var \EC\Poetry\Services\Crawler
     */
    protected $crawler;

    /**
     * List of auxiliary parser services.
     *
     * @var array
     */
    private $parsers = [];

    /**
     * AbstractParser constructor.
     *
     * @param \EC\Poetry\Services\Crawler $crawler
     * @param array                       $parsers
     */
    public function __construct(Crawler $crawler, $parsers = [])
    {
        $this->crawler = $crawler;
        $this->parsers = $parsers;
    }

    /**
     * @param $name
     *
     * @return \EC\Poetry\Parsers\AbstractParser
     */
    protected function getParser($name)
    {
        return $this->parsers[$name];
    }
}
