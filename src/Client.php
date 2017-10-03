<?php

namespace EC\Poetry;

use EC\Poetry\Events\ParseResponseEvent;
use EC\Poetry\Exceptions\ParsingException;
use EC\Poetry\Exceptions\ValidationException;
use EC\Poetry\Messages\AbstractMessage;
use EC\Poetry\Messages\MessageInterface;
use EC\Poetry\Services\Renderer;
use EC\Poetry\Services\Settings;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class Client
 *
 * @package EC\Poetry\Services
 */
class Client
{
    /**
     * @var \EC\Poetry\Services\Settings
     */
    protected $settings;

    /**
     * @var \EC\Poetry\Services\Renderer
     */
    protected $renderer;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var \SoapClient
     */
    protected $soapClient;

    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcher
     */
    protected $eventDispatcher;

    /**
     * @var string
     */
    protected $method = 'requestService';

    /**
     * Client constructor.
     *
     * @param \EC\Poetry\Services\Settings                              $settings
     * @param \SoapClient                                               $soapClient
     * @param \Symfony\Component\Validator\Validator\ValidatorInterface $validator
     * @param \EC\Poetry\Services\Renderer                              $renderer
     * @param \Symfony\Component\EventDispatcher\EventDispatcher        $eventDispatcher
     */
    public function __construct(Settings $settings, \SoapClient $soapClient, ValidatorInterface $validator, Renderer $renderer, EventDispatcher $eventDispatcher)
    {
        $this->settings = $settings;
        $this->renderer = $renderer;
        $this->validator = $validator;
        $this->soapClient = $soapClient;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param \EC\Poetry\Messages\AbstractMessage $message
     *
     * @throws \EC\Poetry\Exceptions\ValidationException
     *
     * @return MessageInterface
     */
    public function send(AbstractMessage $message)
    {
        $this->validate($message);
        $renderedMessage = $this->renderer->render($message);
        $xml = $this->doSend($renderedMessage);

        return $this->parse($xml);
    }

    /**
     * Set Method property.
     *
     * @param string $method
     *   Property value.
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * Send a raw message.
     *
     * @param string $message
     *      Message string.
     *
     * @return mixed
     */
    protected function doSend($message)
    {
        $username = $this->settings->get('service.username');
        $password = $this->settings->get('service.password');

        return $this->soapClient->{$this->method}($username, $password, $message);
    }

    /**
     * @param \EC\Poetry\Messages\MessageInterface $message
     *
     * @throws \EC\Poetry\Exceptions\ValidationException
     */
    protected function validate(MessageInterface $message)
    {
        $violations = $this->validator->validate($message);
        if ($violations->count() > 0) {
            throw new ValidationException($violations);
        }
    }

    /**
     * Parse XML message into a response object.
     *
     * @param string $xml
     *
     * @return \EC\Poetry\Messages\MessageInterface
     * @throws \EC\Poetry\Exceptions\PoetryException
     */
    protected function parse($xml)
    {
        $event = new ParseResponseEvent($xml);
        $this->eventDispatcher->dispatch(ParseResponseEvent::NAME, $event);
        if (!$event->hasMessage()) {
            throw new ParsingException($xml);
        }

        return $event->getMessage();
    }
}
