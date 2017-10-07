<?php

namespace EC\Poetry\Services;

use EC\Poetry\Exceptions\ParserException;
use Symfony\Component\DomCrawler;

/**
 * Class Crawler
 *
 * @package EC\Poetry\Services
 */
class Parser extends DomCrawler\Crawler
{
    /**
     * Get node content given its xPath expression or null if none found.
     *
     * @param string $xpath
     *
     * @return string|null
     */
    public function getContent($xpath)
    {
        try {
            return $this->filterXPath($xpath)->html();
        } catch (\InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * Get node attribute given its xPath expression or null if none found.
     *
     * @param string $xpath
     * @param string $attribute
     *
     * @return string|null
     */
    public function getAttribute($xpath, $attribute)
    {
        $attributes = $this->filterXPath($xpath)->extract([$attribute]);
        if (!empty($attributes)) {
            return $attributes[0] === '' ? null : $attributes[0];
        } else {
            return null;
        }
    }

    /**
     * Get content, including outer element.
     *
     * @param string $xpath
     *
     * @return null|string
     */
    public function getOuterContent($xpath)
    {
        try {
            $node = $this->filterXPath($xpath)->getNode(0);
            $content = $node->ownerDocument->saveHTML($node);

            return $content;
        } catch (\InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * Get outer HTML of current node.
     *
     * @return string
     */
    public function outerHtml()
    {
        if (!count($this)) {
            new ParserException('The current node list is empty.');
        }

        $node = $this->getNode(0);
        $html = $node->ownerDocument->saveHTML($node);

        return $html;
    }

    /**
     * Run closure on all components in callee $this context.
     *
     * @param string   $xpath
     * @param \Closure $closure
     * @param object   $callee
     */
    public function eachComponent($xpath, \Closure $closure, $callee)
    {
        $this->filterXPath($xpath)->each(\Closure::bind($closure, $callee, $callee));
    }
}
