<?php

namespace EC\Poetry\Messages\Responses;

use EC\Poetry\Messages\ParserAwareInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Interface ResponseInterface
 *
 * @package EC\Poetry\Messages\Responses
 */
interface ResponseInterface extends ParserAwareInterface, EventSubscriberInterface
{

}
