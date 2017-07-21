<?php

namespace EC\Poetry\Services;

use Symfony\Component\DomCrawler;

/**
 * Class Crawler
 *
 * @package EC\Poetry\Services
 */
class Crawler extends DomCrawler\Crawler
{
    /**
     * Get node content given its xPath expression or null if none found.
     *
     * @param string $xpath
     *
     * @return string|null
     */
    public function get($xpath)
    {
        try {
            return $this->filterXPath($xpath)->html();
        } catch (\InvalidArgumentException $e) {
            return null;
        }
    }
}
