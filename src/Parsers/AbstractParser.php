<?php

namespace EC\Poetry\Parsers;

use EC\Poetry\Services\Crawler;
use Pimple\Container;

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
     * List of auxiliary component parsers.
     *
     * @var \Pimple\Container
     */
    private $parsers;

    /**
     * AbstractParser constructor.
     *
     * @param \EC\Poetry\Services\Crawler $crawler
     * @param \Pimple\Container|null      $parsers
     */
    public function __construct(Crawler $crawler, Container $parsers = null)
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
        return $this->parsers['parser.component.'.$name];
    }
}
