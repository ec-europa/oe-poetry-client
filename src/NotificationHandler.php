<?php

namespace EC\Poetry;

use EC\Poetry\Events\TranslationReceived;
use EC\Poetry\Exceptions\Notifications\CannotAuthenticateException;
use EC\Poetry\Messages\Components\Traits\ParserAwareTrait;
use EC\Poetry\Messages\Responses\Status;
use EC\Poetry\Services\Parser;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class NotificationHandler
 *
 * @package EC\Poetry
 */
class NotificationHandler
{
    use ParserAwareTrait;

    const TYPE_TRANSLATION_RECEIVED = 'notification.translation_received';

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcher
     */
    private $eventDispatcher;

    /**
     * @var \EC\Poetry\Services\Parser
     */
    private $parser;

    /**
     * @var \EC\Poetry\Messages\Responses\Status
     */
    private $statusResponse;

    /**
     * NotificationHandler constructor.
     *
     * @param string                                             $username
     * @param string                                             $password
     * @param \Symfony\Component\EventDispatcher\EventDispatcher $eventDispatcher
     * @param \EC\Poetry\Services\Parser                         $parser
     * @param \EC\Poetry\Messages\Responses\Status               $statusResponse
     */
    public function __construct($username, $password, EventDispatcher $eventDispatcher, Parser $parser, Status $statusResponse)
    {
        $this->username = $username;
        $this->password = $password;
        $this->parser = $parser;
        $this->eventDispatcher = $eventDispatcher;
        $this->statusResponse = $statusResponse;
    }

    /**
     * Handle incoming Poetry notification.
     *
     * @param string $username
     * @param string $password
     * @param string $xml
     *
     * @throws \EC\Poetry\Exceptions\Notifications\CannotAuthenticateException
     */
    public function handle($username, $password, $xml)
    {
        if (!$this->doesAuthenticate($username, $password)) {
            throw new CannotAuthenticateException();
        }

        $type = $this->getType($xml);

        $message = $this->statusResponse->fromXml($xml);
        $event = new TranslationReceived($message);
        $this->eventDispatcher->dispatch(TranslationReceived::NAME, $event);
    }

    /**
     * @param $username
     * @param $password
     *
     * @return bool
     */
    protected function doesAuthenticate($username, $password)
    {
        return $this->username == $username && $this->password == $password;
    }

    /**
     * Get notification message type.
     *
     * @param string $xml
     *
     * @return null|string
     */
    protected function getType($xml)
    {
        $parser = $this->getParser();
        $parser->addXmlContent($xml);
        $type = $parser->getAttribute('POETRY/request', 'type');

        return $type;
    }
}
