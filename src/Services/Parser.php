<?php

namespace EC\Poetry\Services;

use Symfony\Component\DomCrawler\Crawler;
use EC\Poetry\Messages;

/**
 * Class Parser
 *
 * @package EC\Poetry\Services
 */
class Parser
{
    /**
     * @var \Symfony\Component\DomCrawler\Crawler
     */
    protected $crawler;

    /**
     * Parser constructor.
     *
     * @param \Symfony\Component\DomCrawler\Crawler $crawler
     */
    public function __construct(\Symfony\Component\DomCrawler\Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * @param string $xml
     *
     * @return string
     */
    public function parse($xml)
    {
        $this->crawler->addXmlContent($xml);


        // TODO: Well... parse everything basically.
        $identifier = new Messages\Components\Identifier();
        $messageObject = new Messages\RequestMessage($identifier);

        $crawler = new Crawler($xml);

        return $crawler;
    }
}
