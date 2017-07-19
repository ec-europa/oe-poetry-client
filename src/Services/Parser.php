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
     * @param string $message
     *
     * @return string
     */
    public function parse($message)
    {
        // TODO: Well... parse everything basically.
        $identifier = new Messages\Components\Identifier();
        $messageObject = new Messages\RequestMessage($identifier);

        $crawler = new Crawler($message);

        return $crawler;
    }
}
