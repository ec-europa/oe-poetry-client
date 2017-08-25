<?php

namespace EC\Poetry;

use EC\Poetry\Exceptions\ValidationException;
use EC\Poetry\Messages\AbstractMessage;
use EC\Poetry\Messages\MessageInterface;
use EC\Poetry\Services\Renderer;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class Client
 *
 * @package EC\Poetry\Services
 */
class Client
{
    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * SOAP server method callback.
     *
     * @var string
     */
    protected $method;

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
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Client constructor.
     *
     * @param string                                                    $username
     * @param string                                                    $password
     * @param string                                                    $method
     * @param \SoapClient                                               $soapClient
     * @param \Symfony\Component\Validator\Validator\ValidatorInterface $validator
     * @param \EC\Poetry\Services\Renderer                              $renderer
     * @param \Psr\Log\LoggerInterface                                  $logger
     */
    public function __construct(
        $username,
        $password,
        $method,
        \SoapClient $soapClient,
        ValidatorInterface $validator,
        Renderer $renderer,
        LoggerInterface $logger
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->method = $method;
        $this->renderer = $renderer;
        $this->validator = $validator;
        $this->soapClient = $soapClient;
        $this->logger = $logger;
    }

    /**
     * @param \EC\Poetry\Messages\AbstractMessage $message
     *
     * @throws \EC\Poetry\Exceptions\ValidationException
     *
     * @return \EC\Poetry\Messages\Status
     */
    public function send(AbstractMessage $message)
    {
        $this->validate($message);
        $renderedMessage = $this->renderer->render($message);

        $this->logger->info("Client request: {user} {password} {message} ", [
            'user' => $this->username,
            'password' => $this->password,
            'message' => $renderedMessage,
        ]);
        $response = $this->soapClient->{$this->method}($this->username, $this->password, $renderedMessage);
        $this->logger->info("Client response: {message} ", [
            'message' => $response,
        ]);

        return $response;
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
}
