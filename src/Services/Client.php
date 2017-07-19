<?php

namespace EC\Poetry\Services;

use EC\Poetry\Messages\AbstractMessage;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class Client
 *
 * @package EC\Poetry\Services
 */
class Client
{

    const POETRY_PATH = '';
    const POETRY_METHOD = '';
    /**
     * @var Renderer
     */
    private $renderer;
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * Renderer constructor.
     *
     * @param Renderer           $renderer
     * @param ValidatorInterface $validator
     */
    public function __construct(Renderer $renderer, ValidatorInterface $validator)
    {
        $this->renderer = $renderer;
        $this->validator = $validator;
    }

    /**
     * @param AbstractMessage $message
     * @param string          $user
     * @param string          $password
     * @param string          $path
     * @param string          $method
     *
     * @return string
     *
     * @throws \Exception
     */
    public function send(AbstractMessage $message, $user, $password, $path = '', $method = '')
    {
        if (empty($path)) {
            $path = $this::POETRY_PATH;
        }
        if (empty($method)) {
            $method = $this::POETRY_METHOD;
        }
        $violations = $this->validator->validate($message);
        if ($violations->count() > 0) {
            throw new \Exception("Didn't validate");
        }

        $renderedMessage = $this->renderer->render($message);

        $soapClient = new SoapClient($path, array(
            'cache_wsdl' => WSDL_CACHE_NONE,
        ));

        $response = $soapClient->$method($user, $password, $renderedMessage);

        return $response;
    }
}
